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
							<form id="insertexhibition-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Exhibition details</h2>
										<p class="panel-subtitle">
											Create new exhibition.
										</p>
									</header>
									
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition title <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibition_title" class="form-control" value="" placeholder="eg.: Exhibition of modern art" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition description <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="textarea" name="exhibition_description" class="form-control" value="" placeholder="eg.: Narative description of the exhibition of modern art" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Museum <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="museum" class="form-control" required>
													<option value="">Select museum </option>
													<?php
													$sql_query = "";
													if($session_user_type_id == 2 || $session_user_type_id == 4){
														$sql_query = "SELECT institution_id, institution_type, institution_name FROM institutions WHERE institution_type='museum' AND institution_id IN (" . $session_user_institution_id . ")";
													}
													if($session_user_type_id == 1){
														$sql_query = "SELECT institution_id, institution_type, institution_name FROM institutions WHERE institution_type='museum'";
													}
													if($stmt = $conn->prepare($sql_query)){
														$stmt->execute();
														$stmt->store_result();
														$stmt->bind_result($institution_id, $institution_type, $institution_name);
														while ($stmt->fetch()) {
													?>
													<option value="<?php echo $institution_id?>"><?php echo $institution_name?></option>
													<?php
														}
														$stmt->close();
													}
													
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition map <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibition_map" class="form-control" value="" placeholder="" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition ip <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibition_ip" class="form-control" value="" placeholder="" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition port <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="exhibition_port" class="form-control" value="" placeholder="" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition server name </label>
											<div class="col-sm-9">
												<input type="text" name="server_name" class="form-control" value="" placeholder=""/>
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