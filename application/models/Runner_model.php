<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Runner
 * @property Runner_model $runner_model Runner module
 * @property Runner $runner Send SMS
 */
class Runner_model extends CI_Model {

    private $sms_retry_interval = 5 * 60;
    public function __construct() {
        parent::__construct();
    }

   public function start(){

       $lockme = lockMe("runner");
       if(!$lockme)
           die("Already locked");

       d()->where("next_run <=", time());
       d()->where("active", 1);
       $array = d()->get("schedule")->result_array();

       foreach($array as $row){
           switch($row['type']){
               case "sms":
                    $this->process_sms($row);
                   break;
               case "bill":
               case "airtime":
               case "dataplan":
                   $this->process_bill_payment($row);
                   break;
           }
       }

       $this->process_delivery_report();

       $this->process_pending_bills();


       releaseLockMe($lockme);
   }

    private function process_sms($row){
        $error = "";
        $sms = unserialize($row['class']);
        $sms->method = $sms->method. " (schedule)";
        $source = "previous_wallet";

        source:
        $sms->balance_source = $source == "previous_wallet"?"previous_balance":"balance";
        $bal = $sms->user_balance();
        $cost = $sms->total_cost();


        if(empty($cost)){
            $error = "Incorrect Gateway Price";
        }

        if($cost > $bal) {
            if($source == "previous_wallet"){
                $source = "balance";
                goto source;
            }
            $error = "Insufficient Balance";
        }

        $validate = $sms->validate_sms();

        if(!empty($validate))
            $error = $validate['result'];

        if(!empty($error)){
            $data['active'] = 0;
            $data['remark'] = $error;
            d()->where("id", $row['id']);
            d()->update("schedule", $data);
            return;
        }

        $sent = $sms->send_sms();

        if($sent['sent']){
            d()->where("id", $row['id']);
            d()->delete("schedule");
        }else{
            d()->where("id", $row['id']);
            $data['next_run'] = $this->sms_retry_interval + time();
            d()->update("schedule", $data);
        }
    }

    private function process_bill_payment($row)
    {
        $error = "";
        $mybill = unserialize($row['class']);

        $balance = (Float) $mybill->user_balance();
        if($mybill->total_cost() > $balance){
            $error = "Insufficient Balance";
        }

        if(!empty($error)){
            $data['active'] = 0;
            $data['remark'] = $error;
            d()->where("id", $row['id']);
            d()->update("schedule", $data);
            return;
        }

        $sent = $mybill->buy_now();

        if($sent['sent']){
            d()->where("id", $row['id']);
            d()->delete("schedule");
        }else{
            d()->where("id", $row['id']);
            $data['next_run'] = $this->sms_retry_interval + time();
            d()->update("schedule", $data);
        }
    }

    private function process_delivery_report(){
        $array = d()->get("delivery_report")->result_array();
        foreach($array as $row){
            $msg_id = $row['msg_id'];
            $data['status'] = $row['status'];
            $data['donedate'] = $row['done_date'];

            d()->where("msg_id", $msg_id);
            d()->update("recipient", $data);

            d()->where("id", $row['id']);
            d()->delete("delivery_report");
        }
    }

    private function process_pending_bills(){
        d()->group_start();
        d()->where("status", "ORDER_ONHOLD");
        d()->or_where("status", "ORDER_RECEIVED");
        d()->or_where("status", "ORDER_PROCESSING");
        d()->or_where("status", "Pending Refund");
        d()->group_end();

        d()->where("order_id !=", "-1");
        d()->where_in("bill_type", array("bill", "airtime", "dataplan"));
//        Get only the running domain
        $array = c()->get("bill_history")->result_array();
        foreach($array as $row){
            if(empty($row['order_id'])){
                d()->where("id", $row['id']);
                d()->update("bill_history", array("remark"=>'Invalid Order Id', 'order_id'=>-1));
                return;
            }
            $bb = new mybill($row['owner']);
            $bb->set_user($row['user_id']);
            $bb->update_current_status($row);
        }
    }


}