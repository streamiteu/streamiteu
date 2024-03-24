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
						
								<h2 class="panel-title">List of users</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>First name</th>
											<th>Last name</th>
											<th class="hidden-phone">Email</th>
											<th class="hidden-phone">User type</th>
											<th class="hidden-phone">Institution</th>
											<th class="hidden-phone"><i class="fa fa-key" aria-hidden="true"></i></th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql_query = "";
										if($session_user_type_id == 2 || $session_user_type_id == 3){
											//$sql_query = 'SELECT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, users.institution_id, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, users.approved FROM users, user_type, institutions WHERE users.institution_id = institutions.institution_id AND users.user_type_id = user_type.user_type_id AND users.institution_id = ' . $session_user_institution_id;
											$sql_query = 'SELECT DISTINCT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, users.approved FROM users, user_type, userinstitution, institutions WHERE user_type.user_type_id NOT IN (1, 2, 3) AND users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND users.user_type_id = user_type.user_type_id AND userinstitution.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
											//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
										}
										if($session_user_type_id == 1){
											$sql_query = 'SELECT DISTINCT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, users.approved FROM users, user_type, userinstitution, institutions WHERE users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND users.user_type_id = user_type.user_type_id AND user_type.user_type_id != 1';
										}
										if($stmt = $conn->prepare($sql_query)){
										//if($stmt = $conn->prepare('SELECT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, users.institution_id, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, users.approved FROM users, user_type, institutions WHERE users.institution_id = institutions.institution_id AND users.user_type_id = user_type.user_type_id')){
											//$stmt->bind_param('i', $id);
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($user_id, $first_name, $last_name, $email, $user_type_id, $user_type_description, $institution_type, $institution_name, $country_code, $country_name, $approved);
											while ($stmt->fetch()) {
										?>
										<tr class="gradeX">
											<td><?php echo $first_name ?></td>
											<td><?php echo $last_name ?></td>
											<td class="hidden-phone"><?php echo $email ?></td>
											<td class="hidden-phone"><?php echo $user_type_description ?></td>
											<td class="hidden-phone"><?php echo $institution_name ?></td>
											<td class="hidden-phone"><input id="approve-btn-<?php echo $user_id ?>" type="checkbox" class="approved-btn" <?php if ($approved == 1) echo 'checked' ?> onclick="approveUser('approve-btn-<?php echo $user_id ?>', <?php echo $user_id ?>, '<?php echo $email ?>');" value="<?php echo $user_id ?>"></td>
											<td>
												<a href="#edituser" onclick="Router('edituser', <?php echo $user_id ?> );">Edit</a>  |  
												<a href="javascript:void(0);" class="delete-item-btn" data-itemid="<?php echo $user_id ?>" data-itemkey="user_id" data-entity="users" data-returnroute="users">Delete</a>
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