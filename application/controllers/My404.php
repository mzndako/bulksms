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

class My404 extends CI_Controller {
    public $c_;

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->c_ = $this->crud_model;
    }

    //Default function, redirects to logged in user area
    public function index() {
        $data['my404'] = true;
        $this->output->set_status_header('404');
        $this->load->view('frontend/index', $data);
    }


}
