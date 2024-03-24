<?php
	if(isset($_GET['email']) && isset($_GET['token']))
	{
	  $email = $_GET['email'];
	  $token = $_GET['token'];
	}else{
		header("Location: signin.php");
		die();
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
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="assets/images/streamit_logo.png" height="54" alt="StreamIT Project Admin" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Reset password</h2>
					</div>
					<div class="panel-body">
						<div class="validation-message" style="display: none;">
							<ul style="display: block;">
								<li>
								<label id="error_message" class="error" style="display: inline-block;"></label>
								</li>
							</ul>
						</div>
						<div class="success-message" style="display: none;">
							<ul style="display: block;">
								<li>
								<label id="success_message" class="success" style="display: inline-block;"></label>
								</li>
							</ul>
							<p class="text-center">Use the following link to <a href="signin.php">Sign In!</a>
						</div>
						<form id="change_password" method="post">
							
							<input type="hidden" name="email" value="<?php echo $email;?>">
							<input type="hidden" name="token" value="<?php echo $token;?>">
               
							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">New password</label>
								</div>
								<div class="input-group input-group-icon">
									<input name="pwd" type="password" class="form-control input-lg" required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>
							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Confirm password</label>
								</div>
								<div class="input-group input-group-icon">
									<input name="cpwd" type="password" class="form-control input-lg" required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 text-right">
									<button type="submit" class="btn btn-primary hidden-xs">Reset</button>
									<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Reset</button>
								</div>
							</div>
							

						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2023 - StreamIT project. All rights reserved.</p>
			</div>
		</section>
		<!-- end: page -->
		<script type="text/javascript" src="./assets/javascripts/messages.js"></script>
		<script type="text/javascript" src="./assets/javascripts/ajaxWork.js"></script> 
		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>