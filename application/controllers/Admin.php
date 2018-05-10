<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 *	@author 	: Joyonto Roy
 *	date		: 27 september, 2014
 *	FPS School Management System Pro
 *	http://codecanyon.net/user/FreePhpSoftwares
 *	support@freephpsoftwares.com
 */

class Admin extends CI_Controller
{
	public $division_id;
	public $c_;

	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->library('session');


		$this->c_ = $this->crud_model;

		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		if (hAccess('login')) {
//			$this->session->set_flashdata('flash_message', "Please login first");
//			redirect(base_url() . "?login", 'refresh');
		}

//		$sms = new sms();
//		$x = "?????"; $a ="a@#^$#*&^*@)!(*#&%*&^$(~`/*-+";
//
//		$x = base64_decode("2YXYsdit2KjYpw==");
////		$x = $sms->utf8_clean( $a." ".$x);
//		print mb_strlen($x, 'UTF-8');
//		print $x;
//		print "<br>";
//
//		$conv1 = $sms->str2unicode2hex($x);
//		print strtoupper($conv1);
//		print " - ";
////		print $sms->sms_dec($conv1);
//		print $sms->sms_dec($conv1);
//		print "<br>";
//		$conv2 = $sms->str2unicode($x);
//		print strlen($conv2);
//		print " - ";
//		print $conv2;
//		print " - ";
//		print $sms->sms_dec($conv2);
//		print " - ";
//		print strlen($sms->sms_dec($conv2));
////		print $conv2);
//		die();

	}

	public function index()
	{
		if(is_login())
			redirect(url("admin/dashboard"), 'refresh');
		else
			redirect(url("login"), "refresh");
	}

	/***ADMIN DASHBOARD***/
	function dashboard()
	{
		if(!is_login())
			redirect(url("login"), "refresh");

		$page_data['page_name'] = 'dashboard';
		$page_data['page_title'] = get_phrase('dashboard');

		$this->load->view('backend/index', $page_data);
	}


	function alerts($param1 = "", $param2 = "", $param3 = ""){
		rAccess("manage_alerts");

		if($param1 == "update"){
			$not = c()->get_notifications();
			foreach($not as $row){
				foreach($row['options'] as $opt){
					setting()->save_notification($opt['name'],$this->input->post($opt['name']));
				}
			}
			ajaxFormDie("Successfully Saved", "success");
		}



		$page_data['page_name'] = 'setting/alerts';
		$page_data['page_title'] = "Manage Alerts";
		$this->load->view('backend/index', $page_data);
	}


	function notifications($param1 = "", $param2 = "", $param3 = "")
	{
		if($param1 == "read"){
			rAccess("login");
			c()->mark_notification($param2, "read");
			ajaxFormDie("Read","success");
		}

		rAccess("manage_notifications");
		if($param1 == "update"){
			$data['title'] = $this->input->post("title");
			$data['message'] = $this->input->post("message");

			if(empty($data['title']))
				ajaxFormDie("Title can not be empty");

			if(empty($data['message']))
				ajaxFormDie("Message can not be empty");;

			if(!empty($this->input->post("target_all"))){
				$data['location'] = "all";
			}else{
				$array = $this->input->post("target");
				if(empty($array)){
					ajaxFormDie("Target Page can not be empty");
				}
				$my_array = array();
				foreach($array as $loc){
					$my_array[] = "[{$loc}]";
				}
				$data['location'] = implode(",", $my_array);
			}

			$data['type'] = p("type");
			$data['disappear_on_read'] = empty(p("disappear_on_read"))?0:1;
			$data['store'] = empty(p("store"))?0:1;
			$data['new_user_can_see'] = empty(p("new_user_can_see"))?0:1;
			$data['show_once'] = empty(p("show_once"))?0:1;
			$data['expires'] = empty(p("expires"))?0:strtotime(parse_date(p('expires')));

			if(empty($param2)){
				$data['date'] = time();
				c()->insert("notification", $data);
				$msg = "Created Successfully";
			}else{
				d()->where("id", $param2);
				c()->update("notification", $data);
				$msg = "Updated Successfully";
			}
			set_flash_message($msg);
			return return_function("notifications");
		}

		if($param1 == "update_hp"){
			set_setting("hp_notification_title", $this->input->post("title"));
			set_setting("hp_notification_message", $this->input->post("message"));
			set_setting("hp_notification_show_once", empty($this->input->post("show_once"))?0:1);
			set_setting("hp_notification_enabled", empty($this->input->post("enabled"))?0:1);
			ajaxFormDie("Successfully Saved", "success");
		}

		if($param1 == "delete"){
			c()->where("id", $param2);
			c()->delete("notification");

			c()->where("notification_id", $param2);
			c()->delete("notification_read");

			ajaxFormDie("Successfully Deleted", "success");
		}


		if($param1 == "disabled"){
			d()->where("id", $param2);
			c()->update("notification", array("active"=>empty($param3)?0:1));
			if(empty($param3)){
				ajaxFormDie("Disabled Successfully");
			}else{
				ajaxFormDie("Enabled Successfully", "success");
			}
		}



		$page_data['page_name'] = 'admin/notification';
		$page_data['page_title'] = get_phrase('Notification');

		$this->load->view('backend/index', $page_data);
	}


	function run_db_update($line = ""){
		$version = !empty($line)?parse_number($line):get_setting("sync_structure_version",0);;
		$folder = "db_update";
		$array = scandir($folder, SCANDIR_SORT_ASCENDING);
		sort($array, SORT_NUMERIC);
		$str = "";
		$nv = 0;
		foreach($array as $file){
			if($file == '.' || $file == '..')
				continue;
			$path = "$folder/$file";
			if(file_exists($path) && $file > $version) {
				$str .= "\n" . file_get_contents($path);
				$nv = $file;
			}

		}

		if(empty($str)){
			print "No update available [$version]";
			return ;
		}


		$sql = explode("\n", $str);

		$query = '';
		d()->db_debug = false;
		$err = "";

		foreach($sql as $line) {
			$tsl = trim($line);
			if (($sql != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) {
				$query .= $line;

				if (preg_match('/;\s*$/', $line)) {

					print $query."<br>";
					if(!d()->query($query )){
						print "<b style='color: red;'>". getIndex(d()->error(),"message"). "</b><br>";
					}


					$query = '';
				}
			}
		}

		set_setting("sync_structure_version",$nv);
	}

	function is_mz($param1 = 0){
		set_setting("is_mz", $param1, 1);
		if(empty($param1)){
			print "Is MZ Disabled";
		}else{
			print "is MZ Enabled";
		}
	}
	function is_hillary($param1 = 0){
		set_setting("is_hillary", $param1, 1);
		if(empty($param1)){
			print "Is Hillary Disabled";
		}else{
			print "is Hillary Enabled";
		}
	}

}
