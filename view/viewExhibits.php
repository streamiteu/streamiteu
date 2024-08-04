<?php
include_once "../config/dbconnect.php";
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	$session_user_type_id = $_SESSION['user_type_id'];
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
						
								<h2 class="panel-title">List of exhibits</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Exhibit name</th>
											<th>Exhibit description</th>
											<th class="hidden-phone">Exhibition</th>
											<th class="hidden-phone"><i class="fa fa-key" aria-hidden="true"></i></th>
											<th class="hidden-phone">Multimedia</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql_query = "";
										if($session_user_type_id == 2 || $session_user_type_id == 4){
											$sql_query = 'SELECT exhibits.exhibit_id, exhibits.exhibit_name, exhibits.exhibit_description, exhibits.exhibition_id, exhibits.exhibit_location_x, exhibits.exhibit_location_y, exhibits.exhibit_location_z, exhibits.exhibit_heading_x, exhibits.exhibit_heading_y, exhibits.exhibit_heading_z, exhibits.active, exhibitions.exhibition_id, exhibitions.exhibition_title FROM exhibits, exhibitions WHERE exhibitions.exhibition_id=exhibits.exhibition_id AND exhibitions.institution_id IN (' . $session_user_institution_id . ')';
										}
										if($session_user_type_id == 1){
											$sql_query = 'SELECT exhibits.exhibit_id, exhibits.exhibit_name, exhibits.exhibit_description, exhibits.exhibition_id, exhibits.exhibit_location_x, exhibits.exhibit_location_y, exhibits.exhibit_location_z, exhibits.exhibit_heading_x, exhibits.exhibit_heading_y, exhibits.exhibit_heading_z, exhibits.active, exhibitions.exhibition_id, exhibitions.exhibition_title FROM exhibits, exhibitions WHERE exhibitions.exhibition_id=exhibits.exhibition_id';
										}
										if($stmt = $conn->prepare($sql_query)){
											//$stmt->bind_param('i', $id);
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($exhibit_id, $exhibit_name, $exhibit_description, $exhibition_id, $exhibit_location_x, $exhibit_location_y, $exhibit_location_z, $exhibit_heading_x, $exhibit_heading_y, $exhibit_heading_z, $active, $exhibition_id, $exhibition_title);
											while ($stmt->fetch()) {
										?>
										<tr class="gradeX">
											<td><?php echo $exhibit_name ?></td>
											<td><?php echo $exhibit_description ?></td>
											<td><?php echo $exhibition_title ?></td>
											<td class="hidden-phone"><input id="approve-btn-<?php echo $exhibit_id ?>" type="checkbox" class="approved-btn" <?php if ($active == 1) echo 'checked' ?> onclick="atctivateExhibit('approve-btn-<?php echo $exhibit_id ?>', <?php echo $exhibit_id ?>);" value="<?php echo $exhibit_id ?>"></td>
											<td><a href="#editexhibitmultimedia" onclick="Router('editexhibitmultimedia', <?php echo $exhibit_id ?> );">Edit multimedia</a></td>
											<td>
												<a href="#editexhibit" onclick="Router('editexhibit', <?php echo $exhibit_id ?> );">Edit</a>  |  
												<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $exhibit_id ?>" data-itemkey="exhibit_id" data-entity="exhibits" data-returnroute="exhibits">Delete</a>
											</td>
										</tr>
										<?php
											}
											$stmt->close();
										}
										
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
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>			