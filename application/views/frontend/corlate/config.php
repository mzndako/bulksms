<?php
$settings = array(
	"site_name",
	"phone",
	"description1"=>Array("label"=>"Home Page Description"),
	"site_address"=>Array("type"=>"textarea"),
	"welcome_title",
	"welcome_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"faq_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"about_us_content"=>"attr=class=summernote|data-height=200px,type=textarea",
	"company_email",
	"domain_name",
	'facebook_link',
	'twitter_link',
	'linkedin_link',
	'skype_link',
	'top_header1'=>"type=color,label=First Top Header Color",
	'top_header2'=>"type=color,label=Second Top Header Color",
	"logo"=>Array("type"=>"image","label"=>"Site Logo"),
	"image1"=>Array("type"=>"image","label"=>"Slide Show 1"),
	"slide1"=>Array("type"=>"textarea","label"=>"Slide Show 1 Write Up"),
	"image2"=>Array("type"=>"image", "label"=>"Slide Show 2"),
	"slide2"=>Array("type"=>"textarea","label"=>"Slide Show 2 Write Up"),
	"image3"=>Array("type"=>"image","label"=>"Slide Show 3"),
	"slide3"=>Array("type"=>"textarea","label"=>"Slide Show 3 Write Up"),
	"footer"=>"attr=style=height:200px,type=textarea",
);

c()->template_name = basename(__DIR__);


$menu_file[] = string2array("link=home,section=home,label=Home Page");
$menu_file[] = string2array("link=admin/dashboard,label=Dashboard,show=login");
$menu_file[] = string2array("link=price,label=Price List");
$menu_file[] = string2array("link=faq,label=Frequent Ask Question");
$menu_file[] = string2array("link=about,label=About Us");
$menu_file[] = string2array("link=contact,label=Contact Us");
$menu_file[] = string2array("link=login,label=Login,show=logout");
$menu_file[] = string2array("link=login/register,label=Register,show=logout");
$menu_file[] = string2array("link=login/logout,label=Logout,show=login");


