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

class Api extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('billpayment');
        $this->load->model("api_model");
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    function bulksms(){
        this()->api_model->bulksms();
    }

    function balance(){
        this()->api_model->balance();
    }

    function transfer(){
        this()->api_model->transfer();
    }


    function receive_report($from = "routesms"){
        this()->api_model->receive_report($from);
    }

    function bill_report($from = ""){
        this()->api_model->receive_bill_report($from);
    }
    function previous($load = ""){
        if($load == "delivery.php"){
            $this->receive_report();
        }else if($load == "sendsms.php"){
            $this->bulksms();
        }else{
            if(method_exists($this, $load)){
                $this->$load();
            }
        }
    }














}
