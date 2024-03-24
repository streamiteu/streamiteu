<?php
include_once "../config/dbconnect.php";
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	$user_type_id = $_SESSION['user_type_id'];
	
	if(isset($_POST['id'])){
			$exhibition_id = $_POST['id'];
			if($stmt = $conn->prepare("SELECT exhibitions.exhibition_title, exhibitions.institution_id, exhibitions.exhibition_ip, exhibitions.exhibition_port, exhibitions.server_name FROM exhibitions WHERE exhibitions.exhibition_id=?")){
				$stmt->bind_param('i', $exhibition_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($exhibition_title, $institution_id, $exhibition_ip, $exhibition_port, $server_name);
				$stmt->fetch();
			}else{
				//echo $_POST['id'];
				http_response_code(402);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Exhibit not found!"));
				die();
			}
	}
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "There was an error processing the request"));
	die();
}
?>

<style>
  #left {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 50%;
            background: rgba(0, 255, 0, 0.1);
        }

        #right {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 300px;
            background: rgba(0, 0, 255, 0.1);
        }
		
</style>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/nipplejs/0.7.3/nipplejs.js"></script>

					<div class="row">
						<div class="col-md-12">
							<form id="insertclass-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Map exhibition</h2>
										<p class="panel-subtitle">
											Create exhibition map.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Exhibition title </label>
											<div class="col-sm-9">
												<input type="text" name="exhibition_title" class="form-control" value="<?php echo $exhibition_title ?>"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label">Map</label>
											
											
											<div class="col-sm-12">
												<iframe width="790" height="555" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
					
												
												
												
        <div id="right"></div>
       
        <script>
            

            var joystickR = nipplejs.create({
                zone: document.getElementById('right'),
                mode: 'static',
                position: { left: '50%', top: '50%' },
                color: 'red',
                size: 200
            });
        </script>



												
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

