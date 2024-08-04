<?php
include_once '../config/config.php';
include_once "../config/dbconnect.php";
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	$session_user_institution_id = $_SESSION['user_institution_id'];
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "There was an error processing the request"));
	die();
}
?>

<!-- Specific Page Vendor CSS -->
		<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
						
								<h2 class="panel-title">List of Tours</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Start time</th>
											<th>End time</th>
											<th>Tour type</th>
											<th>Museum</th>
											<th>Exhibition</th>
											<th>Tour guide</th>
											<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 3 || $_SESSION['user_type_id'] == 5){?><th>Lectures</th><?php } ?>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($stmt1 = $conn->prepare('SELECT tours.tour_id, tours.tour_attendees, tours.tour_guide_id, tours.tour_teacher_id, schedule.schedule_start, schedule.schedule_end, schedule.schedule_type, exhibitions.exhibition_title, institutions.institution_name, institutions.institution_id FROM tours, schedule, institutions, exhibitions WHERE schedule.schedule_id = tours.schedule_id AND schedule.exhibition_id = exhibitions.exhibition_id AND exhibitions.institution_id  = institutions.institution_id')){
											$stmt1->execute();
											$stmt1->store_result();
											$stmt1->bind_result($tour_id, $tour_attendees, $tour_guide_id, $tour_teacher_id, $schedule_start, $schedule_end, $schedule_type, $exhibition_title, $institution_name, $institution_id);
											while ($stmt1->fetch()) {
												if($tour_guide_id == 0){
													$tg_firsname = "";
													$tg_lastname = "";
												}else{
													if($stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id=?")){
														$stmt->bind_param('i', $tour_guide_id );
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($tg_firsname, $tg_lastname);
														$stmt->fetch();
													}
												}
												$showhide = true;
												if($_SESSION['user_type_id'] == 3){
													if($stmt = $conn->prepare("SELECT COUNT(*) FROM userinstitution WHERE user_id=? AND institution_id IN (". $_SESSION['user_institution_id'] . ")")){
														$stmt->bind_param('i', $tour_teacher_id );
														$stmt->execute();
														$row = $stmt->get_result()->fetch_row();
														$rowsTotal = $row[0];
														if($rowsTotal == 0){
															$showhide = false;
														}
													}
												}
												
												//Ovde da se napravi so pole
												if($_SESSION['user_type_id'] == 2){
													$sessiondata = explode(",", $_SESSION['user_institution_id']);
													if(!in_array($institution_id, $sessiondata)){
														$showhide = false;
													}
												}
												if($_SESSION['user_type_id'] == 4){
													if($id != $tour_guide_id){
														$showhide = false;
													}
												}
												if($_SESSION['user_type_id'] == 5){
													if($id != $tour_teacher_id){
														$showhide = false;
													}
												}
												if($_SESSION['user_type_id'] == 6){
													$students = explode(",", $tour_attendees);
													if(!in_array($id, $students)){
														$showhide = false;
													}
												}
												
												if($showhide){
										?>
													<tr class="gradeX">
														<td><?php echo $schedule_start ?></td>
														<td><?php echo $schedule_end ?></td>
														<td><?php if($schedule_type==1) echo 'Guided tour'; else echo 'Self-guided tour'; ?></td>
														<td><?php echo $exhibition_title ?></td>
														<td><?php echo $institution_name ?></td>
														<td><?php echo $tg_firsname . ' ' . $tg_lastname ?></td>
														<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 3 || $_SESSION['user_type_id'] == 5){?>
														<td><a href="#edittourlectures" onclick="Router('edittourlectures', <?php echo $tour_id ?> );">Lectures</a></td>
														<?php } ?>
														<td>
															<?php if($_SESSION['user_type_id'] == 5){?>
															<a href="#edittour" onclick="Router('edittour', <?php echo $tour_id ?> );">Edit</a>  |  
															<?php } ?>
															<?php if($_SESSION['user_type_id'] == 2){?>
															<a href="javascript:void(0);" class="edittg-item-btn" data-itemid="<?php echo $tour_id ?>" data-itemkey="tour_id" data-entity="tours" data-returnroute="tours">Edit</a>  |  
															<?php } ?>
															<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2 || $_SESSION['user_type_id'] == 3 || $_SESSION['user_type_id'] == 4 || $_SESSION['user_type_id'] == 5){?>
															<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $tour_id ?>" data-itemkey="tour_id" data-entity="tours" data-returnroute="tours">Cancel</a>  |  
															<?php } ?>
															<?php if($_SESSION['user_type_id'] == 4 || $_SESSION['user_type_id'] == 5 || $_SESSION['user_type_id'] == 6){?>
															<a href="<?php echo $site_url.'/index-front.php?tour_id='. $tour_id?>">Start</a>
															<?php } ?>
														</td>
													</tr>
										<?php
												}
											}
										}
										$stmt1->close();
										?>
									</tbody>
								</table>
							</div>
						</section>
						<!-- Examples -->
						<!-- The Modal -->
		<div id="deleteModalDialog" class="modal">
			
			<!-- Modal content -->
			<div class="modal-content">
		
				<div class="modal-header">
				  <span class="close">&times;</span>
				  <h2>Are you sure you want to delete this item?</h2>
				</div>
				<div class="modal-body">
				  <p>Deleting items is permanent. Once deleted, the item can not be restored.</p>
				  <p>Are you sure?</p>
				</div>
				<div class="modal-footer">
					<form id="delete-item-form" method="post">
						<input type="hidden" id="delete_item_id" name="delete_item_id" value="">
						<input type="hidden" id="delete_key" name="delete_key" value="">
						<input type="hidden" id="delete_entity" name="delete_entity" value="">
						<input type="hidden" id="return_route" name="return_route" value="">
						<input type="submit" class="btn btn-primary btnDelete" value="Delete" />
						<input type="calcel" id="cancelModal" class="btn btn-default" value="Cancel" />
						<label class="error delete-item-message"></label>
					</form>
				</div>
			</div>
			
		</div>
		
		<div id="editTourGuideModalDialog" class="modal">
			
			<!-- Modal content -->
			<div class="modal-content">
				<form id="tg-item-form" method="post">
				<div class="modal-header">
				  <span class="closetg">&times;</span>
				  <h2>Please select a tour guide from your institution that will be responsible for this tour</h2>
				</div>
				<div class="modal-body">
				<br/>
				  <p>
						<select id="tour_guide_id" name="tour_guide_id" class="form-control" required>
							<option value="">Select tour guide </option>
							<?php
							$sql_query = "SELECT users.user_id, users.first_name, users.last_name FROM users, userinstitution WHERE users.user_id=userinstitution.user_id AND users.user_type_id = 4 AND userinstitution.institution_id IN (" . $session_user_institution_id . ")";
							
							if($stmt2 = $conn->prepare($sql_query)){
								$stmt2->execute();
								$stmt2->store_result();
								$stmt2->bind_result($user_id, $first_name, $last_name);
								while ($stmt2->fetch()) {
							?>
							<option value="<?php echo $user_id?>"><?php echo $first_name . ' ' . $last_name?></option>
							<?php
								}
								$stmt2->close();
							}
							
							?>
						</select>
				  </p>
				  <br/>
				</div>
				<div class="modal-footer">
					
						<input type="hidden" id="tour_id" name="tour_id" value="">
						<input type="hidden" id="tg_return_route" name="tg_return_route" value="">
						<input type="submit" class="btn btnEditTG" value="Save" />
						<input type="calcel" id="cancelModalTG" class="btn btn-default" value="Cancel" />
						<label class="error tg-item-message"></label>
					
				</div>
			</div>
			</form>
		</div>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>

		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>

<?php
	$conn->close();
?>	
		