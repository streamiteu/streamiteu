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
						
								<h2 class="panel-title">List of institutions</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Institution name</th>
											<th>Institution type</th>
											<th class="hidden-phone">Country code</th>
											<th class="hidden-phone">Country name</th>
											<th class="hidden-phone"><i class="fa fa-key" aria-hidden="true"></i></th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($stmt = $conn->prepare("SELECT institution_id, institution_name, institution_type, country_code, country_name, approved FROM institutions WHERE institution_type != 'system'")){
											//$stmt->bind_param('i', $id);
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($institution_id, $institution_name, $institution_type, $country_code, $country_name, $approved);
											while ($stmt->fetch()) {
										?>
										<tr class="gradeX">
											<td><?php echo $institution_name ?></td>
											<td><?php echo $institution_type ?></td>
											<td class="hidden-phone"><?php echo $country_code ?></td>
											<td class="hidden-phone"><?php echo $country_name ?></td>
											<td class="hidden-phone"><input id="approve-btn-<?php echo $institution_id ?>" type="checkbox" class="approved-btn" <?php if ($approved == 1) echo 'checked' ?> onclick="approveInstitution('approve-btn-<?php echo $institution_id ?>', <?php echo $institution_id ?>);" value="<?php echo $institution_id ?>"></td>
											<td>
												<a href="#editinstitution" onclick="Router('editinstitution', <?php echo $institution_id ?> );">Edit</a>  |  
												<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $institution_id ?>" data-itemkey="institution_id" data-entity="institutions" data-returnroute="institutions">Delete</a>
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
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>			