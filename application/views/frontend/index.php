<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 09-10-17
 * Time: 3:22 PM
 */
$CI =& get_instance();
$s_ = $this->session;
$d_ = $this->db;

$CI->load->library('user_agent');
$is_mobile = this()->agent->is_mobile();

$param1 = isset($param1) ? $param1 : "";
$param2 = isset($param2) ? $param2 : "";
$param3 = isset($param3) ? $param3 : "";



//$system_name = c()->get_setting('system_name');
$system_name = $system_title = c()->get_setting('system_name');
$page_title = isset($page_title) ? $page_title : "Home Page";

$theme = get_setting("current_frontend_theme");
$theme = empty($theme)?"default":$theme;
$theme_path = "frontend/$theme";
c()->template_name = $theme;

if(file_exists( __DIR__."/$theme/index.php"))
	include __DIR__."/$theme/index.php";
else{
	print "<h2>SELECTED THEME ($theme) CAN NOT BE FOUND</h2>";
}