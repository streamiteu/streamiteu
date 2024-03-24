<?php
include_once "../config/dbconnect.php";
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	$user_type_id = $_SESSION['user_type_id'];
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "There was an error processing the request"));
	die();
}
?>
					<div class="row">
						<div class="col-md-12">
							<form id="insertclass-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Class details</h2>
										<p class="panel-subtitle">
											Enter new class details.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Class Name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="class_name" class="form-control" placeholder="eg.: I-A" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">School</label>
											<div class="col-sm-9">
												<select id="school_id" class="form-control" required>
													<?php
													$sql_query = "";
													if($user_type_id == 3 || $user_type_id == 5){
														$sql_query = 'SELECT institutions.institution_id, institutions.institution_name FROM institutions, users, userinstitution WHERE institutions.institution_id = userinstitution.institution_id AND userinstitution.user_id = users.user_id AND institutions.institution_type = "school" AND users.user_id = ?';
													}
													if($user_type_id == 1){
														$sql_query = 'SELECT institutions.institution_id, institutions.institution_name FROM institutions WHERE institutions.institution_type = "school"';
													}
													if($stmt = $conn->prepare($sql_query)){
														if($user_type_id == 3 || $user_type_id == 5){
															$stmt->bind_param('i', $id);
														}
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($inst_id, $institution_name);
														while ($stmt->fetch()) {
													?>
														<option value="<?php echo $inst_id ?>"><?php echo $institution_name ?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
												<label class="error" for="school"></label>
											</div>
										</div>
										
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button class="btn btn-primary">Save</button>
												<button type="reset" class="btn btn-default">Reset</button>
												<label class="error editclass-message"></label>
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
					</div>
<?php
	$conn->close();
?>		

<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>								