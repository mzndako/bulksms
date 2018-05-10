<div style="position: fixed;top: 0px;left: 0;right: 0; z-index: 9999999;">
	<div id="loading-line" style="display: none; width: 50%;
	position: relative"><div id="loadingProgressG_1" class="loadingProgressG"></div></div>
	<div id="my_loading_bar">


	</div>
</div>

<div class="site-wide-notification success" id="site-wide-notification" style="position: relative;">
	<span class="message"></span>
	<a href="#" class="close"><i class="fa fa-close"></i></a>

	<div class="my-loading-line" style="height: 2px; background: #ccc; width: 100%;"></div>
</div>

<header class="main-header">

	<!-- Logo -->
	<a href="#" class="logo">
		<?=get_setting("site_name");?>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">

		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle mymenu"  title="Toggle Menu" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<i data-intro="Click Here to Open Menu Bar" data-removeintro="true"  class="fa fa-bars" aria-hidden="true"></i>
		</a>
<!---->
<!--		<a href="javascript:void(0)" title="Full Screen" onclick="$(document).fullScreen(!$(document).fullScreen())" class="sidebar-toggle sidebar-toggle-no-before" >-->
<!--			<i class="fa fa-arrows-alt" aria-hidden="true"></i>-->
<!--		</a>-->
<!--		<a href="javascript:void(0)" title="Help" onclick="startIntro()" class="sidebar-toggle sidebar-toggle-no-before myhelp" >-->
<!--			<i class="fa fa-question-circle" aria-hidden="true"></i>-->
<!--		</a>-->
		<a href="javascript:void(0)"  title="back" onclick="history.back();" class="sidebar-toggle sidebar-toggle-no-before" >
			<i data-intro="Click to go back to the previous page" data-removeintro="true"  class="fa fa-arrow-left" aria-hidden="true"></i>
		</a>
		<a href="javascript:void(0)" title="refresh"  onclick="reloadPage();" class="sidebar-toggle sidebar-toggle-no-before" >
			<i data-intro="Click to refresh or reload current page" data-removeintro="true" class="fa fa-refresh" aria-hidden="true"></i>
		</a>
		<a style="font-weight: bold;" data-intro="Shows your current account balance" data-removeintro="true" id="my_balance" ajax="true" href="<?=url("wallet/fund");?>" title="Recharge Account"  class="sidebar-toggle sidebar-toggle-no-before" >
			<?=format_amount(!empty(login_id())?user_balance():0, -1);?>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">

			<ul class="nav navbar-nav">




				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
<!--						<img src="--><?php //c()->get_image_url($login_as , $login_id);?><!--" class="user-image" >-->
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs"><i class="entypo-user"></i> <?php echo $this->session->userdata('name')." (".$this->session->userdata('login_as').")";?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<img src="<?=c()->get_image_url("profile", login_id());?>" class="img-circle" alt="">

							<p>
								<?php echo $this->session->userdata('name');?>
								<small><?php echo $this->session->userdata('login_as');?></small>
							</p>
						</li>
						<!-- Menu Body -->
<!--						<li class="user-body">-->
<!--							<div class="row">-->
<!--								<div class="col-xs-4 text-center">-->
<!--									<a href="https://almsaeedstudio.com/themes/AdminLTE/starter.html#">Followers</a>-->
<!--								</div>-->
<!--								<div class="col-xs-4 text-center">-->
<!--									<a href="https://almsaeedstudio.com/themes/AdminLTE/starter.html#">Sales</a>-->
<!--								</div>-->
<!--								<div class="col-xs-4 text-center">-->
<!--									<a href="https://almsaeedstudio.com/themes/AdminLTE/starter.html#">Friends</a>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!-- /.row -->
<!--						</li>-->
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a ajax="true" href="<?=url('users/profile');?>" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a  data-href="<?= url("login/logout") ;?>" href="javascript:void(0)" data-title="Logout?" onclick="show_dialog(this, function(confirm, me){ if(confirm) open_link(me)})" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
<!--					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
				</li>
			</ul>
		</div>
	</nav>
</header>

