<footer id="ubea-footer" role="contentinfo">
	<div class="ubea-container">

		<div class="row copyright">
			<div class="col-md-12">
				<p class="pull-left">
					<small class="block">&copy; 2017. All Rights Reserved.</small>

				</p>
				<p class="pull-right">
				<ul class="ubea-social-icons pull-right">
					<li><a href="<?=c()->get_template_settings("facebook_link");?>"><i class="icon-facebook"></i></a></li>
				</ul>
				</p>
			</div>
		</div>

	</div>
</footer>
<div class="gototop js-top">
	<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>

<a id="perform_click"></a>
<!-- jQuery -->
<script src="<?=assets_url("$theme_path/js/jquery.min.js");?>"></script>
<!-- jQuery Easing -->
<script src="<?=assets_url("$theme_path/js/jquery.easing.1.3.js");?>"></script>
<!-- Bootstrap -->
<script src="<?=assets_url("$theme_path/js/bootstrap.min.js");?>"></script>
<!-- Waypoints -->
<script src="<?=assets_url("$theme_path/js/jquery.waypoints.min.js");?>"></script>
<!-- Carousel -->
<script src="<?=assets_url("$theme_path/js/owl.carousel.min.js");?>"></script>
<!-- countTo -->
<script src="<?=assets_url("$theme_path/js/jquery.countTo.js");?>"></script>
<!-- Flexslider -->
<script src="<?=assets_url("$theme_path/js/jquery.flexslider-min.js");?>"></script>
<!-- Magnific Popup -->
<script src="<?=assets_url("$theme_path/js/jquery.magnific-popup.min.js");?>"></script>
<script src="<?=assets_url("$theme_path/js/magnific-popup-options.js");?>"></script>
<!-- Main -->
<script src="<?=assets_url("$theme_path/js/main.js");?>"></script>

<?php
	if(c()->get_setting("enable_tawk") == 1) {
		?>
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src='https://embed.tawk.to/<?=$tawk;?>/default';
				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
			})();
		</script>
		<!--End of Tawk.to Script-->
		<?php
	}
?>