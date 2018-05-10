<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller {

public $c_;
	function __construct()
    {
        parent::__construct();
		$this->load->database();
	    $this->load->library('session');

	    $this->c_ = $this->crud_model;
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    }
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		
	}
	
	
	/*
	*	$page_name		=	The name of page
	*/
	function popup($page_name = '')
	{
		if (!hAccess('login')) {
			die("Login Expired. Please refresh page to re-login");
		}

		$array = func_get_args();
		$page_data['page_name'] = $page_name;
		$page_data['param1'] = "";
		$page_data['param2'] = "";
		$page_data['param3'] = "";
		$page_data['param4'] = "";

		$x = 0;
		foreach($array as $page){
			$page_data["param".$x] = $page;
			$x++;
		}
		$page_data['c']		=	$this->crud_model;

		$allowed = false;
		$link = str_replace(".","/",$page_name);
		foreach(c()->allowedScript() as $script){
			if($script == $link){
				$allowed = true;
				break;
			}
		}

		if(!$allowed){
			if(strpos($link, "modal") !== false)
				$allowed = true;
		}

		if(!$allowed){
			die("You are not allowed to view this page using this method");
		}


		echo $this->load->view( 'backend/templates/'.$link.'.php' ,$page_data, true);
		echo '<script>runPageHooks();</script>';
	}

	function super($page_name = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('superadmin') != 1)
			die("Please login first");

		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		$page_data['c']		=	$this->crud_model;
		$this->load->view( 'backend/superadmin/'.$page_name.'.php' ,$page_data);
		echo '<script src="assets/js/neon-custom-ajax.js"></script>';
	}
}

