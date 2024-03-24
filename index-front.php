<?php
include_once "./config/dbconnect.php";
if(session_status() != PHP_SESSION_ACTIVE)
	session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	
	if($stmt = $conn->prepare("SELECT tour_id, schedule_id, tour_exhibits, current_exhibit_id FROM tours WHERE tour_id=1")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($tour_id, $schedule_id, $tour_exhibits, $current_exhibit_id);
		$stmt->fetch();
	}
	$exhibitsArray = array();
	if($stmt = $conn->prepare("SELECT exhibit_id, exhibit_name FROM exhibits WHERE exhibit_id IN (" . $tour_exhibits . ")")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($exhibit_id, $exhibit_name);
		while ($stmt->fetch()) {
			$rowArray = array('exhibit_id'=>$exhibit_id, 'exhibit_name'=>$exhibit_name);
			array_push($exhibitsArray, $rowArray);
		}
	}
	$multimediaArray = array();
	if($stmt = $conn->prepare("SELECT exhibit_id, description, content_type, path FROM multimedia WHERE exhibit_id IN (" . $tour_exhibits . ")")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($exhibit_id, $description, $content_type, $path);
		while ($stmt->fetch()) {
			$singleArray = array('exhibit_id'=>$exhibit_id, 'description'=>$description, 'content_type'=>$content_type, 'path'=>$path );
			array_push($multimediaArray, $singleArray);
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

<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>StreamIT portal</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="JSOFT.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
		<script nomodule src="https://unpkg.com/@google/model-viewer@v0.7.1/dist/model-viewer-legacy.js"></script>  
		<script>
			var tourID = <?php echo $tour_id; ?>;
			var userType = <?php echo $_SESSION['user_type_id']; ?>;
			var exhibitsA = <?php echo json_encode($exhibitsArray); ?>;
			var exhibitsString = <?php echo json_encode($tour_exhibits); ?>;
			var multimediaA = <?php echo json_encode($multimediaArray); ?>;
			
			//alert(exhibitsString);
			Object.keys(exhibitsA).forEach(key => {
  //alert(exhibitsA[key].exhibit_id + exhibitsA[key].exhibit_name);
});
		</script>
	
	</head>
	<body>
		<section class="body">
			<header class="header">
				<!-- start: header -->
				<?php include "./header-front.php"; ?>
				<!-- end: header -->
			</header>
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include "./leftsidebar-front.php"; ?>
				<!-- end: sidebar -->

				<section id="maincontent" role="main" class="content-body">
					<header class="page-header">
						<h2 id="exhibit-title"></h2>
						<input type="hidden" id="exhibits-list" name="exhibits-list" value="<?php echo $exhibitsString?>">
						<input type="hidden" id="current-exhibit-id" name="current-exhibit-id" value="<?php echo $current_exhibit_id ?>">
						<input type="hidden" id="current-multimedia-id" name="current-multimedia-id" value="">
						<div class="right-wrapper pull-right" style="padding-top: 9px;">
							<?php if($_SESSION['user_type_id'] != 6){?>
							<button id="previous-exhibit" type="button" class="btn btn-primary">Previous</button>&nbsp;&nbsp;
							<button id="next-exhibit" type="button" class="btn btn-primary">Next</button>	
							<?php } ?>
							<div class="sidebar-right-toggle"></div>
						</div>
					</header>
					
					<div id="contentcontainer">
						<iframe width="1024" height="550" src="https://www.youtube.com/embed/TSCp9NkU3J0?si=E3hIYfuJTnD3WW-p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
						<div id="multimedia-container" class="demo">
							
						</div>
					</div>
						</div>
					
					</div>
					
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		
		
		<script>
		setInterval(function() {
		if(userType == 6){
			
			var fd = new FormData();
			
			
			fd.append('tour_id', tourID);
			
			$.ajax({
				url:"./controller/getCurrentExhibitController.php",
				method:"post",
				data:fd,
				processData: false,
				contentType: false,
				success: function(response){
					
					var result = JSON.parse(response);
					var exhibit_id = result.message;
					
					if(exhibit_id != ''){
						var index = exhibitsA.findIndex(x => x.exhibit_id == exhibit_id);
						$('#exhibit-title').html(exhibitsA[index].exhibit_name);
						var html_content = "";
						Object.keys(multimediaA).forEach(key => {
							if(multimediaA[key].exhibit_id == exhibit_id){
								html_content=html_content+ "<li><a href='#' onclick=ShowMultimedia('" + multimediaA[key].path + "')><i class='fa fa-file' aria-hidden='true'></i><span>" + multimediaA[key].description + "</span></a></li>";
							}
						});
						$('#multimedia-attachments').html(html_content);
					}
				},
				error: function(xhr, status, error) {
				
				}
			});
		}
	}, 2000);
	</script>
		
		
	</body>
</html>