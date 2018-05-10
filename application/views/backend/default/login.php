<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	$system_name	=	c()->get_setting('system_name');
	$system_title	=	c()->get_setting('system_title');
	$theme = get_setting("current_backend_theme");
	$theme = empty($theme)?"default":$theme;
	$theme_path = "backend/$theme";
	$bg1 = get_setting("theme_login_bg_color1");
	$bg2 = get_setting("theme_login_bg_color2");
	$color1 = get_setting("theme_login_header_text_color");

	$array = new process_array(!empty($_POST)?$_POST:array());
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />
	
	<title><?php echo get_phrase('login');?> | <?php echo $system_title;?></title>
	


	<script src="<?=THEME_BACKEND_URL."/$theme";?>/js/jquery-1.11.0.min.js"></script>

<style>
	/*@import url(https://fonts.googleapis.com/css?family=Roboto:300);*/

	.login-page {
		/*width: 360px;*/
		padding: 8% 0 0;
		margin: auto;
	}
	.form {
		position: relative;
		z-index: 1;
		background: #FFFFFF;
		max-width: 360px;
		margin: 0 auto 100px;
		padding: 45px;
		text-align: center;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}
	.form input {
		font-family: "Roboto", sans-serif;
		outline: 0;
		background: white;
		width: 100%;
		border: 0;
		margin: 0 0 5px;
		padding: 15px;
		box-sizing: border-box;
		font-size: 14px;
	}
	.form button {
		font-family: "Roboto", sans-serif;
		text-transform: uppercase;
		outline: 0;
		background: #4CAF50;
		width: 100%;
		border: 0;
		padding: 15px;
		color: #FFFFFF;
		font-size: 14px;
		-webkit-transition: all 0.3 ease;
		transition: all 0.3 ease;
		cursor: pointer;
	}
	.form button:hover,.form button:active,.form button:focus {
		background: #43A047;
	}
	.form .message {
		margin: 15px 0 0;
		color: #7d0e0e;
		font-size: 14px;
	}
	.form .message a {
		color: #4CAF50;
		text-decoration: none;
	}
	.form .register-form {
		display: none;
	}
	.container {
		position: relative;
		z-index: 1;
		max-width: 300px;
		margin: 0 auto;
	}

	@media screen and (max-width: 400px) {
		.form{
			max-width: 100%;
			width: 100% !important;
		}
	}
	.container:before, .container:after {
		content: "";
		display: block;
		clear: both;
	}
	.container .info {
		margin: 50px auto;
		text-align: center;
	}
	.container .info h1 {
		margin: 0 0 15px;
		padding: 0;
		font-size: 36px;
		font-weight: 300;
		color: #1a1a1a;
	}
	.container .info span {
		color: #4d4d4d;
		font-size: 12px;
	}
	.container .info span a {
		color: #000000;
		text-decoration: none;
	}
	.container .info span .fa {
		color: #EF3B3A;
	}
	body {

		background: <?=$bg1;?>; /* fallback for old browsers */
		background: -webkit-linear-gradient(right, <?=$bg1;?>,<?=$bg2;?>);
		background: -moz-linear-gradient(right, <?=$bg1;?>,<?=$bg2;?>);
		background: -o-linear-gradient(right, <?=$bg1;?>,<?=$bg2;?>);
		background: linear-gradient(to left, <?=$bg1;?>,<?=$bg2;?>);
		font-family: "Roboto", sans-serif;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}
	.logo{
		position: absolute;
		top: 20px;
		width: 100px;;
		left: 50%;
		margin-left: -50px;
	}
</style>
	<link rel="stylesheet" href="<?=assets_url("$theme_path/css/material_boostrap.css");?>">
	<link rel="stylesheet" href="<?=assets_url("$theme_path/css/mine.css");?>">
</head>
<body>


<div class="login-page">
	<img class="logo" src="<?=c()->get_image_url("logo","logo");?>" alt="" />
	<h2 style="text-align: center; color: <?=$color1;?>"><?=get_setting("site_name");?></h2>

	<div class="form">
		<div align="center">
			<div align="left" style="color: red;">
				<?php
				if(!empty($error)){
					print $error;
				}
				?>
			</div>
		</div>
		<?php
			if(empty($reset_password)) {
				?>
				<form class="register-form attached" method="post" action="<?= url("login/register"); ?>">
					<h5>Registration</h5>
					<div class="form-group">
						<label class="bmd-label-floating">First Name</label>
						<input type="text" required value="<?= $array->get("fname"); ?>" name="fname"
						       class="form-control"/>
					</div>
					<div class="form-group">
						<label class="bmd-label-floating">Last Name</label>
						<input type="text" value="<?= $array->get("surname"); ?>" name="surname" class="form-control"/>
					</div>
					<?php
						if(default_register_column("username")) {
							?>
							<div class="form-group">
								<label class="bmd-label-floating">Username</label>
								<input type="text" value="<?= $array->get("username"); ?>" name="username" class="form-control"/>
							</div>
							<?php
						}
					?>

					<?php
					if(default_register_column("phone")) {
					?>
					<div class="form-group">
						<label class="bmd-label-floating">Phone</label>
						<input value="<?= $array->get("phone"); ?>" type="text" name="phone" class="form-control"/>
					</div>
						<?php
					}
					?>


					<?php
					if(default_register_column("email")) {
					?>
					<div class="form-group">
						<label class="bmd-label-floating">Email</label>
						<input type="text" name="email" value="<?= $array->get("email"); ?>" class="form-control"/>
					</div>
						<?php
					}
					?>

					<div class="form-group">
						<label class="bmd-label-floating">Sex</label>
						<select name="sex" class="form-control">
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>
					<div class="form-group">
						<label class="bmd-label-floating">Password</label>
						<input type="password" name="password1" class="form-control"/>
					</div>

					<div class="form-group">
						<label class="bmd-label-floating">Confirm Password</label>
						<input type="password" placeholder="password" name="password2" class="form-control"/>
					</div>
					<button>Create</button>
					<p class="message">Already registered? <a href="#">Sign In</a></p>
				</form>

				<form class="login-form attached" method="post" action="<?= url("login/login"); ?>">
					<h5>Login</h5>
					<div class="form-group">
						<label class="bmd-label-floating"><?=ucwords(implode(" Or ",default_login_column()));?></label>
						<input type="text" placeholder="<?=ucwords(implode(" Or ",default_login_column()));?>" value="<?= $array->get("username"); ?>"
						       name="username" class="form-control"/>
					</div>
					<div class="form-group">
						<label class="bmd-label-floating">Password</label>
						<input type="password" placeholder="Password" name="password" class="form-control"/>
					</div>
					<div class="form-group" style="padding-top: 0px; margin-bottom: 10px;">
						<label data-original-title="Select to always keep you login">
							<input type="checkbox" checked="checked" style="width: auto;" name="remember" value="1"/> Remember Me
						</label>
					</div>


					<button><i class="fa fa-sign-in" aria-hidden="true"></i> login</button>
					<p class="message">Not registered? <a href="#">Create an account</a></p>
<br>
					<p>Forgotten Password? <a href="<?= url('login/reset_password'); ?>">Recover Now</a>
					</p>
				</form>
				<?php
			}else {
				?>
				<form class="login-form attached" method="post" action="<?= url("login/reset_password"); ?>">
					<input type="hidden" name="stage" value="<?=$stage;?>" />
					<?php
						if($stage == 1) {
							?>
							<div class="form-group">
								<label class="bmd-label-floating">Enter <?=ucwords(implode(" Or ",default_login_column()));?></label>
								<input type="text" placeholder="<?=ucwords(implode(" Or ",default_login_column()));?>" value="<?= $array->get("username"); ?>"
								       name="username" class="form-control"/>
							</div>

							<button><i class="fa fa-sign-in" aria-hidden="true"></i> Reset Password</button>
							<?php
						}else if($stage == 2) {
							?>

							<input type="hidden" name="id" value="<?=$user_id;?>";?>
							<div class="form-group">
								<label class="bmd-label-floating">Password Reset CODE</label>

								<input type="text" placeholder="Code" value="<?= $array->get("code"); ?>"
								       name="code" class="form-control"/>
							</div>

							<button><i class="fa fa-sign-in" aria-hidden="true"></i> Verify Code</button>
							<?php
						}else {
							?>

							<input type="hidden" name="id" value="<?=$user_id;?>"/>
							<input type="hidden" name="code" value="<?=$code;?>"/>

							<div class="form-group">
								<label class="bmd-label-floating">New Password</label>
								<input type="password" placeholder="New Password" 								       name="new_password" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="bmd-label-floating">Confirm Password</label>
								<input type="password" placeholder="Confirm Password" 								       name="confirm_password" class="form-control"/>
							</div>
							<button><i class="fa fa-sign-in" aria-hidden="true"></i> Reset Password</button>
							<?php
						}
					?>
<br>
<br>
					<p ><a href="<?= url('login'); ?>">Login</a>
					</p>
				</form>
				<?php
			}
		?>
	</div>
</div>


	<!-- Bottom Scripts -->
	<script src="<?=THEME_BACKEND_URL."/$theme";?>/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?=THEME_BACKEND_URL."/$theme";?>/js/bootstrap.js"></script>
	<script src="<?=THEME_BACKEND_URL."/$theme";?>/js/jquery.validate.min.js"></script>
	<script src="<?=THEME_BACKEND_URL."/$theme";?>/js/mine.js"></script>
	<script>
		$('.message a').click(function(){
			$('.register-form,.login-form').animate({height: "toggle", opacity: "toggle"}, "slow");
		});
		<?php
		if(empty($reset_password) && !empty($is_register)){
			print "$('.message a').first().trigger('click')";
		}


 ?>
	</script>
</body>
</html>