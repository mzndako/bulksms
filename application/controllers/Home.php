<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Joyonto Roy
 * 	30th July, 2014
 * 	Creative Item
 * 	www.freephpsoftwares.com
 * 	http://codecanyon.net/user/joyontaroy
 */

class Home extends CI_Controller {
    public $c_;

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->c_ = $this->crud_model;

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {
        $params= $this->uri->segments;
        $method = 'homepage';
        call_user_func_array(array($this, $method), $params);
    }

    public function _remap($method, $params = array())
    {
        $method = 'homepage';
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }


    }

    public function homepage($param1 = "", $param2 = "", $param3 = "", $param4 = ""){


        $data['param1'] = $param1;
        $data['param2'] = $param2;
        $data['param3'] = $param3;
        $data['param4'] = $param4;
        $this->load->view('frontend/index', $data);
    }

}
