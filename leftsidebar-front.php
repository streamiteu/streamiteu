<script>
function CloseMultimedia(){
		$("#multimedia-container").html('');
	}
</script>
<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title" style="color: #ffffff">
							Multimedia attachments
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul id="multimedia-attachments" class="nav nav-main">
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
