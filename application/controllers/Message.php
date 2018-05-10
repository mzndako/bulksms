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

class Message extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('sms');
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    function bulksms($param1 = "", $param2 = "", $param3 = ""){
        rAccess("send_bulk_sms");

        if($param1 == "sendnow"){

            $message = $this->input->post("message");
            $sender_id = $this->input->post("sender_id");
            $recipient = $this->input->post("recipient");
            $route = $this->input->post("route");
            $id = $this->input->post("id");


            if(post_set("save")){
                if(is_empty($message) && is_empty($recipient) && is_empty($sender_id)){
                    ajaxFormDie("Cant Save empty message");
                }
                $data['message'] = $message;
                $data['recipient'] = $recipient;
                $data['sender'] = $sender_id;
                $data['user_id'] = login_id();
                $data['date'] = time();
                if(empty($id)){
                    c()->insert("draft",$data);
                    $id = d()->insert_id();
                    $msg = "Saved to Draft Successfully";
                }else{
                    d()->where("id", $id);
                    c()->update("draft", $data);
                    $msg = "Re-Saved to Draft Successfully";
                }
                ajaxFormDie($msg, "success", array("draft_id"=>$id));
            }

            $sms = new sms();
            $sms->set_message($message);
            $sms->set_sender($sender_id);
            $sms->set_recipient($recipient);
            $sms->set_route($route);
            $sms->is_flash = empty($this->input->post("flash_sms"))?false:true;
            $sms->balance_source = !empty(user_balance(login_id(), "previous_balance"))?"previous_balance":"balance";

            source:
            $bal = $sms->user_balance();
             $cost = $sms->total_cost();

            if(empty($cost))
                ajaxFormDie("Invalid Admin Price Configuration");

            if($cost > $bal) {
                if($sms->balance_source == "previous_balance"){
                    $sms->balance_source = "balance";
                    goto source;
                }
                ajaxFormDie("Insufficient Balance");
            }

            validate_session_token($this->input->post("session_token"), "sms");


            if(!empty($this->input->post("scheduled"))){
                $schedule = parse_date($this->input->post("schedule_date"));
                $time = strtotime($schedule);
                $new = convert_to_datetime($time);
                if($time < time()) {
                    $msg = "Invalid Scheduled Date Specified Or Scheduled Time has passed";
                    ajaxFormDie($msg, "error", array( "msg_response" => $msg));
                }
                $data['owner'] = owner;
                $data['user_id'] = login_id();
                $data['type'] = "sms";
                $data['class'] = serialize($sms);
                $data['next_run'] = $time;
                $data['remark'] = "Pending";
                $data['date'] = time();
                d()->insert("schedule", $data);
                $token = generate_session_token("sms");
                $msg = "Message Scheduled Successfully to Deliver On $new";
                ajaxFormDie($msg, "success", array("msg_response" => $msg, "session_token"=>$token));
            }

            $sent = $sms->send_sms();
            $token = generate_session_token("sms");

            $msg = "<b>Error Sending Message</b><br>Please contact support";

            if($sent['sent']){
                $amt = $sms->balance_source == "balance"?format_amount($sms->total_unit_used):$sms->total_unit_used. " Units";
                $scount = count($sent['count']['sent']);
                $msg = "<b>Message Sent Successfully</b> ($scount Numbers)";
                $msg .= "<br><b>Total Amount Used</b>: $amt";
                if(count($sent['count']['dnd']) > 0 && $route == 0){
                    $msg .= "<br><b>Error</b>: Could not deliver to the following numbers due to DND (<a href='javascript:void(0)' onclick='return whatisdnd()'>Click here to know what is DND</a>): ";
                    $msg .= implode(", ", $sent['count']['dnd']);
                    $msg .= "<br><b>Please choose the 'Deliver to DND Numbers' under the GATEWAY Route below to deliver Messages to DND numbers as well</b>";
                }
                ajaxFormDie("Message Sent Successfully", "success", array("session_token"=>$token, "msg_response"=>$msg, "previous_balance"=>format_amount(user_balance(null,"previous_balance"), -1,""). " Units"));
            }else{
                $msg = empty(getIndex($sent,"result"))?$msg:getIndex($sent,"result");
                ajaxFormDie("Error Sending Message. Please try again later", "error",  array("session_token"=>$token, "msg_response"=>$msg, "previous_balance"=>user_balance(null,"previous_balance"). " Units"));
            }
        }

        $message = array();

        if($param1 == "sent"){
            d()->where("sent_id", $param2);
            if(!is_admin()){
                d()->where("user_id", login_id());
            }

            $x = c()->get("recipient")->result_array();

            if(empty($x))
                ajaxFormDie("Message not found");

            $num = array();
            foreach($x as $row){
                $num[] = $row['phone'];
            }
            $message['recipient'] = implode(", ", $num);

            d()->where("id", $param2);
            $y = c()->get("sent")->row_array();
            $message['message'] = $y['message'];
            $message['sender'] = $y['sender_id'];
        }

        if($param1 == "draft"){
            d()->where("id", $param2);
            if(!is_admin()){
                d()->where("user_id", login_id());
            }

            $x = c()->get("draft")->row_array();

            if(empty($x))
                ajaxFormDie("Draft Message not found");

            $message['recipient'] = $x['recipient'];
            $message['message'] = $x['message'];
            $message['sender'] = $x['sender'];
            $message['id'] = $x['id'];
        }

        $page_data['message'] = $message;
        $page_data['page_name'] = 'message/bulksms';
        $page_data['page_title'] = "Send Bulk SMS";
        $this->load->view('backend/index', $page_data);
    }

    function history($user_id = "", $date1 = "", $date2 = "", $search = ""){
        rAccess("message_history");

        $search = empty($search)?"":utf8_decode(uri_decode($search));

        if($user_id == "search") {
            $search = uri_encode($this->input->post("keyword"));
            $user_id = $this->input->post("user_id");
            $date1 = parse_date($this->input->post("date1"));
            $date2 = parse_date($this->input->post("date2"));

            return return_function("history" . construct_url($user_id, $date1, $date2, $search));
        }


        $count = 0;

        d()->query("SET SESSION group_concat_max_len = 1000000");

        while(true) {

            if (!empty($date1)) {
                d()->where("date>=", strtotime($date1));
                d()->where("date<=", strtotime($date2));
            }

            $user_id = is_admin() ? $user_id : login_id();

            if (!empty($user_id)) {
                d()->where("recipient.user_id", $user_id);
            }


            if(!is_empty($search)){
                d()->group_start();
                d()->like("phone", $search);
                d()->or_like("message", $search);
                d()->or_like("sender_id", $search);
                d()->or_like("sender_id_dnd", $search);
                d()->group_end();
            }

            if(!empty(g("search")['value'])){
                $search = g("search")['value'];
                d()->group_start();
                d()->like("phone", $search);
                d()->or_like("message", $search);
                d()->or_like("sender_id", $search);
                d()->or_like("sender_id_dnd", $search);
                d()->group_end();
            }


            d()->where("recipient.owner", owner);
            d()->join("recipient", "recipient.sent_id = sent.id");

            if($count == 0){
                d()->select("sent_id,user_id,sender_id,sender_id_dnd,message,date,method,group_concat(concat(phone)) as numbers, sum(cost) as totalcost");
                d()->group_by("sent_id");
//                datatable_order("option=sent.date,recipient=phone,date=sent.date", "sent.date:desc","#,username");
                d()->order_by("sent.date", "DESC");
                d()->limit(empty(g("length"))?datatable_limit():g("length"));
                d()->offset(empty(g("start"))?0:g("start"));
                $page_data['history'] = d()->get("sent")->result_array();
            }elseif($count == 1) {
                if(empty($date1)){
                    d()->where("date>=", strtotime(date("d-m-Y")." 00:00:01"));
                    d()->where("date<=", strtotime(date("d-m-Y")." 23:59:59"));
                }
                d()->select_sum("cost");
                $page_data['total_cost'] = d()->get("sent")->row_array()['cost'];

            }else{
                d()->select("sent_id,user_id,sender_id,sender_id_dnd,message,date,method,group_concat(concat(phone)) as numbers, sum(cost) as totalcost");
                d()->group_by("sent_id");
                $page_data['history_count'] = d()->count_all_results("sent");
                break;
            }
            $count++;
        }
        $page_data['date1'] = empty($date1)?"":$date1;
        $page_data['date2'] = empty($date2)?"":$date2;
        $page_data['keyword'] = $search;
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'message/history';
        $page_data['page_title'] = "Message History";
        $this->load->view('backend/index', $page_data);
    }

 function schedule($param1 = "", $param2 = ""){
        rAccess("schedule");

        if($param1 == "delete"){
            d()->where("id", $param2);
            if(!is_admin())
                d()->where("user_id", login_id());
            c()->delete("schedule");
            ajaxFormDie("Deleted Successfully", "success");
        }

        $date1 = strtotime(date("d-m-Y")." 00:00:01");
        $date2 = strtotime(date("d-m-Y")." 23:59:59");
        $search = "";
        $user_id = is_admin()?$param1:"";

        if(post_set("search")){

            $search = $this->input->post("keyword");
            $user_id = $this->input->post("user_id");
            if(!empty($this->input->post("date1")) && !empty($this->input->post("date2"))){
                $date1 = strtotime(parse_date($this->input->post("date1")));
                $date2 = strtotime(parse_date($this->input->post("date2")));
            }else{
                $date1 = "";
                $date2 = "";
            }

            if(!is_empty($search)){
                d()->like("class", $search);
            }
        }

        if(!empty($date1)) {
            d()->where("date>=", $date1);
            d()->where("date<=", $date2);
        }else{
            d()->limit(50);
        }
        $history_again = false;
        history_again:

        if(!empty($user_id) && is_admin()){
            d()->where("user_id", $user_id);
        }else if(!is_admin()){
            d()->where("user_id", login_id());
        }


        $history = c()->get("schedule")->result_array();

        if(empty($history) && !post_set("search") && !$history_again){
            $history_again = true;
            d()->limit(20);
            goto history_again;
        }

        if($history_again && !empty($history)){
            $date1 = $history[count($history) - 1]['date'];
        }

        $page_data['date1'] = empty($date1)?"":date("d-M-Y h:i A",$date1);
        $page_data['date2'] = empty($date2)?"":date("d-M-Y h:i A",$date2);
        $page_data['keyword'] = $search;
        $page_data['user_id'] = $user_id;
        $page_data['schedule'] = $history;
        $page_data['page_name'] = 'message/schedule';
        $page_data['page_title'] = "Scheduled Messages";
        $this->load->view('backend/index', $page_data);
    }

    function draft($param1 = "", $param2 = ""){
        rAccess("draft");

        $date1 = strtotime(date("d-m-Y")." 00:00:01");
        $date2 = strtotime(date("d-m-Y")." 23:59:59");
        $search = "";
        $user_id = is_admin()?$param1:"";

        if(post_set("search")){

            $search = $this->input->post("keyword");
            $user_id = $this->input->post("user_id");
            if(!empty($this->input->post("date1")) && !empty($this->input->post("date2"))){
                $date1 = strtotime(parse_date($this->input->post("date1")));
                $date2 = strtotime(parse_date($this->input->post("date2")));
            }else{
                $date1 = "";
                $date2 = "";
            }

            if(!is_empty($search)){
                d()->group_start();
                d()->like("recipient", $search);
                d()->or_like("message", $search);
                d()->or_like("sender", $search);
                d()->group_end();
            }
        }

        if(!empty($date1)) {
            d()->where("date>=", $date1);
            d()->where("date<=", $date2);
        }else{
            d()->limit(50);
        }
        $history_again = false;
        history_again:

        $user_id = is_admin()?$user_id:login_id();

        if(!empty($user_id)){
            d()->where("user_id", $user_id);
        }


        d()->order_by("date", "DESC");

        $history = c()->get("draft")->result_array();

        if(empty($history) && !post_set("search") && !$history_again){
            $history_again = true;
            d()->limit(20);
            goto history_again;
        }

        if($history_again && !empty($history)){
            $date1 = $history[count($history) - 1]['date'];
        }

        $page_data['date1'] = empty($date1)?"":date("d-M-Y h:i A",$date1);
        $page_data['date2'] = empty($date2)?"":date("d-M-Y h:i A",$date2);
        $page_data['keyword'] = $search;
        $page_data['user_id'] = $user_id;
        $page_data['history'] = $history;
        $page_data['page_name'] = 'message/draft';
        $page_data['page_title'] = "Message History";
        $this->load->view('backend/index', $page_data);
    }

    function delete($param1 = ""){
        rAccess("delete_message_history");
        d()->where("sent_id", $param1);
        c()->delete("recipient");
        ajaxFormDie("Successfully Deleted", "success");
    }


    function report($sent_id = "", $user_id = ""){
        rAccess("message_history");
        if(!is_admin()){
            d()->where("user_id", login_id());
        }

        d()->where("sent_id", $sent_id);
        $recipient = c()->get("recipient")->result_array();


        $page_data['recipient'] = $recipient;
        $page_data['page_name'] = 'message/report';
        $page_data['page_title'] = "Delivery Report";
        $this->load->view('backend/index', $page_data);

    }

}
