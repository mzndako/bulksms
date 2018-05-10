<?php
$settings = array(
	"site_name",
	"description1"=>Array("label"=>"Home Page Description"),
	"site_address"=>Array("type"=>"textarea"),
	"welcome_title",
	"welcome_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"faq_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"about_us_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"company_email",
	"domain_name",
	'facebook_link',
	"image1"=>Array("type"=>"image","label"=>"Slide Show 1"),
	"image2"=>Array("type"=>"image", "label"=>"Slide Show 2"),
	"image3"=>Array("type"=>"image","label"=>"Slide Show 3"),
);
c()->template_name = basename(__DIR__);
//<li class="active"><a href="#" data-nav-section="home">Home</a></li>
//						<li><a href="#" data-nav-section="services">How it Works</a></li>
//						<li><a href="#" data-nav-section="faq">Faq</a></li>
//                        <li><a href="#" data-nav-section="about">About us</a></li>
//                        <li><a hre
$menu_file[] = string2array("link=home,section=home,label=Home Page");
$menu_file[] = string2array("link=message/bulksms,label=Bulk SMS");
$menu_file[] = string2array("link=bill/airtime,label=Airtime");
$menu_file[] = string2array("link=bill/dataplan,label=Dataplan");
$menu_file[] = string2array("link=bill/pay,label=Bill Payment");
$menu_file[] = string2array("link=admin/dashboard,label=Dashboard,show=login");
$menu_file[] = string2array("link=login/logout,label=Logout,show=login");
$menu_file[] = string2array("link=login,label=Login,show=logout");
$menu_file[] = string2array("link=login/register,label=Register,show=logout");
$menu_file[] = string2array("link=page/price,label=Price List");
$menu_file[] = string2array("link=page/api,label=API");
$menu_file[] = string2array("link=page/reseller,label=Reseller");
$menu_file[] = string2array("link=home#faq,section=faq,label=FAQ");
$menu_file[] = string2array("link=home#about,section=about,label=About Us");
$menu_file[] = string2array("link=home#contact,section=contact,label=Contact Us");

$default = array();
$scan__ = scandir(__DIR__."/default");
foreach($scan__ as $file__){
	if(endsWith($file__,".php")){
		ob_start();
		include __DIR__."/default/".$file__;
		$default[str_replace(".php", "", $file__)] = array("type"=>"textarea","value"=>ob_get_clean(), "attr"=>string2array("class=summernote,data-height=200px,data-width=100%"));
	}
}

