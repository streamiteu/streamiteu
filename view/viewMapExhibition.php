<?php
include_once "../config/dbconnect.php";
include_once "../config.php";
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
<script type="text/javascript" src="./assets/javascripts/Rbscripts/rosjsScripts/nipplejs.js"></script>
<script type="text/javascript" src="./assets/javascripts/Rbscripts/rosjsScripts/createjs.min.js"></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/rosjsScripts/roslib.min.js"></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/rosjsScripts/eventemitter2.min.js"></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/rosjsScripts/ros2d.min.js" defer></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/rosjsScripts/nav2d.js"></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/rosjsScripts/mjpegcanvas.min.js"></script>
		
		
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/RobotScripts/init.js" defer></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/RobotScripts/drive.js" defer></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/RobotScripts/createMap.js" defer></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/RobotScripts/odometry.js" defer></script>
		<script type="text/javascript"  src="./assets/javascripts/Rbscripts/RobotScripts/camera.js" defer></script>
       
        <script defer>	
			

            window.joystickR = nipplejs.create({
                zone: document.getElementById('right'),
                mode: 'static',
                position: { left: '50%', top: '50%' },
                color: 'red',
                size: 200
            });
		
            var url="ws://<?php echo strval($exhibition_ip).':'?><?php echo strval($exhibition_port).''?>";
			window.RB1=true;
			initRobot(url,"robotStatus");
			if(!window.RB1){			
			nav_and_map_init();
			setDrive();
			getCoordinates();
			cam_init();
			}
			else{
				nav_and_map_initRB1();
				setDriveRB1();
				getCoordinatesRB1();
				cam_initRB1();
			}
			function callSaveExhibit(){
				var exName=document.getElementById('exibitTitle').value;
				var exDesc=document.getElementById('description').value;				
				var xPosVar=document.getElementById('poseXH').value;
				var yPosVar=document.getElementById('poseYH').value;
				var zPosVar=document.getElementById('poseZH').value;
				var xOrVar=document.getElementById('orenXH').value;
				var yOrVar=document.getElementById('orenYH').value;
				var zOrVar=document.getElementById('orenZH').value;
				var wOrVar=document.getElementById('orenWH').value;

				saveExhibit(exName,exDesc,<?php echo $exhibition_id ?>,xPosVar,yPosVar,zPosVar,xOrVar,yOrVar,zOrVar,wOrVar)
			}
			



        </script>


  
					<div class="row">
						<div class="col-md-12">
							
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
												<input type="text" disabled name="exhibition_title" class="form-control" value="<?php echo $exhibition_title ?>"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label">Map</label>
											
											<div  id="robotStatus"></div>
											<div  id="poseX"></div>
        									<div  id="poseY"></div>
        									<div  id="poseZ"></div>
        									<div  id="orenX"></div>
        									<div  id="orenY"></div>
        									<div  id="orenZ"></div>
											<div  id="orenW"></div>
											
											<input type="hidden" value="" id="poseXH"/>
        									<input type="hidden" value="" id="poseYH"/>
        									<input type="hidden" value="" id="poseZH"/>
        									<input type="hidden" value="" id="orenXH"/>
        									<input type="hidden" value="" id="orenYH"/>
        									<input type="hidden" value="" id="orenZH"/>
											<input type="hidden" value="" id="orenWH"/>
											<div class="col-sm-12">
											<div class="camCanvas" id="mjpeg"></div>
												<br/>
												<div id="map"></div>
												<div id="robot_map"></div>												
												<div class="com-md-3">
                    <button  id="zoom"onclick="MapZoomFunc()">+</button>
                    <button  id="zoomout"onclick="MapPanFunc()">-</button>
                    </div>
					<br/>
					<div>
						<span>Enter exhibit title</span>
						<br/>
						<div>
					<input id="exibitTitle"></input>
					<br/>
					<span>Enter exhibit description</span>
					<input type="textarea" name="exhibit_description" class="form-control" value="" placeholder="eg.: Handmade vase from ceramics" required rows="4" cols="50" style="width:50%" id="description"/>
					<br/>					
						</div>
					</div>
					
												
												
												
        <div id="right"></div>
	


												
											</div>
										</div>
										
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button class="btn btn-primary" onclick="callSaveExhibit()">Save</button>
												<button type="reset" class="btn btn-default">Reset</button>
												<label class="error editclass-message return-message"></label>
											</div>
										</div>
									</footer>
								</section>
							
						</div>
					</div>
<?php
	$conn->close();
?>		

<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>	