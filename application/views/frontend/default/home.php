


	<div id="ubea-hero" class="js-fullheight" >
		<div class="flexslider js-fullheight" >
			<ul class="slides">
		   	<li style="background-image: url(<?=c()->get_image_url("theme_images","$theme"."_image1");?>);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text" align="center">
		   				<div class="slider-text-inner">
		   					<h2><?=c()->get_template_settings("site_name");?></h2>
							<b><?=c()->get_template_settings("description1");?></b><br>
						    <p><a href="<?=url("login/login");?>" class="btn btn-primary btn-lg">Login</a><a href="<?=url("login/register");?>" class="btn btn-primary btn-lg">Register</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(<?=c()->get_image_url("theme_images","$theme"."_image2");?>);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<h2>Join Us Now</h2>
						    <p><a href="<?=url("login/login");?>" class="btn btn-primary btn-lg">Login</a><a href="<?=url("login/register");?>" class="btn btn-primary btn-lg">Register</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(<?=c()->get_image_url("theme_images","$theme"."_image1");?>);">
		   		<div class="overlay"></div>
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<h2>A new experience.</h2>
						    <p><a href="<?=url("login/login");?>" class="btn btn-primary btn-lg">Login</a><a href="<?=url("login/register");?>" class="btn btn-primary btn-lg">Register</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		  	</ul>
	  	</div>
	</div>

	<div class="ubea-section-overflow">

		<div class="ubea-section" id="ubea-services" data-section="home">
			<div class="ubea-container" id="welcome">
				<?php

//				print d()->get_where("konten","name","home")->row()->comments;

				?>
			</div>
		</div>

		<?php
			if(!empty(c()->get_template_settings("welcome_title"))) {
				?>
				<div class="ubea-section" id="ubea-portfolio" data-section="services">
					<div class="ubea-container" id="services">
						<h1>
							<center><?= c()->get_template_settings("welcome_title"); ?></center>
						</h1>
						<?= c()->get_template_settings("welcome_content"); ?>
					</div>
				</div>
				<?php
			}
		?>

		<?php
		if(!is_strip_empty(c()->get_template_settings("welcome_title"))) {
		?>
			<div class="ubea-section" id="ubea-faq" data-section="faq">
				<div class="ubea-container" id="faq">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center ubea-heading">
							<h2>Frequently Ask Questions</h2>
							<p>
								<?php

								?>
								<?=c()->get_template_settings("faq_content");?>


							</p>
						</div>
					</div>

				</div>
			</div>
			<?php
		}
		?>

	</div>

	<?php
		if(!is_strip_empty(c()->get_template_settings("about_us_content"))) {
	?>
	    <div id="ubea-blog" data-section="about">
			<div class="ubea-container" id="about">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center ubea-heading">
						<h2>About us</h2>
						<p>
							<?=c()->get_template_settings("about_us_content");?>
						</p>
					</div>
				</div>
		    </div>
	    </div>
			<?php
		}
	?>

	<div id="ubea-contact" data-section="contact" class="ubea-cover ubea-cover-xs" style="background-image:url(<?=c()->get_image_url("theme_images","$theme"."_image2");?>);">
		<div class="overlay"></div>
		<div class="ubea-container" id="contact">
			<div class="row text-center">
				<div class="display-t">
					<div class="display-tc">
						<div class="col-md-12">
							<h3>If you have enqueries please email us at <a href="#">							<?=c()->get_template_settings("company_email");?></a></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>






