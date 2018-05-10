<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 09-10-17
 * Time: 3:22 PM
 */
$s_ = $this->session;
$d_ = $this->db;

$param1 = isset($param1) ? $param1 : "";
$param2 = isset($param2) ? $param2 : "";
$param3 = isset($param3) ? $param3 : "";

//$system_name = c()->get_setting('system_name');
$system_name = $system_title = c()->get_setting('system_name');
$page_title = isset($page_title) ? $page_title : "";

$theme = get_setting("current_backend_theme");
$theme = empty($theme)?"default":$theme;
$theme_path = "backend/$theme";

include "$theme/index.php";