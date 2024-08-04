<?php

	include_once "./config/dbconnect.php";
	
	if(!isset($_SESSION)){
		session_start();
	}

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		$id = $_SESSION['id'];
	}
?>
	<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title" style="display: none">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="./index.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard </span>
										</a>
									</li>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 3 || $_SESSION['user_type_id'] == 5) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-group" aria-hidden="true"></i>
											<span>Classes</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#classes" onclick="Router('classes')">
													List of classes
												</a>
											</li>
											<li>
												<a href="#newclass" onclick="Router('newclass')">
													Add new class
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 3 || $_SESSION['user_type_id'] == 5) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-graduation-cap" aria-hidden="true"></i>
											<span>Students</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#students" onclick="Router('students')">
													 List of students
												</a>
											</li>
											<li>
												<a href="#newstudent" onclick="Router('newstudent')">
													 Add new student
												</a>
											</li>
											<li>
												<a href="#importstudents" onclick="Router('importstudents')">
													 Import students from file
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									
									<li class="nav-parent">
										<a>
											<i class="fa  fa-film" aria-hidden="true"></i>
											<span>Tours</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#tours" onclick="Router('tours')">
													 Scheduled tours
												</a>
											</li>
											<?php if($_SESSION['user_type_id'] == 5) { ?>
											<li>
												<a href="#newtour" onclick="Router('newtour')">
													 Schedule new tour
												</a>
											</li>
											<?php } ?>
										</ul>
									</li>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2 || $_SESSION['user_type_id'] == 3) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-user" aria-hidden="true"></i>
											<span>Users</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#users" onclick="Router('users')">
													 List of users
												</a>
											</li>
											<li>
												<a href="#newuser" onclick="Router('newuser')">
													 Add new user
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if($_SESSION['user_type_id'] == 1) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>Institutions</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#institutions" onclick="Router('institutions')">
													 List of institutions
												</a>
											</li>
											<li>
												<a href="#newinstitution" onclick="Router('newinstitution')">
													 Add new institution
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2 || $_SESSION['user_type_id'] == 4) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-image" aria-hidden="true"></i>
											<span>Exhibits</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#exhibits" onclick="Router('exhibits')">
													 List of exhibits
												</a>
											</li>
											<li>
												<a href="#newexhibit" onclick="Router('newexhibit')">
													 Add new exhibit
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2 || $_SESSION['user_type_id'] == 4) { ?>
									<li class="nav-parent">
										<a>
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											<span>Exhibitions</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#exhibitions" onclick="Router('exhibitions')">
													 List of exhibitions
												</a>
											</li>
											<li>
												<a href="#newexhibition" onclick="Router('newexhibition')">
													 Add new exhibition
												</a>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2 ) { ?>
									<li class="nav-children">
										<a href="#scheduler" onclick="Router('scheduler')">
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<span>Scheduler</span>
										</a>
									</li>
									<?php } ?>
								</ul>
							</nav>
				
							<hr class="separator" />
						</div>
				
					</div>
				
				</aside>
<!-- end: sidebar -->