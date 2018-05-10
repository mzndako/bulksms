<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: MZ
 * Date: 20/8/2016
 * Time: 8:15 PM
 */
date_default_timezone_set('Africa/Lagos');

$server_array = $_SERVER;

include_once(__DIR__.'/shared/class.lib.php');
include_once(__DIR__.'/app/class.app.php');
$application = new license_application('application/license.dat', false, true, false, true);
$application->set_server_vars($server_array);
$results 	= $application->validate();
$application->make_secure();


switch($results['RESULT'])
{
	case 'OK' :
		break;
	case 'EXPIRED' :
		$x = "<h2>Your licence has expired (".$results['DATE']['HUMAN']['START'] ." - ". $results['DATE']['HUMAN']['END'].")</h2> Please contact your supplier";
		print $x;
		die();
	default :
		print "<h2>Invalid Licence File. Please contact your supplier</h2>";
		die();
		break;
}

function is_server(){
	return defined("IS_SERVER");
}



if ( ! function_exists('get_setting'))
{
	function get_setting($key,$default = "", $owner = null){
		static $settings = null;
		$use_owner = $owner === null?owner:$owner;

		if(!isset($settings[$use_owner][$key])){
			$q = d()->get_where('settings' , array('type'=>$key, 'owner'=> $owner === null?owner:$owner));

			if($q -> num_rows() > 0){
				$settings[$use_owner][$key] = $q -> row() -> description;;
			}else{
				if(empty($default)){
					$default = mydefault()->all_defaults($key, $default);
				}
				return $default;
			}
		}

		return $settings[$use_owner][$key];
	}
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);

	return $length === 0 ||
	(substr($haystack, -$length) === $needle);
}

function get_global_setting($key,$default = ""){
	return get_setting($key,$default);
}

function save_global_setting($key,$value ){
	return save_setting($key,$value);
}

function get_system_setting($key,$default = ""){
	return get_setting($key,$default,0);
}

function save_system_setting($key,$value ){
	return save_setting($key,$value,0);
}



function set_setting($key,$value="", $owner = null){

	return  save_setting($key,$value, $owner);
}


if ( ! function_exists('save_setting'))
{
	function save_setting($key,$value="", $owner = null){

		if(!is_array($key)){
			$key = array($key=>$value);
		}
		$success = 0;
		foreach($key as $k => $v) {
			$q = d()->get_where('settings', array('type' => $k, 'owner'=>$owner === null?owner:$owner));

			if ($q->num_rows() > 0) {
				d()->where("type",$k);
				d()->where("owner",$owner === null?owner:$owner);
				if(d()->update("settings",array("description"=>$v)))
					$success++;
			} else {
				$data['type'] = $k;
				$data['description'] = $v;
				$data['owner'] = $owner === null?owner:$owner;
				if (c()->insert("settings", $data)) {
					$success++;
				}
			}

		}

		if($success == count($key))
			return true;

		if($success == 0)
			return false;

		return $success;
	}
}

function create_token($user_id,$purpose, $len = 70, $expires = 3600, $owner = null){
	$data['owner'] = empty($owner)?owner:$owner;
	$data['user_id'] = $user_id;
	$data['purpose'] = $purpose;
	$data['token'] = random_string("alnum", $len);
	$data['date'] = time();
	$data['expires'] = $data['date'] + $expires;
	d()->insert("token", $data);
	return $data['token'];
}

function string2array($string, $first = ",", $second = "=", $third = "|" ,$count=0){
	//class=summernote,readonly=readonly,attr=mz=ndako,mz,

	$x = explode($first, $string);
	$y = array();
	foreach($x as $a){
		$z = explode($second, $a);
		if(count($z) == 1){
			$y[$count++] = $z[0];
		}else if(count($z) == 2){
			$y[$z[0]] = $z[1];
		}else{
			$k = $z[0];
			unset($z[0]);
			$y[$k] = string2array(implode($second, $z),$third,$second, $first, $count);
		}

	}
	return $y;
}

function string2array2($string, $first = ",", $second = "=", $count=0){
	//class=summernote,readonly=readonly,attr=mz=ndako,mz,
	$x = explode($first, $string);
	$y = array();
	foreach($x as $a){
		$z = explode($second, $a);
		if(count($z) == 1){
			$y[$count++] = $z[0];
		}else if(count($z) == 2){
			$y[$z[0]] = $z[1];
		}else{
			$k = $z[0];
			unset($z[0]);
			$y[$k] = string2array(implode($second, $z),"|",$second, $count);
		}

	}
	return $y;
}

function get_report_setting($filename, $value, $default = ""){
	return get_setting("report_".$filename."_$value", $default);
}

function myAccess($func){
	if(!isset($_SESSION['allaccess'])){
		$_SESSION['allaccess'] = array();
	}
	$array = $_SESSION['allaccess'];
	if(!in_array($func,$array)){
		$array[] = $func;
	}
	$_SESSION['allaccess'] = $array;
	foreach($array as $x){
		print "'$x',";
	}

}

function checkAccess($config=Array()){
//		$this->myAccess($config['function']);
//	return isset($_SESSION['login_type']);
//		return true;


	if(!isset($config['function']))
		$config['function'] = debug_backtrace()[1]['function'];

	if(!isset($config['redirect']))
		$config['redirect'] = true;

	if(!isset($config['refresh']))
		$config['refresh'] = false;

	$access = s()->userdata("access");
	$access = is_array($access)?$access:explode(",",$access);

	$spec_access = s()->userdata("specific_access");
	$spec_access = is_null($spec_access) || $spec_access == ""?Array():(is_array($spec_access)?$spec_access:explode(",",$spec_access));
	if(is_login() && is_administrator()){
		return true;
	}
	if(count($spec_access) > 0 && in_array($config['function'],$spec_access)){
		return true;
	}else if(count($spec_access) == 0 && count($access) > 0 && in_array($config['function'],$access)){
		return true;
	}else{
		if($config['redirect']){
			if(!is_login() && is_ajax())
				die("login");

			if(is_ajax())
				ajaxFormDie("Permission Denied");

			s()->set_flashdata('flash_message' , get_phrase('access_denied_('.$config['function'].')'));
			redirect(url('admin/dashboard'), $config['refresh']?'refresh':'refresh');
		}
	}

	return false;
}

function perform_login($email, $password, $remember_me = false){
	if(empty(trim($email)) || empty(trim($password))){
		return "invalid";
	}

	$credential = array();
	if(c()->is_email($email)){
		$credential['email'] = $email;
	}else{
		$sms = new sms();
		$sms->set_recipient($email);

		if(!empty($sms->get_numbers())){
			d()->where("phone", $sms->get_numbers());
		}else{
			d()->where("username", $email);
		}


	}


	// Checking login credential for teacher
	$query = c()->get_where('users', $credential);
	if ($query->num_rows() > 0) {
		$row = $query->row();
		if(!password_verify($password, $row->password)){
			if(empty($row->last_password) || $row->last_password != previous_password_hash($password))
				return "invalid";
		}

		this()->session->set_userdata('login_user_id', $row->id);
		this()->session->set_userdata('name',  $row->fname." ".$row->surname);
		this()->session->set_userdata('is_admin', $row->is_admin);
		this()->session->set_userdata('login_as', $row->is_admin?"admin":"member");
		if(is_admin()){
			if($row->access == -1){
				this()->session->set_userdata('administrator', 1);
			}

			$access = c()->get_permissions($row->access);
		}else{
			$access = c()->get_permissions(c()->get_setting('member_permission'), false);
		}
		this()->session->set_userdata('access', $access);

		if ($row->disabled != 0){
			this()->session->sess_destroy();
			return $row->disabled_text;
		}

		c()->where("id", $row->id);
		$data['last_login'] = time();
		$data['last_ip'] = this()->input->ip_address();
		$data['last_login2'] = $row->last_login;
		$data['last_ip2'] = $row->last_ip;
		c()->update("users", $data);

		if($remember_me){
			$time = 60 * 60 * 24 * 30 * 6;
		}else{
			$time = 60 * 60;
		}

		this()->session->set_userdata("session_expires_on", $time);
		this()->session->set_userdata("session_last_update", time());

		return 'success';
	}



	return 'invalid';
}

function reload_permission($user_id = null, $owner = null){
	if(!is_login())
		return false;

	$user_id = empty($user_id)?login_id():$user_id;
	$owner = empty($owner)?owner:$owner;

	d()->where("id", $user_id);
	d()->where("owner", $owner);
	$row = d()->get("users")->row();

	if(empty($row)){
		this()->session->sess_destroy();
		return false;
	}

	this()->session->set_userdata('login_user_id', $row->id);
	this()->session->set_userdata('name',  $row->fname." ".$row->surname);
	this()->session->set_userdata('is_admin', $row->is_admin);
	this()->session->set_userdata('login_as', $row->is_admin?"admin":"member");
	if(is_admin()){
		if($row->access == -1){
			this()->session->set_userdata('administrator', 1);
		}

		$access = c()->get_permissions($row->access);
	}else{
		$access = c()->get_permissions(c()->get_setting('member_permission'), false);
	}
	this()->session->set_userdata('access', $access);

	if ($row->disabled != 0){
		this()->session->sess_destroy();
		return $row->disabled_text;
	}
	return true;
}

function previous_password_hash($password){
	return sha1($password);
}

function hAccess($function=null,$denial = ""){
	$config = Array("redirect"=>false);
	$config['denial'] = $denial;

	if(!empty($function))
		$config['function'] = $function;

	return checkAccess($config);
}

function login_user($user_id, $remember_me = true){
	d()->where("id", $user_id);
	$query = d()->get('users');

	if ($query->num_rows() > 0) {
		$row = $query->row();

		this()->session->set_userdata('login_user_id', $row->id);
		this()->session->set_userdata('name',  $row->fname." ".$row->surname);
		this()->session->set_userdata('is_admin', $row->is_admin);
		this()->session->set_userdata('login_as', $row->is_admin?"admin":"member");

		if(is_admin()){
			if($row->access == -1){
				this()->session->set_userdata('administrator', 1);
			}

			$access = c()->get_permissions($row->access);
		}else{
			$access = c()->get_permissions(c()->get_setting('member_permission'), false);
		}
		this()->session->set_userdata('access', $access);

		if ($row->disabled != 0){
			this()->session->sess_destroy();
			return $row->disabled_text;
		}

		c()->where("id", $row->id);
		$data['last_login'] = time();
		$data['last_ip'] = this()->input->ip_address();
		$data['last_login2'] = $row->last_login;
		$data['last_ip2'] = $row->last_ip;
		c()->update("users", $data);

		if($remember_me){
			$time = 60 * 60 * 24 * 30 * 6;
		}else{
			$time = 60 * 60 * 2;
		}

		this()->session->set_userdata("session_expires_on", $time);
		this()->session->set_userdata("session_last_update", time());

		return true;
	}

	return "Invalid";
}

function default_login_column($col = null, $implode = "", $owner = null){
    $owner = empty($owner)?owner:$owner;
	$u = get_setting("login_using_username", null, $owner);
	$e = get_setting("login_using_email", null, $owner);
	$n = get_setting("login_using_phone", null, $owner);

	$p = array();
	if($u === null || $u == "1"){
		$p[] = "username";
	}
	if($n === null || $n == "1"){
		$p[] = "phone";
	}
	if($e === null || $e == "1"){
		$p[] = "email";
	}


	$array = $p;

	if($col !== null)
		return in_array($col, $array);
	return empty($implode)?$array:implode($implode, $array);
}

function default_register_column($col = null){
	$u = get_setting("register_using_username", null);
	$e = get_setting("register_using_email", null);
	$n = get_setting("register_using_phone", null);

	$p = array();
	if($u === null || $u == "1"){
		$p[] = "username";
	}
	if($e === null || $e == "1"){
		$p[] = "email";
	}
	if($n === null || $n == "1"){
		$p[] = "phone";
	}

	$array = $p;

	if($col !== null)
		return in_array($col, $array);
	return $array;
}

function default_display_column(){
	$array = array("username", "phone", "email");
	foreach($array as $k){
		if(default_login_column($k))
			return $k;
	}
	return "";
}

function filter_numbers($numbers = "", $only_nigeria = true, $format = "international"){
	$numbers = preg_replace("/[^\d]/",",",$numbers);
	$text = "";
	$array = explode(",", $numbers);
	foreach ($array as $key => $value) {
		$value = trim($value);
		$len = strlen($value);

		if(empty($value) || $len < 5 || $len > 20)
			continue;

		$first = $value[0];
		$second = $value[1];

		$pos = strpos($value, "0");
		$pos1 = strpos($value, "234");

		if($pos===0 && $len == 11){
			$value = "234".substr($value, 1);
		}else if($pos1===0 && $len == 13){
//					$value = $value;
		}else if($len == 10 && $first > 6 && $second < 3){
			$value = "234$value";
		}else{
			if($only_nigeria)
				continue;
		}

		if(countryExit($value)) {
			if($only_nigeria){
				if(strlen($value) == 13 && $format == "national")
					$text .= ",0".substr($value, 3);
				else
					$text .= ",".$value;
			}else
				$text .= ",$value";
		}
	}

	return substr($text, 1);
}

function count_numbers($numbers){
	if(empty($numbers))
		return 0;
	return count(explode(",",$numbers));
}


function dAccess($function=null,$denial = ""){
	if(!hAccess($function, $denial))
		die("Access Denial");
}

function rAccess($function=null,$denial = "",$refresh = false){

	$config = Array("redirect"=>true);
	$config['denial'] = $denial;

	if(!empty($function)) {
		$config['function'] = $function;
	}
	$config['refresh'] = $refresh;
	return checkAccess($config);
}

function is_admin($user_id = null){
	if(!empty($user_id)){
		return empty(user_data("is_admin",$user_id))?false:true;
	}
	return empty(s()->userdata("is_admin"))?false:true;
}

function show_help(){
	return true;
}

function is_administrator(){
	return empty(s()->userdata("administrator"))?false:true;
}

function is_login(){
	return empty(s()->userdata("login_user_id"))?false:true;
}

function is($login_as,$exact = false){
//	return true;
	return c()->is($login_as,$exact);
}

function s(){
	$CI =& get_instance();
	return empty($CI->session)?null:$CI->session;
}

function setting(){
	$CI =& get_instance();
	return $CI->setting_model;
}

function mydefault(){
	$CI =& get_instance();
	return $CI->mydefault_model;
}

function c(){
	$CI =& get_instance();

	return $CI->crud_model;
}

if(!function_exists('d')) {
	function d()
	{
		$CI =& get_instance();
		return $CI->db;
	}
}

if(!function_exists('sync')) {
	function sync()
	{
		$CI =& get_instance();
		return $CI->sync_client_model;
	}
}

if(!function_exists('e')) {
	function e()
	{
		$CI =& get_instance();
		return $CI->email_model;
	}
}

if(!function_exists('pay')) {
	function pay()
	{
		$CI =& get_instance();
		return $CI->payment_model;
	}
}

if(!function_exists('bill')) {
	function bill()
	{
		$CI =& get_instance();
		return $CI->billpayment_model;
	}
}

if(!function_exists('sms')) {
	function sms()
	{
		$CI =& get_instance();
		return $CI->sms_model;
	}
}


function &this(){
	$CI =& get_instance();
	return $CI;
}

function user_id(){
	return this()->session->userdata('login_user_id');
}



function in_arrayi($needle, $haystack) {
	return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

function indexOf($search,$array){
	$search = strtolower($search);
	foreach($array as $k => $v){
		if(strtolower($v) == $search)
			return $k;
	}
	return -1;
}

function get_max_index($assoc_array){
	$max = 0;
	$maxkey = 0;
	foreach($assoc_array as $key=>$value){
		if($value > $max){
			$max = $value;
			$maxkey = $key;
		}
	}
	return $maxkey;
}

function database_date($date,$addition = 0, $substration = 0){
	$x = (@strtotime($date) + $addition) - $substration;
	return date("Y/m/d",$x);
}

function get_status($status){
	if ($status == 1)
		return '<span class="badge badge-success">'. get_phrase('present').'</span>';
	return '<span class="badge badge-danger">'. get_phrase('absent').'</span>';
}

function getIndex($array,$str_index,$default = ""){

	if(is_object($array))
		$array = (Array) $array;

	$ex = explode(",",$str_index);

	if(count($ex) > 0){
		if(count($ex) == 1){
			return isset($array[$ex[0]])?$array[$ex[0]]:$default;
		}else{
			if(isset($array[$ex[0]])){
				$array2 = $array[$ex[0]];
				array_shift($ex);
				return getIndex($array2,implode(",",$ex),$default);
			}else
				return $default;
		}
	}
	return $default;
}

function getIndexOf($array, $args){
	$x = func_get_args();
	$m_array = null;
	$m_args = array();
	foreach($x as $k => $v){
		if($m_array == null){
			$m_array = $v;
			continue;
		}
		$m_args[] = $v;
	}
	return getIndex($m_array, implode(",",$m_args));
}

function database_datetime($date,$addition = 0, $substration = 0, $format = "Y/m/d H:i:s"){
	$x = (strtotime($date) + $addition) - $substration;
	return date($format,$x);
}

function gdate($minute=0,$hour=0) {
	date_default_timezone_set('Africa/Lagos');
	$dt = Date("d-m-Y H:i:s");
	$datetime1 = new DateTime($dt);
	$datetime1 -> add(date_interval_create_from_date_string("$hour hours"));
	$datetime1 -> add(date_interval_create_from_date_string("$minute minutes"));
	return date_format($datetime1, "Y-m-d H:i:s");
}
function flash_redirect($link,$flash){
	s()->set_flashdata('flash_message', $flash);
	redirect($link, 'auto');
}

function set_flash_message($flash){
	s()->set_flashdata('flash_message', $flash);
}

function convert_to_date($time,$format = "j F, Y")
{
	if(empty($time)){
		return "";
	}
	if(!is_numeric($time))
		$time = strtotime($time);
	return date($format, $time);
}

function convert_to_datetime($time,$format = "g:i a - j F, Y")
{
	if(!is_numeric($time))
		$time = strtotime($time);
	return date($format, $time);
}


function convert2number($number){
	return str_replace(array("N"," ",","),"",$number);
}

function get_seconds($min = 0, $hrs = 0, $days = 0){
	return ($min * 60) + ($hrs * 60 * 60) + ($days * 24 * 60 * 60);
}

function user_balance($user_id = null, $source = "balance"){
	$user_id = empty($user_id)?login_id():$user_id;
	return (Float) user_data($source, $user_id, 0, true, false);
}

function update_user_balance($amount, $add_credit = true , $update_total = false, $user_id = null, $owner = null){
	$amount = parse_amount($amount);
	if($add_credit) {
		d()->set("balance", "balance + $amount", false);
		if($update_total)
			d()->set("total_units", "total_units + $amount", false);
	}else {
		d()->set("balance", "balance - $amount", false);
		d()->set("total_units", "total_units - $amount", false);
	}

	if($owner !== false){
        d()->where("owner", empty($owner)?owner:$owner);
    }

	d()->where("id", empty($user_id)?login_id():$user_id);
	d()->limit(1);
	d()->update("users");
	return true;
}


function history_link(){
	return empty(this()->input->post("current_url"))?url(uri_string()):this()->input->post("current_url");
}

function insert_history($data_=array()){

	$tran_id = generate_transaction_id();

	$data['owner'] = owner;
	$data['date'] = time();
	$data['user_id'] = login_id();
	$data['updated_user_id'] = login_id();
	$data['bill_type'] = "fund_wallet";
	$data['transaction_id'] = $tran_id;
	$data['status'] = "Completed";
	$data['type'] = "Fund Wallet";
	$data['amount'] = 0;
	$data['payment_method'] = "wallet";
	$data['status'] = "Completed";
	$data['is_success'] = 1;
	$data['remark'] = "Successful";
	$data['updated_time'] = $data['date'];
	$data['updated_user_id'] = login_id();
	$data['updated_time'] = time();

	$data = array_merge($data, $data_);

	d()->insert("bill_history", $data);
	return $tran_id;
}

function user_data($field=null,$member = null, $default = "",$refresh = false, $owner = null){

	if(empty($member)) $member = login_id();

	if(empty($member))
		return $default;

	static $users = array();

	if(empty($users[$member]) || $refresh){
		c()->where("id", $member);

		if($owner !== false) {
            d()->where("owner", $owner === null ? owner : $owner);
        }

		$x = d()->get("users")->result_array();
		foreach($x as $row){
			$users[$member] = $row;
		}
	}

	if($field === null){
		return getIndex($users, $member, $default);
	}

	return getIndex($users, $member.",".$field, $default);
}

function replaceV($text,$member,$addition=array()){
	return c()->replace_values($text,$member,$addition);
}

function login_id(){
	if(empty(s()))
		return "";

	return s()->userdata("login_user_id");
}

function login_as(){
	return s()->userdata("login_as");
}

function split_login($login_id){
	$x = explode("-",$login_id);
	if(count($x) == 2){
		$y = Array("id"=>$x[1],"as"=>$x[0]);
		return (Object) $y;
	}
	return (Object) Array("id"=>"0","as"=>'student');
}

function login_as_id($login_id = "", $login_as = ""){
	$id = $login_id == ""?login_id():$login_id;
	$as = $login_as == ""?login_as():$login_as;
	return $as."-$id";
}

function login_id_type($type = ""){
	return $type == ""?s()->userdata("login_as")."_id":$type."_id";
}

function division_id(){
	return s()->userdata('division_id');;
}

function default_password($who = "student"){
	return get_setting("default_".$who."_password","123456");
}

function send_mail($message,$subject,$to,$from = null){
	$config = array();
	$config['useragent']	= "CodeIgniter";
	$config['mailpath']		= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	$config['protocol']		= "smtp";
	$config['smtp_host']	= "localhost";
	$config['smtp_port']	= "25";
	$config['mailtype']		= 'html';
	$config['charset']		= 'utf-8';
	$config['newline']		= "\r\n";
	$config['wordwrap']		= TRUE;

	this()->load->library('email');

	this()->email->initialize($config);

	$system_name	=	get_setting('cname');
	if($from == NULL)
		$from		=	get_setting('cemail');

	this()->email->from($from, $system_name);
	this()->email->to($to);
	this()->email->subject($subject);

	$msg	=	$message."".get_setting("email_footer");
	this()->email->message($msg);
	$x = false;
	try{
		ob_start();
		$x =	this()->email->send();
		$y = ob_get_clean();

	}catch(Exception $e){
//		echo $this->email->print_debugger();

	}

	return $x;
}

function send_sms($message, $sender_id,$to, $route = 0, $user_id = "", $owner = "", $charge=true){

	$owner = !empty($owner) ? $owner : owner;
	$user_id = !empty($user_id) ? $user_id : login_id();

	$sms = new sms($owner);
	$sms->set_user($user_id);
	$sms->set_sender($sender_id);
	$sms->set_message($message);
	$sms->set_route($route);
	$sms->set_recipient($to);
	$sms->set_user($user_id);
	$sms->charge = $charge;

	$sent = $sms->send_sms();
	return $sent['sent'];
}

function is_strip_empty($value){
	return empty(strip_tags($value));
}

function format_phone($phone){
	$ex = explode(",",$phone);
	$mz = array();

	foreach($ex as $x){
		$x = trim(str_replace(array(" ","+"),"",$x));
		if(strlen($x) == 11){
			$mz[] = "234".substr($x,1);
		}else if(strlen(trim($x)) == 10){
			$mz[] = "234".$x;
		}elseif(strlen($x) > 5 || strlen($x) < 15){
			$mz[] = $x;
		}
	}

	return implode(",",$mz);

}

function safer_include($file){
	if(file_exists($file))
	return include $file;

	return false;
}

function safer_include_once($file){
	if(file_exists($file))
	return include_once $file;

	return false;
}

function url($link=""){
	if(preg_match("/https?:\/\//", $link)){
		return $link;
	}
	if(strpos($link, "#") === 0)
		return $link;

	return base_url().$link;
}

function assets_url($link){
	return url("assets/$link");
}

function my_uri($data = "",$prefix = ""){
	return $data == ""?uri_encode(empty($_POST['current_uri'])?uri_string():$_POST['current_uri']):$prefix.uri_decode($data);
}

function uri_encode($value){
	return base64_encode($value);
}

function uri_decode($value){
	$result = base64_decode($value);
	return $result===false?"":$result;
}

function p_selected($needle, $haystack = null){
	if($haystack == null)
		return $needle?"selected":"";
	return compareString($needle, $haystack)?"selected":"";
}

function p_checked($needle, $haystack = null){
	if($haystack === null)
		return $needle?"checked":"";
	return compareString($needle, $haystack)?"checked":"";
}

function create_password_input($name = "password",$value = "",$additional = "class='form-control autocomplete-off' required"){
	$width = 70;
	$type = "password";
	$v = "**********";
	if(empty($value)){
		$width = 100;
		$v = "";
	}
	return "<input style='width: $width%; display: inline-block' ".(empty($value)?"":"disabled='disabled'")." type='$type'
 value='$v'
name='$name'
id='$name' $additional >".(empty($value)?"":"<input style='width: 29%; margin-left: 1%; display: inline-block; '
type='button'
class='btn btn-success' onclick=\"$('#$name').removeAttr('disabled').val('').attr('required','required');\"
value='change'>");

}

function format_amount($number, $decimal = 2, $prefix = null, $suffix = ""){
	$prefix = $prefix === null?get_setting("currency"):"";
	$number = preg_replace("/[^\d.-]/","", $number);
	if($decimal == -1){
		$pos = strpos($number, ".");
		if($pos !== false){
			$sub = substr($number, $pos + 1);
			if(empty($sub) || ((int) $sub) == 0){
				$decimal = 0;
			}else
				$decimal = strlen($sub);

		}
	}
	return $prefix.format_number($number, $decimal).(empty($suffix)?"":" $suffix");
}

function format_wallet($number, $decimal = 2){
	return format_amount($number, $decimal, null, get_setting("currency_suffix"));
}

function parse_amount($number){
		$number = preg_replace("/[^\d.-]/","", $number);
	return (Float) $number;
}

function format_number($number, $decimal = 2){
	return number_format(empty($number)?0:$number, $decimal);
}

function get_rows_by_id($table,$col_name){
	$array = c()->get($table)->result_array();
	$ids = array();
	foreach($array as $row){
		$ids[$row[$col_name]] = $row;
	}

	return $ids;
}

function get_ids($table,$field='',$where_in="",$where=array()){
	if(is_array($table)){
		$students = $table;
	}else
		$students = c()->get_where($table,$where)->result_array();

	$ids = array();
	foreach($students as $row){
		if(empty($field))
			$ids[] = $row;
		else
			$ids[] = $row[$field];
	}

	if(!empty($where_in)){
		if(count($ids) > 0)
			d()->where_in($where_in,$ids);
		else
			d()->where($where_in,null);
	}

	return $ids;
}

function get_staffs($id = "0", $type = 'list')
{
	hAccess("login") or die("Please login first");

	if($id == "")
		exit;

	$data = array();
	if($id != 0){
		$data['tc'] = $id;
	}

	$cat = c()->get("teacher_categories")->result_array();
	$categories = array();
	foreach($cat as $row){
		$categories[$row['category_id']] = $row['name'];
	}

	d()->order_by("tc","ASC");
	$students = c()->get_where('teacher',$data)->result_array();
	$ptc = 0;
	$count = 0;

	if($type != 'list') {
		foreach ($students as $row) {
			if($ptc != $row['tc'] && $id == 0){
				if($count > 0){
					echo '</optgroup>';
				}
				echo "<optgroup label='".getIndex($categories,$row['tc'],'Staffs')."'>";
				$count++;
				$ptc = $row['tc'];
			}
			echo '<option value="' . $row['teacher_id'] . '">ID ' .$row['teacher_id'].": ". c()->get_full_name($row) . '</option>';

		}
		if($count> 0){
			echo "</optgroup>";
		}
	}else {
		echo '<div class="form-group">
                <label class="col-sm-3 control-label">' . get_phrase('staffs') . '</label>
                <div class="col-sm-9">';

		foreach ($students as $row) {
			if ($ptc != $row['tc']) {
				echo '<div class="checkbox">
                    <label class="label label-info">' . getIndex($categories, $row['tc'], 'Staffs') . '</label>
                </div>';
				$ptc = $row['tc'];
			}

			echo '<div class="checkbox">
                    <label><input type="checkbox" class="check" name="teacher_id[]" value="' . $row['teacher_id'] . '">
                    ' . c()->get_full_name($row) . '</label>
                </div>';

		}
		echo '<br><button type="button" class="btn btn-default" onClick="select()">' . get_phrase('select_all') . '</button>';
		echo '<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()"> ' . get_phrase('select_none') . ' </button>';
		echo '</div></div>';
	}
}

function user_access($user){
	$x = implode(",",all_access());
	$except = "";
	if($user == "student" || $user == "parent") {
		$x = "login,view_students,view_teachers,view_exams,view_grades,view_marks,view_attendance,view_invoices,view_result,view_books,view_transports,view_board,view_messages,view_subjects,view_routines,access_cbt,practice_test";
	}else if($user == 'teacher'){
		$except = "manage_permissions,view_permissions,view_division,manage_division";
	}
	$x = explode(",",$x);
	return $x;
}

function all_access($id = null){
	$array = array('login','admit_student','view_students','update_student','delete_student','create_teacher','update_teacher','delete_teacher','view_teachers','manage_staff_categories','view_parents','manage_parents','view_classes','view_subjects','manage_subject','view_routines','manage_routine','view_exams','view_grades','manage_grade','manage_marks','send_marks','view_marks','view_results','practice_test','create_cbt','access_cbt','manage_questions','manage_all_cbt','view_sections','view_attendance','manage_attendance','view_staff_attendance','manage_staff_attendance','manage_exam','view_result','accept_payment','create_invoice','update_invoice','delete_invoice','view_invoices','view_expenses','manage_expenses','view_books','manage_book','view_transports','view_board','manage_board','view_messages','view_sent_messages','send_message','view_lesson','manage_lesson','manage_settings','manage_sms','manage_languages','view_divisions','manage_division','manage_class','view_terms','manage_session','manage_segment','manage_terms','view_permissions','manage_permissions','change_user_password' );
	if($id != null){
		return isset($array[$id])?$array[$id]:"";
	}
	return $array;
}

function get_arrange_id($table,$column_name){
	if(is_array($table)){
		$x = $table;
	}else
		$x = c()->get($table)->result_array();
	$y = array();
	foreach($x as $row)
		$y[$row[$column_name]] = $row;
	return $y;
}

function is_commission_system(){
	return is_hillary();
}

function convert_date($date, $newformat = ''){
	if(empty($newformat))
		$newformat = dateFormat();


	$x = strtotime($date);
	return date($newformat, $x);
}

function dateFormat(){
	return "d/m/Y";
}

function get_arrange_id_name($table,$id_name, $name_column="name"){
	if(is_array($table)){
		$x = $table;
	}else
		$x = c()->get($table)->result_array();

	$y = array();
	foreach($x as $row)
		$y[$row[$id_name]] = $row[$name_column];
	return $y;
}

function explode_array_key($string){
	$x = explode(",", $string);
	$y = array();
	foreach($x as $v){
		$y[$v] = "";
	}
	return $y;
}

function convert_to_time($seconds,$show_seconds = false){
	if($seconds < 0)
		return "0 sec";
	$h = floor($seconds/3600);
	$hrs = $h < 2?$h." hr":$h." hrs";

	$m = floor(($seconds - ($h * 3600))/60);
	$min = $m < 2?$m." min":$m." mins";

	$s = $seconds - (($m * 60) + ($h * 3600));

	$s_ = $show_seconds?" ".$s." sec":"";
	return $h == 0?$min.$s_:"$hrs $min$s_";

}

function nc($time,$length = 2){
	$y = strlen($time);

	for($x = $y; $x < $length; $x++){
		$time = "0".$time;
	}
	return strlen($time) == 1?"0$time":$time;
}

function mark_test($id = "", $mark_now = false){
	d()->where("score",-1);
	d()->where("started_time !=", 0);
	if(!empty($id)){
		d()->where("id", $id);
	}
	$rows = c()->get("test")->result_array();

	foreach($rows as $row){
		$data = array();


		if($row['completed_time'] == 0){
			if(time() + 5 < $row['started_time'] + $row['totaltime'] && !$mark_now){
				continue;
			}
			$data['completed_time'] = $row['started_time'] + $row['totaltime'];
		}

		$score = calculate_score(json_decode($row['questions'], true));
		$data['score'] = $score;

		if($row['exam_id'] != 0){
			d()->where("student_id", $row['user']);
			d()->where("subject_id",$row['subject_id']);
			d()->where("exam_id", $row['exam_id']);
			$x = c()->get("mark")->row_array();

			if(empty($x)){
				$m['student_id'] = $row['user'];
				$m["subject_id"] = $row['subject_id'];
				$m['exam_id'] = $row['exam_id'];
				$m['mark_obtained'] = get_mark($score, $row['totalquestions'],$row['mark']);
				c()->insert("mark",$m);
			}else{
				$m['mark_obtained'] = get_mark($score, $row['totalquestions'],$row['mark']);
				d()->where("mark_id",$x['mark_id']);
				c()->update("mark",$m);
			}
		}

		d()->where("id",$row['id']);
		c()->update("test",$data);

	}

}

function get_mark($score, $total_question, $mark){
	if(empty($score) || empty($total_question))
		return 0;
	return floor(($score/$total_question) * $mark);
}

function calculate_score($questions){
	$questions_ids = array();
	if(empty($questions))
		return 0;

	foreach($questions as $id => $v)
		$questions_ids[] = $id;

	c()->safer_where_in("id", $questions_ids);
	$array = c()->get("questions")->result_array();

	$x = Array("a","b","c","d","e");
	$correct = 0;
	foreach ($array as $row1) {
		$row1['user_answer'] = getIndex($questions,$row1['id']);
		$ans = strtolower(trim($row1['answer']));
		$sresult = strtolower(trim($row1['user_answer']));
		if(trim($sresult) == "")
			continue;

		if($ans == ""){
			foreach($x as $y){
				$v = trim(strtolower($row1[$y]));
				if($v == "")
					continue;
				if($sresult == $v){
					$correct++;
					continue;
				}
			}
		}else{
			if($sresult == $ans)
				$correct++;
		}
	}
	return $correct;
}

function is_correct($row){
	$row = new process_array($row);
	$x = Array("a","b","c","d","e");
	$ans = strtolower(trim($row->get('answer')));
	$user_answer = $row->get('user_answer');
	$sresult = strtolower(trim($user_answer==""?$row->get("canswer"):$user_answer));
	if(trim($sresult) == "")
		return false;

	if($ans == ""){
		foreach($x as $y){
			$v = trim(strtolower($row->get($y)));
			if($v == "")
				continue;
			if($sresult == $v){
				return true;
			}
		}
	}else{
		if($sresult == $ans)
			return true;
	}
	return false;
}

function empty_0($value){
	if(trim($value) == "0")
		return false;
	return empty($value);
}

function is_empty($value){
	return empty(trim($value));
}

function guid()
{
	if (function_exists('com_create_guid') === true)
	{
		return trim(com_create_guid(), '{}');
	}

	return sprintf('%d-%04X%04X-%04X-%04X-%04X-%04X%04X%04X', rand(0,9),mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function getGUID($prefix = "X"){

	if (false && function_exists('com_create_guid') ){
		$x = com_create_guid();
		return "$x";
	}else{
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$hyphen = "";// "-"
		$uuid = // "{"
			strtoupper(substr($prefix, 0, 1)).
			substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12).time()
		;// "}"
		return $uuid;
	}
}

function generate_transaction_id($len = 10, $owner = null){
	$rem = $len - 2;
	do {
		$id = strtoupper(random_string("alpha", 2)) . random_string("numeric", $rem);

		d()->where("owner", empty($owner)?owner:$owner);
		d()->where("transaction_id", $id);
		$array = d()->get("bill_history")->row_array();
		if(empty($array))
			return $id;
	}while(true);
}

function getTempDir(){
	return "uploads/temp";
}

function lockMe($uniqueid=null,$wait=false,$retry = 30){
	$uniqueid = $uniqueid==null?  basename(__FILE__):$uniqueid;
	$name = getTempDir()."/$uniqueid.lock";

	if(!file_exists(getTempDir())){
		mkdir(getTempDir());
	}

	$lockme = fopen($name,"w+");


	if($lockme){
		for($i = 1; $i< $retry; $i++){
			if(flock($lockme, LOCK_EX | LOCK_NB)){
				lockExists($uniqueid, true);
				return $lockme;
			}
			if(!$wait)
				return false;
			usleep(1000);
		}
	}
	return false;
}

function releaseLockMe($lockme_=null){
	global $lockme;
	$f = $lockme_ == null?$lockme:$lockme_;
	flock($f,LOCK_UN);
	fclose($f);
}

function lockExists($uniqueid=null, $create=false){
	$uniqueid = $uniqueid==null?  basename(__FILE__):$uniqueid;
	$name = getTempDir()."/$uniqueid.delete_to_stop";

	if(!file_exists(getTempDir())){
		mkdir(getTempDir());
	}

	if($create){
		$lockme = fopen($name,"w+");
		fclose($lockme);
	}

	return file_exists($name);
}

function destroyLockExits($uniqueid){
	$uniqueid = $uniqueid==null?  basename(__FILE__):$uniqueid;
	$name = getTempDir()."/$uniqueid.delete_to_stop";
	unlink($name);
	return true;
}

function datatable($x="",$hide='',$table='my_table_export'){
	$y = explode(",",$hide);
	$z = "";
	foreach($y as $r){
		$z .= "datatable.fnSetColumnVis($r, false); ";
	}
	echo '
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
	var datatable = $(".'.$table.'").dataTable({
			"iDisplayLength": 100,
			"sPaginationType": "bootstrap",
			"sDom": "'."<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>".'",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls",
						"mColumns": ['.$x.']
					},
					{
						"sExtends": "pdf",
						"mColumns": ['.$x.']
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press \'esc\' to return",
						"fnClick": function (nButton, oConfig) {
							$z;
							//datatable.fnSetColumnVis(3, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								if (e.which == 27) {
									datatable.fnSetColumnVis(0, true);
									datatable.fnSetColumnVis(3, true);
								}
							});
						},

					},
				]
			}
		});
		});
		</script>
	';
}

function system_id()
{
	$string = __DIR__.php_uname();
	$x = strlen($string)/5;
	$y = array(0=>0, 1=>0, 2=>0, 3=>3, 4=>4);
	for ($i = 0; $i < strlen($string); $i++) {
		$a = (int) ord($string[$i]);
		$y[$i%5] += $a;

	}
	return implode("-",$y);
}

function is_ajax() {
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") {
		return true;
	}
	return false;
}

function post_set($key){
	return isset($_POST[$key]);
}

function post_unset($key){
	unset($_POST[$key]);
	return true;
}

//POST
function p($key){
	return this()->input->post($key);
}

function g($key){
	return this()->input->get($key);
}

function datatable_limit(){
	return 25;
}


function datatable_limit_set($limit = ""){
	d()->limit(empty(g("length")) ? (empty($limit)?datatable_limit():$limit) : g("length"));
}

function datatable_offset_set(){
	d()->offset(empty(g("start")) ? 0 : g("start"));
}

function datatable_order($orders, $initial_order="", $skip = ""){
	$columns = g("columns");
	$torders = getIndex(g("order"), 0);
	if(empty($torders)){
		if(!empty($initial_order)){
			$x = explode(":", $initial_order);
			if(count($x) == 2){
				d()->order_by($x[0], $x[1] == "asc"?"ASC":"DESC");
			}else{
				d()->order_by($initial_order, "ASC");
			}
		}
		return;
	}

	$order_column_index = getIndex($torders, "column");
	$order_column_dir = getIndex($torders, "dir") == "asc"?"ASC":"DESC";

	$hname = strtolower(getIndex($columns, $order_column_index .",name"));
	$ordername = $hname;

	$x = explode(",", $orders);
	foreach($x as $order){
		$y = explode("=", $order);
		if(count($y) == 2){
			if($hname == $y[0]){
				$ordername = $y[1];
			}
		}
	}

	$s = explode(",", $skip);

	foreach($s as $skp){
		if($skp == $hname)
			return;
	}

	d()->order_by(str_replace(" ", "_",$ordername), $order_column_dir);
}

function DOMinnerHTML(DOMNode $element)
{
	$innerHTML = "";
	$children  = $element->childNodes;

	foreach ($children as $child)
	{
		$innerHTML .= $element->ownerDocument->saveHTML($child);
	}

	return $innerHTML;
}

function default_value($value, $default){
	return empty($value)?$default:$value;
}

function or_apply_search($col, $search){
	return apply_search($col,$search,"or");
}

function and_apply_search($col, $search){
	return apply_search($col,$search,"and");
}

function apply_search($col,$search, $join=""){
	$array = explode(" ", $search);
	if(empty($join)){
		d()->group_start();
	}elseif($join == 'and'){
		d()->and_group_start();
	}else{
		d()->or_group_start();
	}
	$start = true;
	foreach($array as $value){
		if(trim($value) == "")
			continue;
		if($start){
			d()->like($col, $value);
		}else
			d()->or_like($col, $value);
		$start = false;
	}

	d()->group_end();
}

function updated_current_url($add=""){
	return url(uri_string().$add);
}

function construct_url($args){
	$x = "";
	if(!is_array($args)){
		$args = func_get_args();
	}
	foreach ($args as $arg) {
		if(empty($arg))
			$arg = '0';
		$x .= "/$arg";
	}
	return $x;
}

function extract_attr($attr_){
	$attr = "";
	foreach($attr_ as $key => $value){
		$attr .= " $key=\"".pv($value)."\" ";
	}

	return $attr;

}

function get_parameters($functions_args){
	$array = array("param1"=>"","param2"=>"","param3"=>"", "param4"=>"");
	foreach($functions_args as $key => $value){
		$array['param'.($key+1)] = $value;
	}
	return $array;
}

function my_plural($words, $count,$showcount = true, $capitalized = false){
	if(is_array($count)){
		$count = count($count);
	}

	$x = $count < 2?$words:plural($words);
	$y = $capitalized?strtoupper($x):$x;
	return $showcount?"$count $y":$y;
}

function per_sms(){
	$sms = new sms();
	$rate = $sms->get_display_rate();
	$per_sms = -1;
	foreach($rate['national'] as $network => $price) {
		if($network == 'all'){
			$network = (count($rate['national'])==1?"All":"Other"). " Network";
			$myrate = format_wallet($price);
			$per_sms = count($rate['national'])==1 && $per_sms == -1?parse_amount($myrate):$per_sms;
		}else{
			$network = strtoupper($network);
		}
		$per_sms = $per_sms == -1?parse_amount($price):$per_sms;

	}
	return $per_sms;
}

function balance_in_units($user_id = null){
	$per = per_sms();
	if(empty($per))
		return 0;
	$x = @floor(@(user_balance($user_id)/$per));
	return empty($x)?0:$x;
}

function amount_in_units($amount){
	$per = per_sms();
	if(empty($per))
		return 0;
	$x = @floor(@($amount/$per));
	return empty($x)?0:$x;
}

function ajaxFormDie($error = "", $errorType='error', $options = array()){
	$x = ob_get_clean();
	$b = format_amount(!empty(login_id())?user_balance():0, -1);

	$bal = $b. " <span style='font-size: 12px;'>(est: ".@number_format(@floor(parse_amount($b)/per_sms()))." units)</span>";
	$array = array("showOnlyError"=>true, "notification"=>array("errorType"=>$errorType, "error"=>empty($error)?s()->flashdata("flash_message"):$error), "balance"=>$bal);

	if(is_ajax())
	print json_encode(array_merge($array, $options));
	else {
		print empty($error) ? s()->flashdata("flash_message") : $error;
		print "<br><a href='#' onclick='history.back()'>Back</a>";
	}

	s()->set_flashdata('flash_message',"");
	die();
}

function pv($value){
	return html_escape($value);
}

function include_file($file,$param1="",$param2="",$param3=""){
	include $file;
}


function parse_date($date){
	return str_replace("/","-",$date);

}

function date2strtotime($date){
	return strtotime(parse_date($date));
}

function parse_number($int){
	try {
		return intval($int);
	}catch(Exception $e){
		return 0;
	}
}

function parse_string($string){
	return empty($string)?"":$string;
}

function return_function($link, $flash='', $class = null){
	if(!empty($flash))
		s()->set_flashdata('flash_message', $flash);

	do {
		$x = explode("/", $link);
		$function = $x[0];
		unset($x[0]);

		$y = explode("/", uri_string());
		$class = $y[0];
		$_POST['current_url'] = url($class . "/" . $link);
		$_POST['current_uri'] = $class . "/" . $link;
		if(is_callable(array(debug_backtrace()[1]['object'], $function))) {
			return call_user_func_array(array(debug_backtrace()[1]['object'], $function), $x);
		}
		$link = implode("/",$x);
	}while(!empty($x));
}

function remove_base_url($url){
	$x = url("");
	return str_replace($x, "", $url);
}


function getFileListOld($path) {
	$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path,
		\FilesystemIterator::CURRENT_AS_FILEINFO |
		\FilesystemIterator::SKIP_DOTS
	));
	$skip = array("license.dat", "application/config/database.php", "application/logs/");
	$skip2 = "application/logs/";
	$skip3 = ".DS_Store";
	$pathPrefixLength = strlen($path);
	$files = array();
	foreach ($iterator as $fileInfo) {
		$fullPath = str_replace(DIRECTORY_SEPARATOR, '/', $fileInfo->getPathName());
		$filePermission = substr(sprintf('%o', fileperms( $fileInfo->getRealPath() )), -4);
		if($path == '.')
			$fullPath = substr($fullPath, 2);
		if(indexOf($fullPath, $skip) > -1 || strpos($fullPath, $skip2) !== false || strpos($fullPath, $skip3) !== false){
			continue;
		}
		$files[$fullPath] = array('size' => $fileInfo->getSize(), 'timestamp' => $fileInfo->getMTime());
//		$files[$fullPath] = array('size' => $fileInfo->getSize(), 'timestamp' => $fileInfo->getMTime(), 'fileperm' => $filePermission);
	}

	return $files;
}

function getFileList($full_update = false) {

	$include_folders = array("application","assets","uploads/default");
	if($full_update){
		$include_folders[] = "system";
	}

	$exclude_folders = array("application/logs","application/license.dat", "application/config/database.php");

	$skip_files = array('.DS_Store');

	foreach($include_folders as $x=>$y){
		$include_folders[$x] = str_replace('/', DIRECTORY_SEPARATOR,  BASE_URL."/$y");
	}
	foreach($exclude_folders as $x=>$y){
		$exclude_folders[$x] = str_replace('/', DIRECTORY_SEPARATOR, BASE_URL."/$y");
	}

	$filter = $filter = function ($file, $key, $iterator) use ($include_folders, $exclude_folders, $skip_files) {

		if(strpos_arr($key, $exclude_folders) !== false){
			return false;
		}

		if(in_array($file->getFileName(), $skip_files)){
			return false;
		}

		if(strpos_arr($key, $include_folders) !== false){
			return true;
		}

		if(dirname($key) == BASE_URL)
			return true;
		return false;

	};
	$iterator = new \RecursiveIteratorIterator(new \RecursiveCallbackFilterIterator(new \RecursiveDirectoryIterator(BASE_URL,
		\FilesystemIterator::CURRENT_AS_FILEINFO |
		\FilesystemIterator::SKIP_DOTS
	), $filter));


	$base_url = str_replace(DIRECTORY_SEPARATOR, '/', BASE_URL."/");

	$files = array();

	foreach ($iterator as $fileInfo) {

		$fullPath = str_replace(DIRECTORY_SEPARATOR, '/', $fileInfo->getPathName());
		$path = str_replace($base_url, "", $fullPath);

		$files[$path] = hash_file("sha256", $fullPath);
	}
	return $files;
}



function strpos_arr($haystack, $needle) {
	if(!is_array($needle)) $needle = array($needle);
	foreach($needle as $what) {
		if(($pos = strpos($haystack, $what))!==false) return $pos;
	}
	return false;
}

function get_post_array($names, $post = null){
	if(empty($post)){
		$post = $_POST;
	}
	$array = explode(",", $names);

	$rt = array();
	foreach($array as $k){
		$rt[$k] = getIndex($post, $k);
	}

	return $rt;
}

function mime_type($filename) {

	$mime_types = array(

		"webpage" => array(
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv'),

		"image" => array(	// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml'),

		"archive" => array(
			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed'),

		"media" => array(	// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime'
		),

		"adobe" => array(	// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript'
		),

		"document" => array(	// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint'
		),

		"office" => array(
			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		)
	);

	$x = explode(".", $filename);
	$ext = strtolower($x[count($x) - 1]);

	foreach($mime_types as $doc => $array) {
		if (array_key_exists($ext, $array)) {
			return array("type"=>$doc, "ext"=> $ext, "mine_type"=>$array[$ext]);
		}
	}

	if (function_exists('finfo_open')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
		return array("type"=>"", "ext"=>$ext, "mime_type"=>$mimetype);
	}
	else {
		return array("type"=>"", "ext"=>"", "mime_type"=>"");
	}
}

function stringtotime($date){
	return strtotime(parse_date($date));
}

function compareString($value1, $value2){
	return trim(strtolower($value1)) == trim(strtolower($value2));
}

function print_option($innerValue, $outValue, $selected = ""){
	$s = compareString($innerValue, $selected)?"selected":"";
	print "<option value='".pv($innerValue)."' $s>$outValue</option>";
}

function start_sync($start_now = false){
	if(is_server()){
		return false;
	}
	if(!$start_now){
		if(get_setting("sync_enable_automatic","0", false) == "0")
			return "Automatic updating disabled";

		$next_time = get_setting("sync_next_time",0,false);

		if(time() < $next_time){
			return "Not yet time to re-run synchronization";
		}
	}

	$ch = curl_init(url('sync/now'));
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, $start_now?5000:1000);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	$x = curl_exec($ch);
	return $x;
}


function get_domain($url)
{
	$pieces = parse_url($url);
	$domain = isset($pieces['host']) ? $pieces['host'] : '';
	if (!empty($domain)) {
		return $domain;
	}
	return false;
}


function checkMaxInputVars()
{
	$max_input_vars = ini_get('max_input_vars');
	# Value of the configuration option as a string, or an empty string for null values, or FALSE if the configuration option doesn't exist
	if($max_input_vars == FALSE)
		return FALSE;

	$php_input = substr_count(file_get_contents('php://input'), '&');
	//$post = count($_POST, COUNT_RECURSIVE);

	//echo $php_input,'==', $post,'==', $max_input_vars;

	return $max_input_vars > $php_input;
}

function payment_item_type($type){
	if($type == "0") return "All Students";
	if($type == "1") return "New Students";
	if($type == "2") return "Returning Students";
	return "";
}

function payment_category_type($type){
	if($type == 0) return "Compulsory";
	if($type == 1) return "Optional";
}

function get_payment_category($student_id_array, $term_id){

	c()->safer_where_in("student_id", $student_id_array);
	d()->join("student_payment_list", "student_payment.student_payment_id = student_payment_list.student_payment_id");
	d()->select("category_name");
	d()->order_by("category_name_order", "ASC");
	d()->where("student_payment.deleted", 0);
	d()->where("student_payment_list.deleted", 0);
	d()->where("term_id", $term_id);

	$array = d()->get("student_payment")->result_array();
	$category = array();
	foreach($array as $row){
		$category[$row['category_name']] = $row['category_name'];
	}
	return $category;
}

function tcolor($sel = null){
	$array = array("blue"=>"#3c8dbc","black"=>"black","green"=>"#00a65a","purple"=>"#605ca8","red"=>"#dd4b39","yellow"=>"#f39c12", "darkgreen"=>"#014501");
	return $sel == null?$array:getIndex($array, $sel, $sel);
}

function amount($amount, $currency = "", $decimal = 2){
	return (empty($currency)?get_setting("currency")."":$currency).number_format($amount, $decimal);
}

function general_settings($type = ""){
	switch($type){
		case 'company':
			return array("cname"=>"Company Name", "caddress"=>"Company Address", "cemail"=>"Company Email", "cphone"=>"Company Phone", "website"=>"Website");
		case 'login':
			return array("login_using_username","login_using_email","login_using_phone","register_using_username","register_using_email","register_using_phone");
	}
}

function check_domain()
{
	$name = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "");
	$name = pure_url($name);
	$schools = d()->get_where("domain", array("domain" => $name));

	if ($schools->num_rows() > 0) {
		define("owner", $schools->row()->owner);
		define("domain_name", $name);
		$disabled = getIndex(c()->get("reseller")->row_array(), "disabled");
		if($disabled != 0){
			die("<center><h2>This site has been disabled, Please Contact Admin</h2></center>");
		}

	} else {
		define("owner", 0);
		die("<center><h2>Invalid Domain Redirection.</h2><h5>Please Contact Your Admin</h5></center>");
	}

    if(get_setting("force_https") == 1){
	    redirectTohttps();
    }
}

function redirectTohttps() {
    if ((!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!="on") && !is_ajax()) {
        if(!empty($_SERVER['REQUEST_URI']) && stripos($_SERVER['REQUEST_URI'], "api") === false) {
            $name = $_SERVER['HTTP_HOST'];
            if(stripos($name, "www.") === 0){
                $name = substr($name, 4);
            }
            $redirect = "https://" . $name . $_SERVER['REQUEST_URI'];
            header("Location:$redirect");
            exit;
        }
    }
}

function isSecure() {
	return
		(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		|| $_SERVER['SERVER_PORT'] == 443;
}

function domain_name(){
	$name = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "");
	$name = preg_replace('/https?:\/\//', '', strtolower($name));
	return $name;
}

function pure_url($url)
{
	$url = preg_replace('/https?:\/\/|www./', '', strtolower($url));
	if (strpos($url, '/') !== false) {
		$ex = explode('/', $url);
		$url = $ex['0'];
	}
	return $url;
}

function country_name($code){
	$array = getCountries();
	$istrue = false;
	$a3 = substr($code, 0, 3);
	$a2 = substr($code, 0, 2);
	$a1 = substr($code, 0, 1);
	if (isset($array[$a3]))
		$istrue = $a3;
	else if (isset($array[$a2]))
		$istrue = $a2;
	else if (isset($array[$a1]))
		$istrue = $a1;

	if ($istrue === false)
		return "";

	$name = $array[$istrue][1];
return $name;
}

function getCountries()
{
	return Array(93 => Array('5', 'Afghanistan'), 213 => Array('5', 'Algeria'), 244 => Array('5', 'Angola'), 374 => Array('5', 'Armenia'), 61 => Array('5', 'Australia'), 43 => Array('5', 'Austria'), 994 => Array('5', 'Azerbaijan'), 1242 => Array('5', 'Bahamas'), 973 => Array('5', 'Bahrain'), 880 => Array('1', 'Bangladesh'), 1246 => Array('5', 'Barbados'), 375 => Array('5', 'Belarus'), 32 => Array('5', 'Belgium'), 501 => Array('5', 'Belize'), 229 => Array('5', 'Benin'), 1441 => Array('5', 'Bermuda'), 387 => Array('5', 'Bosnia and Herzegovina'), 267 => Array('5', 'Botswana'), 673 => Array('5', 'Brunei'), 359 => Array('5', 'Bulgaria'), 226 => Array('5', 'Burkina Faso'), 257 => Array('5', 'Burundi'), 855 => Array('5', 'Cambodia'), 237 => Array('5', 'Cameroon'), 235 => Array('5', 'Chad'), 225 => Array('5', 'Cote D\'Ivoire'), 385 => Array('5', 'Croatia'), 357 => Array('5', 'Cyprus'), 420 => Array('5', 'Czech Republic'), 45 => Array('5', 'Denmark'), 20 => Array('5', 'Egypt'), 372 => Array('5', 'Estonia'), 358 => Array('5', 'Finland'), 879 => Array('5', 'France'), 241 => Array('5', 'Gabon'), 220 => Array('5', 'Gambia'), 995 => Array('5', 'Georgia'), 49 => Array('5', 'Germany'), 233 => Array('2', 'Ghana'), 30 => Array('5', 'Greece'), 852 => Array('5', 'Hong Kong'), 36 => Array('5', 'Hungary'), 354 => Array('5', 'Iceland'), 91 => Array('2', 'India'), 62 => Array('5', 'Indonesia'), 98 => Array('5', 'Iran'), 964 => Array('5', 'Iraq'), 353 => Array('5', 'Ireland'), 972 => Array('5', 'Israel'), 39 => Array('5', 'Italy'), 962 => Array('5', 'Jordan'), 7 => Array('5', 'Kazakhstan'), 254 => Array('5', 'Kenya'), 965 => Array('5', 'Kuwait'), 371 => Array('5', 'Latvia'), 961 => Array('5', 'Lebanon'), 231 => Array('5', 'Liberia'), 218 => Array('5', 'Libya'), 423 => Array('5', 'Liechtenstein'), 370 => Array('5', 'Lithuania'), 352 => Array('5', 'Luxembourg'), 853 => Array('5', 'Macao'), 389 => Array('5', 'Macedonia'), 261 => Array('5', 'Madagascar'), 265 => Array('5', 'Malawi'), 60 => Array('2', 'Malaysia'), 960 => Array('5', 'Maldives'), 223 => Array('5', 'Mali'), 356 => Array('5', 'Malta'), 596 => Array('5', 'Martinique'), 222 => Array('5', 'Mauritania'), 230 => Array('5', 'Mauritius'), 373 => Array('5', 'Moldova'), 377 => Array('5', 'Monaco'), 976 => Array('5', 'Mongolia'), 1664 => Array('5', 'Montserrat'), 212 => Array('6', 'Morocco'), 258 => Array('5', 'Mozambique'), 264 => Array('5', 'Namibia'), 977 => Array('5', 'Nepal'), 31 => Array('5', 'Netherlands'), 599 => Array('5', 'Netherlands Antilles'), 64 => Array('5', 'New Zealand'), 505 => Array('5', 'Nicaragua'), 227 => Array('3', 'Niger'), 234 => Array('1', 'Nigeria'), 47 => Array('5', 'Norway'), 968 => Array('5', 'Oman'), 92 => Array('1', 'Pakistan'), 680 => Array('5', 'Palau'), 972 => Array('5', 'Palestine w/Israel'), 507 => Array('5', 'Panama'), 63 => Array('5', 'Philippines'), 48 => Array('5', 'Poland'), 351 => Array('5', 'Portugal'), 974 => Array('5', 'Qatar'), 262 => Array('5', 'Reunion'), 40 => Array('5', 'Romania'), 7 => Array('1', 'Russian Federation'), 250 => Array('5', 'Rwanda'), 378 => Array('5', 'San Marino'), 966 => Array('5', 'Saudi Arabia'), 221 => Array('5', 'Senegal'), 248 => Array('5', 'Seychelles'), 232 => Array('5', 'Sierra Leone'), 65 => Array('5', 'Singapore'), 421 => Array('5', 'Slovakia'), 386 => Array('5', 'Slovenia'), 252 => Array('5', 'Somalia'), 27 => Array('2', 'South Africa'), 34 => Array('5', 'Spain'), 94 => Array('5', 'Sri Lanka'), 249 => Array('5', 'Sudan'), 597 => Array('5', 'Suriname'), 268 => Array('5', 'Swaziland'), 46 => Array('5', 'Sweden'), 41 => Array('5', 'Switzerland'), 963 => Array('5', 'Syria'), 886 => Array('5', 'Taiwan'), 992 => Array('5', 'Tajikistan'), 255 => Array('5', 'Tanzania'), 66 => Array('3', 'Thailand'), 216 => Array('5', 'Tunisia'), 90 => Array('5', 'Turkey'), 256 => Array('5', 'Uganda'), 380 => Array('5', 'Ukraine'), 971 => Array('2', 'United Arab Emirates'), 44 => Array('5', 'United Kingdom'), 1 => Array('2', 'United States'), 598 => Array('5', 'Uruguay'), 998 => Array('5', 'Uzbekistan'), 678 => Array('5', 'Vanuatu'), 58 => Array('5', 'Venezuela'), 84 => Array('5', 'Vietnam'), 967 => Array('5', 'Yemen'), 381 => Array('5', 'Yugoslavia'), 260 => Array('5', 'Zambia'), 263 => Array('5', 'Zimbabwe'));
}

function removeZero($phone)
{
	if (stripos($phone, "0") !== false) {
		$x = stripos($phone, "0");
		if ($x == 0) {
			return substr($phone, 1);
		}
	}
	return $phone;
}

function countryExit($phone,  &$name = "OTHERS")
{
	if (strlen($phone) <= 5)
		return false;
	$array = getCountries();
	$istrue = false;
	$a3 = substr($phone, 0, 3);
	$a2 = substr($phone, 0, 2);
	$a1 = substr($phone, 0, 1);
	if (isset($array[$a3]))
		$istrue = $a3;
	else if (isset($array[$a2]))
		$istrue = $a2;
	else if (isset($array[$a1]))
		$istrue = $a1;

	if ($istrue === false)
		return false;

	$name = $array[$istrue][1];

	return true;
}


function theme_assets($url){

}

function default_menu(){
//	$menu["home"] = string2array("link=home,label=Home Page");
//	$menu["about_us"] = string2array("link=about_us,label=About Us");
//	$menu["contact_us"] = string2array("link=contact_us,label=Contact Us");
//	$menu["faq"] = string2array("link=faq,label=Frequent Ask Question");
$menu = array();
	$menu["home"] = "Home Page";
	$menu["about_us"] = "About Us";
	$menu["contact_us"] = "Contact Us";
	$menu["faq"] = "Frequent Ask Question";
	return $menu;
}


function getDStatus($id){
	switch($id){
		case 0: return "SENT";
		case 1: return "DELIVRD";
		case 2: return "UNDELIVRD";
		case 3: return "EXPIRED";
		case 4: return "REJECTED";
		case 5: return "INVALID NO.";
		case 6: return "SMSC EXPIRED";
		case 7: return "NOT SENT";
		case 8: return "NO REPORT";
		case 9: return "DND (Refunded)";
		default: return "UNKNOWN";
	}
}

function reseller_id(){
//	return 1;
	static $id = null;
	if($id === null) {
		d()->where("owner", owner);
		$mine = d()->get("reseller")->row_array();
		$id = getIndex($mine, "parent");
	}
	return $id;
}

function founder(){
	static $founder = null;
	if($founder === null) {
		d()->order_by("owner", "ASC");
		$founder = d()->get("reseller")->row_array();
	}
	return $founder;
}

function reseller_owner($reseller_id){
        d()->where("owner", $reseller_id);
		$reseller = d()->get("reseller")->row_array();

		if(empty($reseller['parent']))
		    return array();

        d()->where("owner", $reseller['parent']);
        $owner = d()->get("reseller")->row_array();

    return $owner;
}

function owner_user_id($owner){
	d()->where("owner", $owner);
	$mine = d()->get("reseller")->row_array();
	return getIndex($mine, "user_id");
}

function is_reseller(){
	return empty(reseller_id())?false:true;
}

function is_owner(){
	return empty(reseller_id())?true:false;
}

function is_mz(){
	return get_setting("is_mz","", 1) == 1;
}

function is_hillary(){


	return false;
	return get_setting("is_hillary","", 1) == 1;
}


function network($number = null){
	if(strlen($number) == 13 && strpos($number, "234") === 0) {
		$number = "0" . substr($number, 3);
	}

	$network['mtn'] = string2array("0803,0806,0703,0706,0813,0816,0810,0814,0903,0906");
	$network['glo'] = string2array("0805,0807,0705,0815,0811,0905");
	$network['airtel'] = string2array("0802,0808,0708,0812,0701,0902,0907");
	$network['etisalat'] = string2array("0809,0818,0817,0908,0909");
//	$network['ntel'] = string2array("0804");
//	$network['smile'] = string2array("0702");
	if($number === null)
		return $network;

	$x = substr($number, 0, 4);
	foreach($network as $nt => $num){
		foreach($num as $no){
			if($x == $no)
				return $nt;
		}
	}
	return "";
}


function hash_password($password){
	return password_hash($password, PASSWORD_BCRYPT);
}

function generate_session_token($type = "", $generated_token = ""){
	$token = getGUID();
	$type = empty($type)?"":"_$type";
	s()->set_userdata("session_token$type", empty($generated_token)?$token:$generated_token);
	return $token;
}

function validate_session_token($token, $type = "", $die_on_false = true){
	$type_ = empty($type)?"":"_$type";
	$stoken = s()->userdata("session_token{$type_}");
	if($stoken == $token || empty($stoken)){
		return true;
	}

	if($die_on_false) {
		generate_session_token($type, $token);
		ajaxFormDie("You have a pending request. To avoid being charged twice, please check your history to confirm it has not already been sent. Or simply send again");
	}
	return false;
}

function showAjaxModalTag(){
	return "#modal_ajax .modal-body";
}


function api_response_code($code){
	switch($code) {
		case 1001:
			return "Invalid Username Or Password";
		case 1002:
			return "Invalid Sender ID";
		case 1003:
			return "Empty Message";
		case 1004:
			return "Invalid Recipient";
		case 1005:
			return "Insufficient balance";
		case 1006:
			return "Invalid Schedule Date";
		case 1010:
			return "Error Sending Message";
		case 1015:
			return "Unknown Error";
	}
	return $code;
}

function mail2sms($mail){
	return strip_tags(str_replace(array("<br>","</br>"), "\n", $mail));
}

function sms2mail($sms){
	return str_replace("\n", "<br>", $sms);
}

function remove_underscore($value, $ucwords = true){
	$x = str_replace("_", " ", $value);
	if($ucwords)
		$x = ucwords($x);
	return $x;
}

function format_notification($message){
	return preg_replace('/href="(\/)?([\w_\-\/\.\?&=@%#]*)"/i','href="'. ((isSecure()?"https://":"http://").domain_name()).'/$2"', $message);
}