<?php
include_once "./config/dbconnect.php";
if(!isset($_SESSION)){
    session_start();
}

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$session_user_type_id = $_SESSION['user_type_id'];
		$session_user_institution_id = $_SESSION['user_institution_id'];
	}else{
		header("Location: signin.php"); 
		exit();
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

	</head>
	<body>
		<section class="body">
			<header class="header">
				<!-- start: header -->
				<?php include "./header.php"; ?>
				<!-- end: header -->
			</header>
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include "./leftsidebar.php"; ?>
				<!-- end: sidebar -->

				<section id="maincontent" role="main" class="content-body">
					<header class="page-header">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								<li><span id="current_section">Dashboard </span></li>
								</li>
							</ol>
					
							<div class="sidebar-right-toggle"></div>
						</div>
					</header>
					<?php

					$sql_query = "";
					$total = 0;
					$total_notapproved = 0;
					$total_students = 0;
					$total_students_not_approved = 0;
					$total_classes = 0;
					$total_institutions = 0;
					$total_exhibitions = 0;
					$total_exhibits = 0;
					
					//USERS
					if($session_user_type_id == 2 || $session_user_type_id == 3 || $session_user_type_id == 5 || $session_user_type_id == 4){
						$sql_query = 'SELECT COUNT(*) FROM users, userinstitution, institutions WHERE users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND userinstitution.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM users';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total = $row[0];
					}
					
					if($session_user_type_id == 2 || $session_user_type_id == 3 || $session_user_type_id == 5 || $session_user_type_id == 4){
						$sql_query = 'SELECT COUNT(*) FROM users, userinstitution, institutions WHERE users.approved = 0 AND users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND userinstitution.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM users WHERE users.approved = 0';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_notapproved = $row[0];
					}
					
					
					//STUDENTS
					if($session_user_type_id == 3 || $session_user_type_id == 5){
						$sql_query = 'SELECT COUNT(*) FROM users, userinstitution, institutions WHERE users.user_type_id IN (3, 5, 6) AND users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND userinstitution.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM users WHERE users.user_type_id IN (3, 5, 6)';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_students = $row[0];
					}
					
					if($session_user_type_id == 2 || $session_user_type_id == 3 || $session_user_type_id == 5 || $session_user_type_id == 4){
						$sql_query = 'SELECT COUNT(*) FROM users, userinstitution, institutions WHERE users.user_type_id IN (3, 5, 6) AND users.approved = 0 AND users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND userinstitution.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM users WHERE users.user_type_id IN (3, 5, 6) AND users.approved = 0';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_students_not_approved = $row[0];
					}
					
					
					//CLASSES
					if($session_user_type_id == 3 || $session_user_type_id == 5){
						$sql_query = 'SELECT COUNT(*) FROM classes WHERE classes.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM classes';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_classes = $row[0];
					}
					
					//INSTITUTIONS
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM institutions';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_institutions = $row[0];
					}
					
					
					//EXHIBITIONS
					if($session_user_type_id == 2 || $session_user_type_id == 4){
						$sql_query = 'SELECT COUNT(*) FROM exhibitions WHERE exhibitions.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM exhibitions';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_exhibitions = $row[0];
					}
					
					//EXHIBITS
					if($session_user_type_id == 2 || $session_user_type_id == 4){
						$sql_query = 'SELECT COUNT(*) FROM exhibits, exhibitions WHERE exhibits.exhibition_id = exhibitions.exhibition_id AND exhibitions.institution_id IN (SELECT institution_id FROM userinstitution WHERE userinstitution.user_id = ' . $id . ')';
						//da se razmisli da se implementira distinct bidejki eden nastavnik se javuva vo poveke ucilista t.e. da se prikazuvaat samo ime prezime email.
					}
					if($session_user_type_id == 1){
						$sql_query = 'SELECT COUNT(*) FROM exhibits';
					}
					if($stmt = $conn->prepare($sql_query)){
						$stmt->execute();
						$row = $stmt->get_result()->fetch_row();
						$total_exhibits = $row[0];
					}
					?>
												
										
					<div id="contentcontainer">
						<div class="row">
							<div class="col-md-6 col-lg-12 col-xl-6">
							<div class="row">
							<?php if($session_user_type_id == 1){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-primary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-building"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Institutions</h4>
														<div class="info">
															<strong class="amount"><?php echo $total_institutions?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#institutions" onclick="Router('institutions')" class="text-muted text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							<?php } ?>
							
							<?php if($session_user_type_id == 2 || $session_user_type_id == 3 || $session_user_type_id == 1){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-secondary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-secondary">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Users registered</h4>
														<div class="info">
															<strong class="amount"><?php echo $total?></strong>
															<span class="text-primary">(<?php echo $total_notapproved?> not approved)</span>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#students" class="text-muted text-uppercase" onclick="Router('students')">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							<?php } ?>
							<?php if($session_user_type_id == 3 || $session_user_type_id == 1 || $session_user_type_id == 5){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-tertiary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-tertiary">
														<i class="fa fa-graduation-cap"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Students enroled</h4>
														<div class="info">
															<strong class="amount"><?php echo $total_students?></strong>
															<span class="text-primary">(<?php echo $total_students_not_approved?> not approved)</span>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#students" onclick="Router('students')" class="text-muted text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							<?php } ?>
							<?php if($session_user_type_id == 3 || $session_user_type_id == 1 || $session_user_type_id == 5){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-quartenary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-quartenary">
														<i class="fa fa-group"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Classes enroled</h4>
														<div class="info">
															<strong class="amount"><?php echo $total_classes?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#classes" onclick="Router('classes')" class="text-muted text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							<?php } ?>
							<?php if($session_user_type_id == 2 || $session_user_type_id == 1 || $session_user_type_id == 4){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-quartenary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-quartenary">
														<i class="fa fa-bar-chart-o"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Exhibitions registered</h4>
														<div class="info">
															<strong class="amount"><?php echo $total_exhibitions?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#exhibitions" onclick="Router('exhibitions')" class="text-muted text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							<?php } ?>
							<?php if($session_user_type_id == 2 || $session_user_type_id == 1 || $session_user_type_id == 4){?>
								<div class="col-md-12 col-lg-6 col-xl-6">
									<section class="panel panel-featured-left panel-featured-quartenary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-quartenary">
														<i class="fa fa-image"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Exhibits registered</h4>
														<div class="info">
															<strong class="amount"><?php echo $total_exhibits?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="#exhibits" onclick="Router('exhibits')" class="text-muted text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
							<?php } ?>
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

		
		
		
		
		
	</body>
</html>