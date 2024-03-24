<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$session_user_type_id = $_SESSION['user_type_id'];
		$session_user_institution_id = $_SESSION['user_institution_id'];
		$eventArray = array();
		if(isset($_POST['id'])){
			if($stmt = $conn->prepare("SELECT schedule.schedule_id, schedule.schedule_type, schedule.exhibition_id, schedule.schedule_start, schedule.schedule_end, exhibitions.institution_id FROM schedule, exhibitions WHERE exhibitions.exhibition_id = schedule.exhibition_id AND schedule.exhibition_id=?")){
				$stmt->bind_param('i', $_POST['id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($schedule_id, $schedule_type, $exhibition_id, $schedule_start, $schedule_end, $u_institution_id);
					while ($stmt->fetch()) {
						$color = '#9ceef8';
						$title = 'Available for guided tour';
						if($schedule_type==2){
							$color = '#74fcbd';
							$title = 'Available for self-guided tour';
						}
						$rowArray = array('id'=>$schedule_id, 'title'=>$title, 'description'=>'Test', 'start'=>$schedule_start, 'end'=>$schedule_end, 'overlap'=>'false', 'color'=>$color);
						array_push($eventArray, $rowArray);
					}
			}else{
				//echo $_POST['id'];
				http_response_code(402);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Exhibit not found!"));
				die();
			}
		}
	}else{
		//echo $_POST['id'];
		http_response_code(401);

		// return a JSON object with a message property
		echo json_encode(array("message" => "There was an error processing the request"));
		die();
	}
	
	
	  /*
		  
	$eventArray = array(
		array('start'=>'2023-09-08T09:00:00', 'end'=>'2023-09-08T10:00:00', 'overlap'=>'false', 'display'=>'background', 'color'=>'#ff9f89'),
		array('start'=>'2023-09-08T10:00:00', 'end'=>'2023-09-08T11:00:00', 'overlap'=>'false', 'display'=>'background', 'color'=>'#ff9f89'),
		array('start'=>'2023-09-08T14:00:00', 'end'=>'2023-09-08T15:00:00', 'overlap'=>'false', 'display'=>'background', 'color'=>'#ff9f89')
	);
*/

?>

<script src='assets/javascripts/fullcalendar/index.global.js'></script>
<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

					<div class="row">
						<div class="col-md-12">
							<form id="selects-form" action="forms-validation.html">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Scheduler</h2>
										<p class="panel-subtitle">
											Create tour availability schedule
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Tour length (hours)<span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" id="tourlength" name="tourlength" class="form-control" value="2" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Museum</label>
											<div class="col-sm-9">
												<select id="museum-schedule" class="form-control" required>
													<option value="">Choose a museum</option>
													<?php
													$sql_query = "";
													if($session_user_type_id == 2){
														$sql_query = "SELECT institution_id, institution_name FROM institutions WHERE institution_type='museum' AND institution_id = " . $session_user_institution_id;
													}
													if($session_user_type_id == 1){
														$sql_query = "SELECT institution_id, institution_name FROM institutions WHERE institution_type='museum'";
													}
													if($stmt = $conn->prepare($sql_query)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($institution_id, $institution_name);
														while ($stmt->fetch()) {
													?>
													<option <?php if(isset($_POST['id'])){if($u_institution_id == $institution_id) echo 'selected';}?> value="<?php echo $institution_id?>"><?php echo $institution_name?></option>
													<?php
														}
														$stmt->close();
													}
													
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="exhibition-schedule" class="form-control" required>
													<option value="">Choose an exhibition</option>
													<?php
													$sql_query = "";
													if($session_user_type_id == 2){
														$sql_query = "SELECT exhibition_id, institution_id, exhibition_title FROM exhibitions WHERE institution_id = " . $session_user_institution_id;
													}
													if($session_user_type_id == 1){
														$sql_query = "SELECT exhibition_id, institution_id, exhibition_title FROM exhibitions";
													}
													if($stmt = $conn->prepare("SELECT exhibition_id, institution_id, exhibition_title FROM exhibitions")){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($exhibition_id, $institution_id, $exhibition_title);
														while ($stmt->fetch()) {
													?>
													<option <?php if(isset($_POST['id'])){if($_POST['id'] == $exhibition_id) echo 'selected';}?> data-institution-id="<?php echo $institution_id ?>" value="<?php echo $exhibition_id?>"><?php echo $exhibition_title?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label">Scheduler (please define the available time-slots for guided or self-organized tours)</label>
											<div class="col-sm-12">
												<div id='calendar'></div>
											</div>
										</div>
									</div>
									
								</section>
							</form>
						</div>
					</div>
					
						
						<div id="calendarModalDelete" class="modal fade" role="dialog">
							<form id="delete-timeslot-form" method="post">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 id="modalTitle" class="modal-title">Do you like to delete this time-slot?</h4>
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
										</div>
										<input type="hidden" id="schedule_id" name="schedule_id" value="">
										<input type="hidden" id="exhibition_id" name="exhibition_id" value="<?php echo $exhibition_id?>">
										<div id="modalBody" class="modal-body">Deleting items is irreversable process. Do you like to continue? </div>
										<div class="modal-footer">
											<button class="btn btn-primary">Delete</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<label class="error return-message"></label>
										</div>
									</div>
								</div>
							</form>
						</div>
						
						<div id="calendarModalInsert" class="modal fade" role="dialog">
							<form id="insert-timeslot-form" method="post">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 id="insertmodalTitle" class="modal-title">New time-slot definition</h4>
											<button type="button" class="close" data-dismiss="modal" style="margin-top: -27px; opacity:0.9;"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
										</div>
										<input type="hidden" id="exhibition_id" name="exhibition_id" value="<?php echo $exhibition_id?>">
										<div id="insertmodalBody" class="modal-body">
											<div class="form-group">
												<label class="col-sm-4 control-label">Start time</label>
												<div class="col-sm-8">
													<input type="text" id="starttime" name="starttime" class="form-control" required/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">End time</label>
												<div class="col-sm-8">
													<input type="text" id="endtime" name="endtime" class="form-control" required/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">Tour type</label>
												<div class="col-sm-8">
													<select id="tour-type" class="form-control" required>
														<option value="1">Guided tour</option>
														<option value="2">Self-guided tour</option>
													</select>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button class="btn btn-primary">Save</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<label class="error return-message"></label>
										</div>
									</div>
								</div>
							</form>
						</div>
					
	<script>
	
	var eventsA = <?php echo json_encode($eventArray); ?>;
	var currentDate = new Date();
	<!-- https://codepen.io/thomasjaltman/pen/eYYbozE -->
	var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        
        right: 'title'
      },
      initialDate: currentDate, //'2023-11-04',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      selectable: true,
	  allDaySlot: false,
	  slotMinTime: "07:00",
	  slotMaxTime: "20:00",
	  dateClick: function(info) {
		  if($('#exhibition-schedule').find(":selected").val() != ''){
			var startDate = new Date(info.dateStr);
			var endDate = new Date(info.dateStr);
			endDate.setHours(endDate.getHours()+parseInt($('#tourlength').val(), 10));	
			if(startDate.getDay()==0 || startDate.getDay()==6){
				alert('You should schedule tours only in working days of the week');
				return false;
			}
			if(startDate.getHours() < 9 || endDate.getHours() > 17) alert('Please be aware that the selected timeslot is out of working hours');
			$('#starttime').val(startDate.toLocaleString("sv", { timeZone: "Europe/Paris"}));
			$('#endtime').val(endDate.toLocaleString("sv", { timeZone: "Europe/Paris"}));
			$('#calendarModalInsert').modal();
		  }else{
			  alert('You must select an exhibition');
		  }
	},
	eventClick: function(info) {
    info.jsEvent.preventDefault(); // don't let the browser navigate


     //alert(info.event.start.toISOString());
	  $('#schedule_id').val(info.event.id);
            //$('#modalBody').html(info.event.id + info.event.extendedProps.description);
           // $('#eventUrl').attr('href', event.url);
            $('#calendarModalDelete').modal();

  },
      events: eventsA,
    });
	calendar.changeView('timeGridWeek');
    calendar.render();
</script>	
<!-- Vendor -->


		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>
		
									<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>	