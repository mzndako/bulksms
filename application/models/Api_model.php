<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Cart
 * @property Sms_model $sms_model Cart module
 * @property sms $sms Send SMS
 */
class Api_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function bulksms(){
        $user = $this->authenticate();

        $message = $this->fetch("message");
        $sender = $this->fetch("sender");
        $recipient = $this->fetch("recipient");
        $route = $this->fetch("route", "");
        $flash = $this->fetch("flash", 0);
        $report = $this->fetch("report", 0);
        $schedule = $this->fetch("schedule");
        $device = $this->fetch("device");

        if($route == "" || !is_numeric($route) || $route > 2 || $route < 0){
            $route = $user['route'];
        }

        $agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:$_SERVER['REMOTE_ADDR'];
        $method = !empty($device)?$device:"API: $agent";

        $sms = new sms();
        $sms->translate = false;
        $sms->set_user($user['id']);
        $sms->set_message($message);
        $sms->set_sender($sender);
        $sms->set_recipient($recipient);
        $sms->set_route($route);
        $sms->method = $method;
        $sms->is_flash = empty($flash)?false:true;
        $source = "previous_wallet";

        $validate = $sms->validate_sms();

        if(!empty($validate))
            $this->failed($validate['result']);

        source:
        $sms->balance_source = ($source == "previous_wallet"?"previous_balance":"balance")  ;
        $bal = $sms->user_balance();
        $cost = $sms->total_cost();



        if(empty($cost))
            $this->failed("1015");

        if($cost > $bal) {
            if($source == "previous_wallet"){
                $source = "balance";
                goto source;
            }
            $this->failed("1005");
        }

        if(!empty($schedule)){
            $time = strtotime($schedule);
            if($time < time())
                $this->failed("1006");
            $data['owner'] = owner;
            $data['user_id'] = $user['id'];
            $data['type'] = "sms";
            $data['class'] = serialize($sms);
            $data['next_run'] = $time;
            $data['remark'] = "Pending";
            $data['date'] = time();
            d()->insert("schedule", $data);

            $this->success("OK | Message Successfully Scheduled to Delivery @ ".convert_to_datetime($time));
        }


        $sent = $sms->send_sms();


        if($sent['sent']){
            $scount = count($sent['count']['sent']);
            $msg = "OK $scount";
            if($report == 1)
                $msg .= " = ".$sent['sent_id'];
            if(count($sent['count']['dnd']) > 0 && $route == 0){
                $msg .= "|";
                $msg .= implode(",", $sent['count']['dnd']);
            }
            unset($sent['sent']);
            $sent['result'] = "";
            $sent['status'] = true;
            $sent['remark'] = "Message sent successfully";
            $this->failed($msg, $sent);
        }else{
            $this->failed(1010);
        }

    }

    function balance(){
        $user = $this->authenticate(false);

        if(empty($user))
            $this->failed("Invalid Username or Password");

        $balance = format_wallet($user['balance'], -1);
        $previous_balance = parse_amount($user['previous_balance']). " Units";
        $msg = "Balance = $balance \nPrevious Balance = $previous_balance";
        $this->failed($msg, array("balance"=>$balance,"previous_balance"=>$previous_balance, "status"=>true));
    }

    function transfer(){
        $user = $this->authenticate(false);

        if(empty($user))
            $this->failed("Invalid Username or Password");

        $from_amount = parse_amount($user['balance']);

        $amount = parse_amount($this->fetch("amount"));
        $to = trim($this->fetch("to"));

        if(empty($amount)){
            $this->failed("Invalid Amount Specified");
        }

        if(empty($to)){
            $this->failed("Invalid Username Transferring To");
        }

        if($amount > $from_amount){
            $this->failed("Insufficient Balance");
        }

        if(c()->is_email($to)){
            d()->where('email',  $to);
        }else{
            $sms = new sms();
//            $sms->justnigeria = true;
            $sms->set_recipient($to);

            if($sms->get_numbers_count() == 1) {
                d()->where("phone", $sms->get_numbers());
            }else {
                d()->where("username", $to);
            }
        }

        $array = c()->get("users");

        if($array->num_rows() > 1){
            $this->failed("More than One User exist. Please use another feature to identify the user");
        }elseif($array->num_rows() == 0){
            $this->failed("No User '$to' Found");
        }

        $user_to = $array->row_array();


//DEDUCT FROM, FROM ACCOUNT
        update_user_balance($amount, false, false, $user['id']);
//ADD TO, TO ACCOUNT
        update_user_balance($amount, true, true, $user_to['id']);

        $this->success(format_amount($amount, -1). " Successfully Transferred to '$to'");
    }

    private function authenticate($die = true){
        $username = $this->fetch("username");
        $password = $this->fetch("password");
        $credential = array();

//        $is_mz = is_mz();
        if(c()->is_email($username)){
            $credential['email'] = $username;
        }else{
            $sms = new sms();
//            $sms->justnigeria = true;
            $sms->set_recipient($username);
            if($sms->get_numbers_count() == 1) {
                d()->where("phone", $sms->get_numbers());
            }else {
                d()->where("username", $username);
            }
        }

        // Checking login credential for teacher
        $query = c()->get_where('users', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            if (!password_verify($password, $row['password'])) {
                if( empty($row['last_password']) || $row['last_password'] != previous_password_hash($password)) {
                    if ($die) {
                        $this->failed("1001");
                    }else{
                        return false;
                    }
                }
            }

            if($row['disabled'] != 0){
                if($die) {
                    $this->failed("Error: " . $row['disabled_text']);
                }
                return false;
            }
            return $row;
        }else{
            if($die)
                $this->failed("1001");
        }

        return false;
    }

    function receive_report($from = "routesms"){

        $number = $this->fetch('sMobileNo');
        $status = $this->fetch('sStatus');
        $done_date = $this->fetch('dtDone');
        $msg_id = $this->fetch('sMessageId');
        if(empty(trim($msg_id)))
            return;

        $done_date = strtotime($done_date) - ((4*60*60)+30);
        $sms = new sms();

        $data['msg_id'] = $msg_id;
        $data['status'] = $sms->getDID($status);
        $data['done_date'] = $done_date;

        d()->insert("delivery_report", $data);

    }

    private function fetch($key, $default = ""){
        if(isset($_POST[$key]))
            $x = $this->input->post_get($key);
        else
            $x = urldecode($this->input->post_get($key));

        return empty($x)?$default:$x;
    }

    private function failed($value, $array1 = array()){
        $type = $this->fetch("type");
        if($type == "json"){
            $array = array("status"=>false,"result"=>$value, "remark"=>api_response_code($value));
            $array = array_merge($array, $array1);
            print json_encode($array);

        }else {
            if(!empty($this->fetch("explain")))
                $value = api_response_code($value);
            print $value;
        }

        die();
    }

    private function success($value, $array1 = array()){
        $array1['status'] = true;
        return $this->failed($value, $array1);
    }
}