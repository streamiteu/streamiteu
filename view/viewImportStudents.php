<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) &&  isset($_SESSION['id'])){
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
		<link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
			<div class="row">
						<div class="col-md-12">
							<form id="import-students-form" enctype="multipart/form-data" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Import students</h2>
										<p class="panel-subtitle">
											Bulk import of students from .csv file.
										</p>
									</header>
									<div class="panel-body">
										
										<div class="form-group">
											<label class="col-sm-3 control-label">School <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="school-student-import" class="form-control" required>
													<option value="">Select school </option>
													<?php
													$sql_query1 = "";
													if($session_user_type_id == 3 || $session_user_type_id == 5){
														$sql_query1 = "SELECT institutions.institution_id, institutions.institution_type, institutions.institution_name FROM userinstitution, institutions WHERE userinstitution.institution_id = institutions.institution_id AND institutions.institution_type='school' AND userinstitution.user_id = " . $id;
													}
													if($session_user_type_id == 1){
														$sql_query1 = "SELECT institution_id, institution_type, institution_name FROM institutions WHERE institution_type='school'";
													}
													if($stmt = $conn->prepare($sql_query1)){
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
											<label class="col-sm-3 control-label">Class <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="class-student-import" class="form-control" required>
													<option data-institution-id="0" value="">Choose class </option>
													<?php
													$sql_query2 = 'SELECT class_id, class_name, institution_id FROM classes';
													if($session_user_type_id == 3 || $session_user_type_id == 5){
														$sql_query2 = 'SELECT classes.class_id, classes.class_name, classes.institution_id FROM classes WHERE classes.institution_id IN (SELECT userinstitution.institution_id FROM userinstitution WHERE userinstitution.user_id=' . $id .')';
													}
													if($stmt = $conn->prepare($sql_query2)){
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
												<label class="col-md-3 control-label">File Upload <span class="required">*</span></label>
												<div class="col-md-6">
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="fa fa-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-default btn-file">
																<span class="fileupload-exists">Change</span>
																<span class="fileupload-new">Select file</span>
																<input id="file_students" name="file_students" type="file" required />
															</span>
															<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
												</div>
											</div>
										
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
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
<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

							<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>	