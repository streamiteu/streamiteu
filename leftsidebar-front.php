<?php
include_once "./config/dbconnect.php";
include_once "./config/config.php";
if(!isset($_SESSION)){
    session_start();
}


$tempexhibitsArray = array();
$exhibitsArray = array();

$lectures = "";
$multimedia = "";
if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	
	if (isset($_GET['tour_id'])) {
		$tour_id=$_GET['tour_id'];
		
		if($stmt = $conn->prepare("SELECT lecture_id, lecture_title, lecture_file_path FROM lectures WHERE tour_id=?")){
			$stmt->bind_param('i', $tour_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($lecture_id, $lecture_title, $lecture_file_path);
			
			while ($stmt->fetch()) {
				$lectures = $lectures . "<li class='nav'><a href='". $site_url . '/'. $lecture_file_path . "' target='_blank'><i class='fa fa-book' aria-hidden='true'></i><span>" . $lecture_title . "</span></a></li>";
			}
		}
		
		
		if($stmt = $conn->prepare("SELECT tour_id, schedule_id, tour_exhibits, current_exhibit_id FROM tours WHERE tour_id=?")){
			$stmt->bind_param('i', $tour_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($tour_id, $schedule_id, $tour_exhibits, $current_exhibit_id);
			$stmt->fetch();
		}
		
		$temp = array_map('trim', explode(',', $tour_exhibits));
		if($stmt = $conn->prepare("SELECT exhibit_id, exhibit_name FROM exhibits WHERE exhibit_id IN (" . $tour_exhibits . ")")){
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($exhibit_id, $exhibit_name);
			while ($stmt->fetch()) {
				$rowArray = array('exhibit_id'=>$exhibit_id, 'exhibit_name'=>$exhibit_name);
				array_push($tempexhibitsArray, $rowArray);
			}
		}

		foreach ($temp as $x) {
			$item = searchForId($x, $tempexhibitsArray);
			if (!empty($item)) {
				$multimedia = $multimedia . "<li id='exhibit-".$item['exhibit_id']. "' class='nav-parent'><a><i class='fa fa-file-image-o' aria-hidden='true'></i><span>" . $item['exhibit_name'] . "</span></a><ul class='nav nav-children'>";
				if($stmt1 = $conn->prepare("SELECT multimedia_id, exhibit_id, description, content_type, path FROM multimedia WHERE exhibit_id=?")){
					$stmt1->bind_param('i', $item['exhibit_id']);
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($multimedia_id, $exhibit_id, $description, $content_type, $path);
					while ($stmt1->fetch()) {
						$multimedia = $multimedia . "<li><a href='#' onclick=ShowMultimedia('" . $path . "')><i class='fa fa-file'></i><span>" . $description . "</span></a></li>";
					}
				}
				$multimedia = $multimedia . "</li></ul>";
			}
		}
		
		
		
		
		/*
		
		if($stmt = $conn->prepare("SELECT exhibit_id, exhibit_name FROM exhibits WHERE exhibit_id IN (" . $tour_exhibits . ")")){
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($exhibit_id, $exhibit_name);
			while ($stmt->fetch()) {
				
				$multimedia = $multimedia . "<li id='exhibit-".$exhibit_id. "' class='nav-parent'><a><i class='fa fa-group' aria-hidden='true'></i><span>" . $exhibit_name . "</span></a><ul class='nav nav-children'>";
				
				if($stmt1 = $conn->prepare("SELECT multimedia_id, exhibit_id, description, content_type, path FROM multimedia WHERE exhibit_id=?")){
					$stmt1->bind_param('i', $exhibit_id);
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($multimedia_id, $exhibit_id, $description, $content_type, $path);
					while ($stmt1->fetch()) {
						$multimedia = $multimedia . "<li><a href='#' onclick=ShowMultimedia('" . $path . "')><i class='fa fa-file'></i><span>" . $description . "</span></a></li>";
					}
				}
				$multimedia = $multimedia . "</li></ul>";
				
			}
		}
		*/
		
	}
	
	
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "There was an error processing the request"));
	die();
}


	

?>
<script>
function CloseMultimedia(){
		$("#multimedia-container").html('');
	}
</script>
<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title" style="color: #ffffff">
							Educational materials 
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul id="lectures-files" class="nav nav-main">
									<?php echo $lectures ?>
								</ul>
								<hr>
								<ul id="multimedia-attachments" class="nav nav-main">
									<?php echo $multimedia ?>
								</ul>
								<hr>
								<ul id="multimedia-close" class="nav nav-main">
									<li>
										<a href="#" onclick="CloseMultimedia()">
											<i class="fa fa-times-circle" aria-hidden="true"></i>
											<span>Close multimedia</span>
										</a>
									</li>
								</ul>
							</nav>
				
							<hr class="separator" />
						</div>
				
					</div>
				
				</aside>
<!-- end: sidebar -->
