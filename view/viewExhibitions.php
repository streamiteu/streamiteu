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
						
								<h2 class="panel-title">List of exhibitions</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Exhibition title</th>
											<th>Exhibition description</th>
											<th class="hidden-phone">Museum</th>
											<th class="hidden-phone">Exhibition map</th>
											<th class="hidden-phone">Exhibition ip</th>
											<th class="hidden-phone">Exhibition port</th>
											<th class="hidden-phone">Server name</th>
											<th class="hidden-phone"><i class="fa fa-key" aria-hidden="true"></i></th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql_query = "";
										if($session_user_type_id == 2 || $session_user_type_id == 4){
											$sql_query = 'SELECT exhibitions.exhibition_id, exhibitions.exhibition_title, exhibitions.exhibition_description, exhibitions.institution_id, exhibitions.exhibition_map, exhibitions.exhibition_ip, exhibitions.exhibition_port, exhibitions.server_name, exhibitions.active, institutions.institution_name FROM exhibitions, institutions WHERE exhibitions.institution_id=institutions.institution_id AND institutions.institution_id = ' . $session_user_institution_id;
										}
										if($session_user_type_id == 1){
											$sql_query = 'SELECT exhibitions.exhibition_id, exhibitions.exhibition_title, exhibitions.exhibition_description, exhibitions.institution_id, exhibitions.exhibition_map, exhibitions.exhibition_ip, exhibitions.exhibition_port, exhibitions.server_name, exhibitions.active, institutions.institution_name FROM exhibitions, institutions WHERE exhibitions.institution_id=institutions.institution_id';
										}
										if($stmt = $conn->prepare($sql_query)){
											//$stmt->bind_param('i', $id);
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($exhibition_id, $exhibition_title, $exhibition_description, $institution_id, $exhibition_map, $exhibition_ip, $exhibition_port, $server_name, $active, $institution_name);
											while ($stmt->fetch()) {
										?>
										<tr class="gradeX">
											<td><?php echo $exhibition_title ?></td>
											<td><?php echo $exhibition_description ?></td>
											<td><?php echo $institution_name ?></td>
											<td class="hidden-phone"><?php echo $exhibition_map ?></td>
											<td class="hidden-phone"><?php echo $exhibition_ip ?></td>
											<td class="hidden-phone"><?php echo $exhibition_port ?></td>
											<td class="hidden-phone"><?php echo $server_name ?></td>
											<td class="hidden-phone"><input id="approve-btn-<?php echo $exhibition_id ?>" type="checkbox" class="approved-btn" <?php if ($active == 1) echo 'checked' ?> onclick="atctivateExhibition('approve-btn-<?php echo $exhibition_id ?>', <?php echo $exhibition_id ?>);" value="<?php echo $exhibition_id ?>"></td>
											<td>
												<a href="#editexhibition" onclick="Router('editexhibition', <?php echo $exhibition_id ?> );">Edit</a>  |  
												<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $exhibition_id ?>" data-itemkey="exhibition_id" data-entity="exhibitions" data-returnroute="exhibitions">Delete</a>  |
												<a href="#mapexhibition" onclick="Router('mapexhibition', <?php echo $exhibition_id ?> );">Map</a>
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