<?php
include_once "../config/dbconnect.php";
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
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
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($stmt = $conn->prepare('SELECT tours.tour_id, schedule.schedule_start, schedule.schedule_end, schedule.schedule_type, exhibitions.exhibition_title, institutions.institution_name FROM tours, schedule, institutions, exhibitions WHERE schedule.schedule_id = tours.schedule_id AND schedule.exhibition_id = exhibitions.exhibition_id AND exhibitions.institution_id  = institutions.institution_id')){
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($tour_id, $schedule_start, $schedule_end, $schedule_type, $exhibition_title, $institution_name);
											while ($stmt->fetch()) {
										?>
										<tr class="gradeX">
											<td><?php echo $schedule_start ?></td>
											<td><?php echo $schedule_end ?></td>
											<td><?php if($schedule_type==1) echo 'Guided tour'; else echo 'Self-guided tour'; ?></td>
											<td><?php echo $exhibition_title ?></td>
											<td><?php echo $institution_name ?></td>
											<td>
												<a href="#edittour" onclick="Router('edittour', <?php echo $tour_id ?> );">Edit</a>  |  
												<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $class_id ?>" data-itemkey="class_id" data-entity="classes" data-returnroute="classes">Cancel</a>  |
												<a href="#editclass" onclick="Router('editclass', <?php echo $class_id ?> );">Start</a>
											</td>
										</tr>
										<?php
											}
										}
										$stmt->close();
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
		