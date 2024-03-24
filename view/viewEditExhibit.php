<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$session_user_type_id = $_SESSION['user_type_id'];
		$session_user_institution_id = $_SESSION['user_institution_id'];
			
		if(isset($_POST['id']))
		{
			
			$exhibit_id=$_POST['id'];
			
			if($stmt = $conn->prepare("SELECT exhibits.exhibit_id, exhibits.exhibit_name, exhibits.exhibit_description, exhibits.exhibition_id, exhibits.exhibit_location_x, exhibits.exhibit_location_y, exhibits.exhibit_location_z, exhibits.exhibit_heading_x, exhibits.exhibit_heading_y, exhibits.exhibit_heading_z, exhibits.active, exhibitions.exhibition_id, exhibitions.exhibition_title FROM exhibits, exhibitions WHERE exhibitions.exhibition_id=exhibits.exhibition_id AND exhibits.exhibit_id=?")){
				$stmt->bind_param('i', $exhibit_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($exhibit_id, $exhibit_name, $exhibit_description, $uexhibition_id, $exhibit_location_x, $exhibit_location_y, $exhibit_location_z, $exhibit_heading_x, $exhibit_heading_y, $exhibit_heading_z, $active, $exhibition_id, $exhibition_title);
				$stmt->fetch();
			}else{
				//echo $_POST['id'];
				http_response_code(402);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Exhibit not found!"));
				die();
			}
		}else{
			//echo $_POST['id'];
			http_response_code(402);
			// return a JSON object with a message property
			echo json_encode(array("message" => "Exhibit not found!"));
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
							<form id="editexhibit-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Exhibit details</h2>
										<p class="panel-subtitle">
											Edit exhibit.
										</p>
									</header>
									
									<div class="panel-body">
										<input type="hidden" id="exhibit_id" name="exhibit_id" value="<?php echo $exhibit_id?>">
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibit name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_name" class="form-control" value="<?php echo $exhibit_name ?>" placeholder="eg.: Handmade vase" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibit description <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="textarea" name="exhibit_description" class="form-control" value="<?php echo $exhibit_description ?>" placeholder="eg.: Handmade vase from ceramics" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="exhibition" class="form-control" required>
													<option value="">Select exhibition </option>
													<?php
													$sql_query = "";
													if($session_user_type_id == 2 || $session_user_type_id == 4){
														$sql_query = 'SELECT exhibition_id, exhibition_title FROM exhibitions WHERE institution_id = ' . $session_user_institution_id;
													}
													if($session_user_type_id == 1){
														$sql_query = 'SELECT exhibition_id, exhibition_title FROM exhibitions';
													}
													if($stmt = $conn->prepare($sql_query)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($exhibition_id, $exhibition_title);
														while ($stmt->fetch()) {
													?>
													<option <?php if ($uexhibition_id == $exhibition_id) echo 'selected' ?> value="<?php echo $exhibition_id?>"><?php echo $exhibition_title?></option>
													<?php
														}
													}
													$stmt->close();
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label">Location X </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_x" class="form-control" value="<?php echo $exhibit_location_x ?>" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Location Y </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_y" class="form-control" value="<?php echo $exhibit_location_y ?>" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Location Z </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_z" class="form-control" value="<?php echo $exhibit_location_z ?>" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading X </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_x" class="form-control" value="<?php echo $exhibit_heading_x ?>" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading Y </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_y" class="form-control" value="<?php echo $exhibit_heading_y ?>" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading Z </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_z" class="form-control" value="<?php echo $exhibit_heading_z ?>" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Active </label>
											<div class="col-sm-9">
												<input type="checkbox" id="active" name="active" <?php if($active == 1) echo 'checked' ?> value="">
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