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
					<div class="row">
						<div class="col-md-12">
							<form id="insertexhibit-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Exhibit details</h2>
										<p class="panel-subtitle">
											Create new exhibit.
										</p>
									</header>
									
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibit name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_name" class="form-control" value="" placeholder="eg.: Handmade vase" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibit description <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="textarea" name="exhibit_description" class="form-control" value="" placeholder="eg.: Handmade vase from ceramics" required/>
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
														$sql_query = 'SELECT exhibition_id, exhibition_title FROM exhibitions WHERE institution_id IN (' . $session_user_institution_id . ')';
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
													<option value="<?php echo $exhibition_id?>"><?php echo $exhibition_title?></option>
													<?php
														}
														$stmt->close();
													}
													
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label">Location X </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_x" class="form-control" value="" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Location Y </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_y" class="form-control" value="" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Location Z </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_location_z" class="form-control" value="" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading X </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_x" class="form-control" value="" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading Y </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_y" class="form-control" value="" placeholder=""/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Heading Z </label>
											<div class="col-sm-9">
												<input type="text" name="exhibit_heading_z" class="form-control" value="" placeholder="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Active </label>
											<div class="col-sm-9">
												<input type="checkbox" id="active" name="active" value="">
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