<?php
	include_once './config/config.php';
	include_once "./config/dbconnect.php";
	if(session_status() != PHP_SESSION_ACTIVE)
		session_start();


	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		
		if (isset($_GET['tour_id'])) {
			$tour_id=$_GET['tour_id'];
			if($stmt = $conn->prepare("SELECT tour_attendees, tour_teacher_id, tour_guide_id FROM tours WHERE tour_id=?")){
				$stmt->bind_param('i', $tour_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($tour_attendees, $tour_teacher_id, $tour_guide_id);
				$stmt->fetch();
			}
			if($stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_id=? AND user_id IN (" . $tour_attendees . ") OR user_id=? OR user_id=?")){
				$stmt->bind_param('iii', $id, $tour_teacher_id, $tour_guide_id);
				$stmt->execute();
				$row = $stmt->get_result()->fetch_row();
				$rowsTotal = $row[0];
				if($rowsTotal == 0){
					header('Location: '.$site_url);
				}
			}
		} else {
			header('Location: '.$site_url);
		}
	}else{
		header('Location: '.$site_url.'/logout.php');
	}

	if($stmt = $conn->prepare('SELECT users.user_id, users.first_name, users.last_name, users.email, users.user_type_id, user_type.user_type_description, users.institution_id, user_type.user_type_description FROM users, user_type WHERE user_type.user_type_id = users.user_type_id AND users.user_id=?')){
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $first_name, $last_name, $email, $user_type_id, $user_type_description, $institution_id, $user_type_description);
		$stmt->fetch();
	}
	
?>
<!-- start: header -->
			<div class="header-wrapper">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/streamit_logo.png" height="35" alt="JSOFT Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			

					<!--<span class="separator"></span>-->
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<div class="circle">
							  <p class="circle-inner"><?php echo strtoupper(mb_substr($first_name, 0, 1)) . strtoupper(mb_substr($last_name, 0, 1))?></p>
							</div>
							<div class="profile-info" data-lock-name="<?php echo $first_name . ' ' . $last_name ?>" data-lock-email="<?php echo $email ?>">
								<span class="name"><?php echo $first_name . ' ' . $last_name ?></span>
								<span class="role"><?php echo $user_type_description ?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo $site_url ?>"><i class="fa fa-home"></i> My Dashboard</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" onclick="Logout()" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</div>
<!-- end: header -->
<?php
	//$conn->close();
?>	