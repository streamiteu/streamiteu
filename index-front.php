<?php
include_once "./config/config.php";
include_once "./config/dbconnect.php";
if(session_status() != PHP_SESSION_ACTIVE)
	session_start();


function searchForId($key, $array) {
   foreach ($array as $item) {
       if ($item['exhibit_id'] == $key) {
           return $item;
       }
   }
   return null;
}

$tempexhibitsArray = array();
$exhibitsArray = array();
if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	$id = $_SESSION['id'];
	if (isset($_GET['tour_id'])) {
		$tour_id=$_GET['tour_id'];
		
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
				array_push($exhibitsArray, $item);
			}
		}
	}
	

	
}else{
	header('Location: '.$site_url);
	//echo $_POST['id'];
	//http_response_code(401);

	// return a JSON object with a message property
	//echo json_encode(array("message" => "There was an error processing the request"));
	//die();
}
?>

<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>StreamIT Erasmus+ Project</title>
		<meta name="keywords" content="Robotics, Education, Museum, Virtual tour, Remote control" />
		<meta name="description" content="The project will provide teachers with modern, attractive, accessible, easy to use educational tool and new high quality open educational content.">
		<meta name="author" content="StreamIT Consortium">

		<link rel="apple-touch-icon" sizes="57x57" href="./apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="./apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="./apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="./apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="./apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="./apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="./apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="./apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="./apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="./android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="./favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
		<link rel="manifest" href="./manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="./ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">

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
					
					<!--
						<div id="app">
						  <div class="resizable-x">
							<div class="div0" style="flex: 70%;">
							  <iframe id="leftFrame" style="overflow:hidden; width:100% min-height: 700px" height="700" width="100%" frameBorder="0" src="videoframe.html"></iframe>
							</div>
							<div class="resizer-x"></div>
							<div class="resizable-y" style="flex: 30%;">
							
							<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http%3A%2F%2Fieee802%2Eorg%3A80%2Fsecmail%2FdocIZSEwEqHFr%2Edoc' width='100%' height='100%' frameborder='0'></iframe>
							
							</div>
						  </div>
						</div>
-->
						<img src="thumbnail_image002.jpg" width="100%" />
						
						<div id="multimedia-container" class="demo"></div>

						
					
					</div>
					
					<!-- end: page -->
				</section>
			</div>

			
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
		if(userType == 6 || userType == 5 || userType == 4){
			
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
					if(exhibit_id != '' && exhibit_id !=0){
						$('#multimedia-attachments li').removeClass('nav-active');
						$('#exhibit-'+exhibit_id).addClass('nav-active');
						var index = exhibitsA.findIndex(x => x.exhibit_id == exhibit_id);
						$('#exhibit-title').html(exhibitsA[index].exhibit_name);
					}
					/*
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
					
					*/
				},
				error: function(xhr, status, error) {
				
				}
			});
		}
	}, 2000);
	
/*	
	(function () {
  "use strict";

  // horizontal direction
  (function resizableX() {
    const resizer = document.querySelector(".resizer-x");
    resizer.addEventListener("mousedown", onmousedown);
    resizer.addEventListener("touchstart", ontouchstart);

    // for mobile
    function ontouchstart(e) {
      e.preventDefault();
      resizer.addEventListener("touchmove", ontouchmove);
      resizer.addEventListener("touchend", ontouchend);
    }
    function ontouchmove(e) {
      e.preventDefault();
      const clientX = e.touches[0].clientX;
      const deltaX = clientX - (resizer._clientX || clientX);
      resizer._clientX = clientX;
      const l = resizer.previousElementSibling;
      const r = resizer.nextElementSibling;
      // LEFT
      if (deltaX < 0) {
        const w = Math.round(parseInt(getComputedStyle(l).width) + deltaX);
        l.style.flex = `0 ${w < 10 ? 0 : w}px`;
        r.style.flex = "1 0";
      }
      // RIGHT
      if (deltaX > 0) {
        const w = Math.round(parseInt(getComputedStyle(r).width) - deltaX);
        r.style.flex = `0 ${w < 10 ? 0 : w}px`;
        l.style.flex = "1 0";
      }
    }
    function ontouchend(e) {
      e.preventDefault();
      resizer.removeEventListener("touchmove", ontouchmove);
      resizer.removeEventListener("touchend", ontouchend);
      delete e._clientX;
    }

    // for desktop
    function onmousedown(e) {
      e.preventDefault();
      document.addEventListener("mousemove", onmousemove);
      document.addEventListener("mouseup", onmouseup);
    }
    function onmousemove(e) {
      e.preventDefault();
      const clientX = e.clientX;
      const deltaX = clientX - (resizer._clientX || clientX);
      resizer._clientX = clientX;
      const l = resizer.previousElementSibling;
      const r = resizer.nextElementSibling;
      // LEFT
      if (deltaX < 0) {
        const w = Math.round(parseInt(getComputedStyle(l).width) + deltaX);
        l.style.flex = `0 ${w < 10 ? 0 : w}px`;
        r.style.flex = "1 0";
      }
      // RIGHT
      if (deltaX > 0) {
        const w = Math.round(parseInt(getComputedStyle(r).width) - deltaX);
        r.style.flex = `0 ${w < 10 ? 0 : w}px`;
        l.style.flex = "1 0";
      }
    }
    function onmouseup(e) {
      e.preventDefault();
      document.removeEventListener("mousemove", onmousemove);
      document.removeEventListener("mouseup", onmouseup);
      delete e._clientX;
    }
  })();
})();
*/
	</script>
		
		
	</body>
</html>