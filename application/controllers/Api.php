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

    function sendmail($cnt, $limit = 2000){
      $subject = "Permanent Shut Down Notice";
      $message = "We regret to inform you that QuickSMS will be <b>permanently shut down</b> on 31st May 2019.<br><br>

      This is due to accumulated reasons ranging from inability to deliver SMS to DND numbers, low SMS delivery guarantee, platform sustainability, and high maintenance cost, and many more. 
      
      <br><br>You can still be able to buy and send SMS with your remaining units before the shutdown date but our customer service line will be unavailable starting from 1st of May. 
      
      <br><br>We greatly apologize for any inconveniences caused. 
      
      <br><br>We appreciate your consistent patronage over the years. 
      
      <br><br>The alternative site you could use is www.smartsmssolutions.com
      
      <br><br>Thank you

      <br><br>Sign Management
      
      ";

      d()->where("owner", owner);
      $array = d()->get("users")->result_array();
      print "TOTAL = ".count($array). " = " . $cnt;

      send_mail($message,$subject,"mzndakos@gmail.com");
      //return;
      
      d()->limit($limit);
      d()->offset($limit * ($cnt - 1));
      d()->where("owner", owner);
      $array = d()->get("users")->result_array();
      

      $sent = 0;
      foreach($array as $row){
        $email = $row['email'];
        if(empty($email)){
          continue;
        }
        $sent++;

        send_mail($message,$subject,$email);
      }

      print "<br>Sent to $sent";
      print "<br>Total Sent = " . (($limit * ($cnt - 1)) + $sent);
      
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
