<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		
		$eventArray = array();
		if(isset($_POST['id'])){
		
			if($stmt = $conn->prepare("SELECT schedule_id, schedule_type, exhibition_id, schedule_start, schedule_end FROM schedule WHERE exhibition_id=?")){
				$stmt->bind_param('i', $_POST['id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($schedule_id, $schedule_type, $exhibition_id, $schedule_start, $schedule_end);
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
							<form id="new-tour-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Add tour</h2>
										<p class="panel-subtitle">
											Create new tour.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">Museum</label>
											<div class="col-sm-10">
												<select id="museum-route" class="form-control">
													<option value="">Choose a museum</option>
													<?php
													if($stmt = $conn->prepare("SELECT institution_id, institution_name FROM institutions WHERE institution_type='museum'")){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($institution_id, $exhibition_name);
														while ($stmt->fetch()) {
													?>
													<option value="<?php echo $institution_id?>"><?php echo $exhibition_name?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Exhibition <span class="required">*</span></label>
											<div class="col-sm-10">
												<select id="exhibition-route" class="form-control" required>
													<option value="">Choose an exhibition </option>
													<?php
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
											<label class="col-sm-12 control-label">Calendar (please schedue your tour during available dates and times during marked working hours)</label>
											<div class="col-sm-12">
												<div id='calendar'></div>
												<input type="hidden" id="schedule_id" name="schedule_id" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">School <span class="required">*</span></label>
											<div class="col-sm-10">
												<select id="school-student-import" class="form-control" required>
													<option value="">Select school </option>
													<?php
													if($stmt = $conn->prepare("SELECT institution_id, institution_type, institution_name FROM institutions WHERE institution_type='school' AND approved=1")){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($institution_id, $institution_type, $institution_name);
														while ($stmt->fetch()) {
													?>
													<option value="<?php echo $institution_id?>"><?php echo $institution_name?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Class <span class="required">*</span></label>
											<div class="col-sm-10">
												<select id="class-student-import" class="form-control class-control" required>
													<option value="">Choose class </option>
													<?php
													if($stmt = $conn->prepare('SELECT class_id, class_name, institution_id FROM classes')){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($class_id, $class_name, $institution_id);
														while ($stmt->fetch()) {
													?>
													<option data-institution-id="<?php echo $institution_id ?>" value="<?php echo $class_id?>"><?php echo $class_name?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Students <span class="required">*</span></label>
											<div class="col-sm-4">
												<select id="inputStudents" name="list_box_name" multiple="multiple" style="width:100%" size="5">
												
												</select>
											</div>
											<div class="col-sm-2">
												<button id="addStudents" type="button" style="width:100%" class="btn btn-primary">Add -></button>
												<br/>
												<br/>
												<button id="removeStudents" type="button" style="width:100%" class="btn btn-primary"><- Remove</button>
											</div>
											<div class="col-sm-4">
												<select id="outputStudents" name="list_box_name" multiple="multiple" style="width:100%" size="5">
												
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Tour plan</label>
											<div class="col-sm-10">
												<div id="accordion">
													<div class="panel panel-accordion panel-accordion-first">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
																	<i class="fa fa-check"></i> Exhibits order of visit
																</a>
															</h4>
														</div>
														<div id="collapse1One" class="accordion-body collapse in">
															<div class="panel-body">
																<ul id="exhibit-list" class="widget-todo-list">
																	<?php
																	if($stmt = $conn->prepare("SELECT exhibit_id, exhibit_name FROM exhibits WHERE exhibition_id=? AND active=1")){
																		$stmt->bind_param('i', $_POST['id']);
																		$stmt->execute();
																		$stmt->store_result();
																		$stmt->bind_result($exhibit_id, $exhibit_name);
																		while ($stmt->fetch()) {
																	?>
																	<li>
																		<div class="checkbox-custom checkbox-default">
																			<input type="checkbox" checked id="todoListItem-<?php echo $exhibit_id?>" value="<?php echo $exhibit_id?>" class="todo-check">
																			<label class="todo-label" for="todoListItem-<?php echo $exhibit_id?>"><span><?php echo $exhibit_name ?></span></label>
																		</div>
																	</li>
																	<?php
																		}
																	}
																	$stmt->close();
																	?>
																</ul>
																
															</div>
														</div>
													</div>
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-12 col-sm-offset-6">
												<button class="btn btn-primary">Save</button>
												<button type="reset" class="btn btn-default">Reset</button>
												<label class="error return-message"></label>
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
					</div>
					<div class="row">
						
						<div id="calendarModal" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 id="modalTitle" class="modal-title"></h4>
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
									</div>
									<div id="modalBody" class="modal-body"> modal content </div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
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
      initialDate: currentDate,
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      selectable: true,
	  allDaySlot: false,
	  slotMinTime: "07:00",
	  slotMaxTime: "19:00",
	  height: '700px',
	  /*
	  dateClick: function(info) {
		  //alert('clicked ' + info.dateStr);
		},
		*/
	eventClick: function(info) {
    info.jsEvent.preventDefault(); // don't let the browser navigate
	eventsA.forEach((eventA) => {
		var currentEvent = calendar.getEventById(eventA.id);
		currentEvent.setProp("color", eventA.color);
		
		//currentEvent.el.style.backgroundColor = eventA.color;
	});
	if(calendar.getEventById(info.event.id).backgroundColor == '#74fcbd'){
		calendar.getEventById(info.event.id).setProp("color", '#399068');
	}else{
		calendar.getEventById(info.event.id).setProp("color", '#34495e');
	}
	$('#schedule_id').val(info.event.id);
	/*
	  $('#modalTitle').html(info.event.title);
            $('#modalBody').html(info.event.extendedProps.description);
           // $('#eventUrl').attr('href', event.url);
            $('#calendarModal').modal();
*/

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