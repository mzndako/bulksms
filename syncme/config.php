<?php
$link = "hillakonnect.com.ng";
if(isset($_GET['host']))
	$link = $_GET['host'];
define("link", "http://$link/syncme/");
define("token", "thiskismsdjkhdlkjhskajlasdhfkjhoijuiopuop32983");
define("folder_name", "syncme");

$include_root_folders = false;
$include_root_files = false;
$include_folders = array("application","assets","api","mobile","uploads/default", 'sync','.htaccess','db_update');
$include_full = array("system");
$exclude_folders = array("application/logs", "application/license.dat2", "application/config/database.php");
$skip_files = array('.DS_Store','.user.ini', 'php.ini','.htaccess', 'pos','log.html');

define("db_name", "quicksms_bizybyte");
define("db_username", "quicksms_bisy");
define("db_password", "KLn1xq-xNTso");
define("allow_delete", true);
define("is_server", false);

define("BASE_URL", dirname(__DIR__)."/");

$name = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:"");

$url = preg_replace('/(https?:\/\/|www.)|(:\d+)/', '', strtolower($name));
if ( strpos($url, '/') !== false ) {
	$ex = explode('/', $url);
	$url = $ex['0'];
}
