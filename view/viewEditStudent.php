<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		if(isset($_POST['id']))
		{
			$user_id=$_POST['id'];
			$id = $_SESSION['id'];
			$session_user_type_id = $_SESSION['user_type_id'];
			$session_user_institution_id = $_SESSION['user_institution_id'];
	
			if($stmt = $conn->prepare('SELECT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, institutions.institution_id, institutions.institution_type, institutions.institution_name, institutions.country_code, institutions.country_name, user_type.user_type_description, users.approved FROM users, userinstitution, institutions, user_type WHERE user_type.user_type_id = users.user_type_id AND institutions.institution_id = userinstitution.institution_id AND userinstitution.user_id = users.user_id AND users.user_id=?')){
				$stmt->bind_param('i', $user_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($user_id, $first_name, $last_name, $email, $user_type_id_u, $user_type_description, $institution_id_u, $institution_type_u, $institution_name, $country_code, $country_name, $user_type_description, $approved);
				$stmt->fetch();
				if ($stmt->num_rows > 0) {
					if($stmt = $conn->prepare('SELECT students.class_id FROM students WHERE students.user_id =?')){
						$stmt->bind_param('i', $user_id);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($class_id_u);
						$stmt->fetch();
					}
				}
				else{
					//echo $_POST['id'];
					http_response_code(402);
					// return a JSON object with a message property
					echo json_encode(array("message" => "User not found!"));
					die();
				}
				$stmt->close();
			}else{
				//echo $_POST['id'];
				http_response_code(402);
				// return a JSON object with a message property
				echo json_encode(array("message" => "User not found!"));
				die();
			}
		}else{
			//echo $_POST['id'];
			http_response_code(402);
			// return a JSON object with a message property
			echo json_encode(array("message" => "User not found!"));
			die();
		}
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
							<form id="student-edit-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Student details</h2>
										<p class="panel-subtitle">
											Edit student profile.
										</p>
									</header>
									<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id?>">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">First Name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="firstname" class="form-control" value="<?php echo $first_name?>" placeholder="eg.: John" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Last Name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="lastname" class="form-control" value="<?php echo $last_name?>" placeholder="eg.: Doe" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Email <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="email" name="email" class="form-control" value="<?php echo $email?>" placeholder="eg.: Doe@gmail.com" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">User type <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="user_type" class="form-control" disabled required>
													<?php
													$sql_query = "";
													if($session_user_type_id == 3){
														$sql_query = 'SELECT user_type_id, user_type_description FROM user_type WHERE user_type_id IN (5, 6)';
													}
													if($session_user_type_id == 5){
														$sql_query = 'SELECT user_type_id, user_type_description FROM user_type WHERE user_type_id = 6';
													}
													if($session_user_type_id == 1){
														$sql_query = 'SELECT user_type_id, user_type_description FROM user_type';
													}
													if($stmt = $conn->prepare($sql_query)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($user_type_id, $user_type_description);
														while ($stmt->fetch()) {
													?>
													<option <?php if($user_type_id_u == $user_type_id) echo 'selected'?> value="<?php echo $user_type_id ?>"><?php echo $user_type_description ?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group group-institution">
											<label class="col-sm-3 control-label">School <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="institution-admin" class="form-control" <?php if($user_type_id_u == 1) echo 'disabled' ?> required>
													<option value="">Choose school</option>
													<?php
													$sql_query1 = "";
													$institutions_list="";
													if($session_user_type_id == 3 || $session_user_type_id == 5){
														$sql_query1 = "SELECT institutions.institution_id, institutions.institution_type, institutions.institution_name FROM users, userinstitution, institutions WHERE institutions.institution_type='school' AND users.user_id = " . $id . " AND users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id";
													}
													if($session_user_type_id == 1){
														$sql_query1 = "SELECT institution_id, institution_type, institution_name FROM institutions WHERE institution_type='school'";
													}
													if($stmt = $conn->prepare($sql_query1)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($institution_id, $institution_type, $institution_name);
														while ($stmt->fetch()) {
															$institutions_list .= $institution_id . ',';
													?>
													<option <?php if (($user_type_id_u == 1 || $user_type_id_u == 3 || $user_type_id_u == 5 || $user_type_id_u == 6) && $institution_type == 'museum') echo 'hidden' ?> <?php if (($user_type_id_u == 1 || $user_type_id_u == 2 || $user_type_id_u == 4) && $institution_type == 'school') echo 'hidden' ?> <?php if($institution_id_u == $institution_id) echo 'selected'?> data-institution-type="<?php echo $institution_type ?>" value="<?php echo $institution_id?>"><?php echo $institution_name?></option>
													<?php
														}
													}
													$stmt->close();
													$institutions_list = trim($institutions_list, ',');
													?>
												</select>
												
											</div>
										</div>
										
										<div class="form-group group-class">
											<label class="col-sm-3 control-label">Class <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="class-admin" class="form-control" <?php if($user_type_id_u != 6) echo 'disabled' ?> required>
													<option data-institution-id="0" value="">Choose class </option>
													<?php
													$sql_query2 = "SELECT class_id, class_name, institution_id FROM classes";
													
													if($session_user_type_id == 3 || $session_user_type_id == 5){
														$sql_query2 = 'SELECT class_id, class_name, institution_id FROM classes WHERE institution_id IN (' . $institutions_list . ')';
													}
													if($session_user_type_id == 1){
														$sql_query2 = 'SELECT class_id, class_name, institution_id FROM classes';
													}
													
													if($stmt = $conn->prepare($sql_query2)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($class_id, $class_name, $institution_id);
														while ($stmt->fetch()) {
													?>
													
													<option <?php if($class_id_u == $class_id) echo 'selected' ?> data-institution-id="<?php echo $institution_id ?>" <?php if($institution_id_u!=$institution_id) echo 'style="display:none"' ?> value="<?php echo $class_id?>"><?php echo $class_name?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Approved </label>
											<div class="col-sm-9">
												<input type="checkbox" id="approved" name="approved" <?php if ($approved == 1) echo 'checked' ?> value="<?php echo $approved ?>">
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
							<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>	