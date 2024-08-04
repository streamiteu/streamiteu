<?php
	include_once "../config/config.php";
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		if(isset($_POST['id']))
		{
			$tour_id=$_POST['id'];
			
			
		}else{
			//echo $_POST['id'];
			http_response_code(402);
			// return a JSON object with a message property
			echo json_encode(array("message" => "Lecture not found!"));
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

<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
			<div class="row">
						<div class="col-md-12">
							<form id="edit-lectures-form" enctype="multipart/form-data" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Tour lectures</h2>
										<p class="panel-subtitle">
											Manage the lectures for the tour.
										</p>
									</header>
									<div class="panel-body">
										<input type="hidden" id="tour_id" name="tour_id" value="<?php echo $tour_id?>">
										<div class="form-group">
											<label class="col-sm-3 control-label">Lecture title <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="textarea" name="lecture_title" class="form-control" value="" placeholder="" required/>
											</div>
										</div>
										<div class="form-group file-group">
											<label class="col-md-3 control-label">Lecture file upload <span class="required">*</span></label>
											<div class="col-md-6">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input">
															<i class="fa fa-file fileupload-exists"></i>
															<span class="fileupload-preview"></span>
														</div>
														<span class="btn btn-default btn-file">
															<span class="fileupload-exists change-btn">Change</span>
															<span class="fileupload-new">Select file</span>
															<input id="file_multimedia" name="file_multimedia" type="file" />
														</span>
														<a href="#" class="btn btn-default fileupload-exists remove-btn" data-dismiss="fileupload">Remove</a>
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
								
								
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
								
										<h2 class="panel-title">List of lectures</h2>
									</header>
									<div class="panel-body">
										<table class="table table-bordered table-striped mb-none" id="datatable-default">
											<thead>
												<tr>
													<th>Lecture title</th>
													<th class="hidden-phone">Path</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if($stmt = $conn->prepare("SELECT lecture_id, lecture_title, lecture_file_path FROM lectures WHERE tour_id=?")){
													$stmt->bind_param('i', $tour_id);
													$stmt->execute();
													$stmt->store_result();
													$stmt->bind_result($lecture_id, $lecture_title, $lecture_file_path);
													while ($stmt->fetch()) {
												?>
												<tr class="gradeX">
													<td><a href="<?php echo $site_url . '/'. $lecture_file_path?>" target="_blank"><?php echo $lecture_title ?></a></td>
													<td><?php echo $lecture_file_path ?></td>
													<td>
														<a href="javascript:void(0);" class="delete-item-btn" data_tour_id="<?php echo $tour_id ?>" data-itemid="<?php echo $lecture_id ?>" data-itemkey="lecture_id" data-entity="lectures" data-returnroute="edittourlectures">Delete</a>
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
							</form>
						</div>
					</div>
					
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
					<form id="delete-lecture-form" method="post">
						<input type="hidden" id="delete_item_id" name="delete_item_id" value="">
						<input type="hidden" id="delete_key" name="delete_key" value="">
						<input type="hidden" id="delete_entity" name="delete_entity" value="">
						<input type="hidden" id="return_route" name="return_route" value="">
						<input type="hidden" id="tour_id" name="tour_id" value="<?php echo $tour_id ?>">
						<input type="submit" class="btn btn-primary btnDelete" value="Delete" />
						<input type="calcel" id="cancelModal" class="btn btn-default" value="Cancel" />
						<label class="error delete-item-message"></label>
					</form>
				</div>
			</div>
			
		</div>
		
<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

							<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>	