<nav class="ubea-nav" role="navigation" style="background: black;">
	<div class="ubea-container">
		<div class="row">
			<div class="col-sm-2 col-xs-12">
				<div id="ubea-logo">
					<a href="index.php">
						<?=c()->get_template_settings("site_name");?>
						<!--					<img src="home/members/images/logo.png" width="50px"  />-->
					</a>
				</div>
			</div>

			<div class="col-xs-10 text-right menu-1 main-nav">
				<ul>
					<?php
						$menu = new front_menu();
						$is_login = is_login();
						$result = "";

						foreach($menu->children() as $parent1){
							$show = getIndex($parent1,'show', "all");
							$section = getIndex($parent1,'section', "");
							$link = getIndex($parent1, "link", "");
							$href = "href='#'";
							if($link != "#"){
								$href = "href='".url($link)."' onclick='open_link(this)' ";
							}

							if(($show == "login" && !$is_login) || ($show == "logout" && $is_login))
								continue;

							$child = $menu->children($parent1['item_id']);
							$drop = empty($child)?"":"dropdown";
							$result .= "<li class='$drop'><a class='external' data-toggle='$drop' $href data-nav-section='$section'>$parent1[label]</a>";

							if(!empty($child)){
								$result .= "<ul class='dropdown-content'>";
								foreach($child as $parent2){
									$show = getIndex($parent2,'show', "all");
									if(($show == "login" && !$is_login) || ($show == "logout" && $is_login))
										continue;
									$link = getIndex($parent1, "link", "");
									$href = "href='#' ";
									if($link != "#")
										$href .= "data-href='".url($link)."' onclick='open_link(this)' ";
									$result .= "<li><a $href data-nav-section='$parent2[label]'>$parent2[label]</a>";

								}
								$result .= "</ul>";
							}
							$result .= "</li>";
						}
					print $result;
					?>
<!--					<li class="active"></li>-->
<!--					<li><a href="#" data-nav-section="services">Welcome</a></li>-->
<!--					<li><a href="#" data-nav-section="faq">Faq</a></li>-->
<!--					<li><a href="#" data-nav-section="about">About us</a></li>-->
<!--					--><?php
//					if(!hAccess("login")) {
//						?>
<!--						<li><a href="#" data-href="--><?//= url("login/register"); ?><!--"-->
<!--						       onclick="open_link(this);" >Register</a></li>-->
<!--						<li><a href="#" data-href="--><?//= url("login"); ?><!--" onclick="open_link(this)">Login</a>-->
<!--						</li>-->
<!--						--><?php
//					}else {
//						?>
<!--						<li><a href="#" data-href="--><?//= url("login"); ?><!--" onclick="open_link(this)">DashBoard</a>-->
<!--						</li>-->
<!--						<li><a href="" data-href="--><?//= url("login/logout"); ?><!--" onclick="open_link(this)">Logout</a>-->
<!--						</li>-->
<!--						--><?php
//					}
//					?>
<!--					<li><a href="#" data-nav-section="contact">Contact Us</a></li>-->
				</ul>
			</div>
		</div>

	</div>
</nav>
<style>
	li.dropdown {
		/*display: inline-block;*/
		position: relative;
	}

	.dropdown-content {
		display: none;
		position: absolute;
		background-color: #200c1f;
		color: white;
		left: 0px;
		min-width: 180px;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		/*z-index: 1;*/
	}

	.dropdown-content li{
		display: block !important;
		text-align: center !important;
	}

	.dropdown-content a {
		color: white;;
		/*padding: 12px 16px;*/
		text-decoration: none;
		/*display: block;*/
		text-align: left;
	}
	.dropdown:hover .dropdown-content {
		display: block;
	}
</style>