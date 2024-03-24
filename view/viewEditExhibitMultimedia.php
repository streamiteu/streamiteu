<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		if(isset($_POST['id']))
		{
			$exhibit_id=$_POST['id'];
			
			if($stmt = $conn->prepare("SELECT exhibit_id, exhibit_name FROM exhibits WHERE exhibit_id=?")){
				$stmt->bind_param('i', $exhibit_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($exhibit_id, $exhibit_name);
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

<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
			<div class="row">
						<div class="col-md-12">
							<form id="edit-exhibit-multimedia-form" enctype="multipart/form-data" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Exhibit multimedia</h2>
										<p class="panel-subtitle">
											Manage the multimedia content for exhibit.
										</p>
									</header>
									<div class="panel-body">
										
										<div class="form-group">
											<input type="hidden" id="exhibit_id" name="exhibit_id" value="<?php echo $exhibit_id?>">
											<label class="col-sm-3 control-label">Exhibit name </label>
											<label class="col-sm-9 control-label"><?php echo $exhibit_name?></label>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Multimedia description <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="textarea" name="multimedia_description" class="form-control" value="" placeholder="" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Content type</label>
											<div class="col-sm-9">
												<select id="multimedia-content-type" class="form-control" required>
													<option value="0" selected>link</option>
													<option value="1">file</option>
												</select>
											</div>
										</div>
										<div class="form-group multimedia-group">
											<label class="col-sm-3 control-label">Likn to multimedia content <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" id="multimedia_link" name="multimedia_link" class="form-control" value="" placeholder=""/>
											</div>
										</div>
										<div class="form-group file-group" style="display:none">
											<label class="col-md-3 control-label">Multimedia file upload <span class="required">*</span></label>
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
								
										<h2 class="panel-title">List of multimedia content</h2>
									</header>
									<div class="panel-body">
										<table class="table table-bordered table-striped mb-none" id="datatable-default">
											<thead>
												<tr>
													<th>Multimedia description</th>
													<th>Content type</th>
													<th class="hidden-phone">Path</th>
													<th class="hidden-phone" style="display:none"><i class="fa fa-key" aria-hidden="true"></i></th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if($stmt = $conn->prepare("SELECT multimedia_id, exhibit_id, description, content_type, path, active FROM multimedia WHERE exhibit_id=?")){
													$stmt->bind_param('i', $exhibit_id);
													$stmt->execute();
													$stmt->store_result();
													$stmt->bind_result($multimedia_id, $exhibit_id, $description, $content_type, $path, $active);
													while ($stmt->fetch()) {
												?>
												<tr class="gradeX">
													<td><?php echo $description ?></td>
													<td><?php echo $content_type ?></td>
													<td><?php echo $path ?></td>
													<td class="hidden-phone" style="display:none"><input id="approve-btn-<?php echo $multimedia_id ?>" type="checkbox" class="approved-btn" <?php if ($active == 1) echo 'checked' ?> onclick="atctivateMultimedia('approve-btn-<?php echo $multimedia_id ?>', <?php echo $multimedia_id ?>);" value="<?php echo $multimedia_id ?>"></td>
													
													<td>
														<a href="javascript:void(0);" class="delete-item-btn" data_exhibit_id="<?php echo $exhibit_id ?>" data-itemid="<?php echo $multimedia_id ?>" data-itemkey="multimedia_id" data-entity="multimedia" data-returnroute="editexhibitmultimedia">Delete</a>
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
					<form id="delete-multimedia-form" method="post">
						<input type="hidden" id="delete_item_id" name="delete_item_id" value="">
						<input type="hidden" id="delete_key" name="delete_key" value="">
						<input type="hidden" id="delete_entity" name="delete_entity" value="">
						<input type="hidden" id="return_route" name="return_route" value="">
						<input type="hidden" id="exhibit_id" name="exhibit_id" value="">
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