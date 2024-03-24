<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_POST['id'];
	}else{
		//echo $_POST['id'];
		http_response_code(401);

		// return a JSON object with a message property
		echo json_encode(array("message" => "There was an error processing the request"));
		die();
	}


	if($stmt = $conn->prepare('SELECT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, users.institution_id, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, user_type.user_type_description FROM users, institutions, user_type WHERE user_type.user_type_id = users.user_type_id AND users.institution_id = institutions.institution_id AND users.user_id=?')){
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $first_name, $last_name, $email, $user_type_id, $user_type_description, $institution_id, $institution_type, $institution_name, $country_code, $country_name, $user_type_description);
		$stmt->fetch();
	}
	
?>

					<div class="row">
						<div class="col-md-12">
							<form id="profile-form" method="post">
								<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">User profile </h2>
										<p class="panel-subtitle">
											You can review and change your personal details.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">User type </label>
											<div class="col-sm-9">
												<label class="control-label"><?php echo $user_type_description ?></label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">First name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="firstname" class="form-control" value="<?php echo $first_name ?>" placeholder="eg.: I-A" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Last name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="lastname" class="form-control" value="<?php echo $last_name ?>" placeholder="eg.: I-A" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">E-mail Address <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="email" name="email" class="form-control" value="<?php echo $email ?>" placeholder="eg.: I-A" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Password </label>
											<div class="col-sm-9">
												<input name="pwd" type="password" class="form-control input-sm mb-none" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Re-type password </label>
											<div class="col-sm-9">
												<input name="pwd_confirm" type="password" class="form-control input-sm mb-none" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Institution </label>
											<div class="col-sm-9">
												<label class="control-label"><?php echo $institution_name ?></label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Country </label>
											<div class="col-sm-9">
												<label class="control-label"><?php echo $country_name ?></label>
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
<?php
	$conn->close();
?>						
<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>					