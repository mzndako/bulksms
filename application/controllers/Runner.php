<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author 	     :    FreePhpSoftwares
 *	date		     :    25 July, 2015
 *	Item             :    FPS School Management System ios Application
 *  Specification    :    Mobile app response, JSON formatted data for iOS & android app
 *	Portfolio        :    http://codecanyon.net/user/FreePhpSoftwares
 *  Website          :    http://www.freephpsoftwares.com
 *	Support          :    http://support.freephpsoftwares.com
 */

/**
 * Class Sync_client_model
 * @property Sync_client_model $sync_client_model Client module

 * Class Sync_server_model
 * @property Sync_server_model $sync_server_model Server module
 */

class Runner extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
        ignore_user_abort(true);
		$this->load->database();
        $this->load->model("runner_model");
        $this->load->library('billpayment');

    }


    function start(){
        this()->runner_model->start();
    }

}




