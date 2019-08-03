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

class Bill extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('billpayment');
        rAccess("login");

    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    function proceed_to_payment($amount = ""){

    }
    function buy_airtime($param1 = "", $param2 = "", $param3 = ""){
        rAccess("buy_airtime");

        if(post_set("recipients")){
            $numbers = $this->input->post("recipients");
            $amount = parse_amount($this->input->post("amount"));
            $network = !empty($this->input->post("autodetect"))?"":$this->input->post("network");

            if($this->input->post("method") != "wallet"){
                redirect(url("wallet/recharge".construct_url($amount, $this->input->post("method"))), "Please proceed with payment");
            }

            if(empty($numbers))
                ajaxFormDie("Recipient Number can not be empty");

            if(empty($amount))
                ajaxFormDie("Invalid Amount Specified");

            if($amount < 100){
                ajaxFormDie("Amount can not be less than N100");
            }

            $mybill = new mybill();
            $mybill->set_airtime($numbers, $amount, $network);

            $balance = (Float) user_data("balance", null, 0);
            if($mybill->total_cost() > $balance)
                ajaxFormDie("Insufficient Funds in the wallet");
            $sent = $mybill->buy_now();

            if($sent['sent'])
                s()->set_flashdata('flash_message',"Successful");
            else
                s()->set_flashdata('flash_message',"Error: ".$sent['result']);

        }

        $page_data['page_name'] = 'bill/buy_airtime';
        $page_data['page_title'] = "Airtime";
        $this->load->view('backend/index', $page_data);
    }

    function buy_dataplan($param1 = "", $param2 = "", $param3 = ""){
        rAccess("buy_dataplan");

        if(post_set("recipients")){
            $numbers = $this->input->post("recipients");
            $network = $this->input->post("network");
            $dataplan = $this->input->post("dataplan");

            if(empty($numbers))
                ajaxFormDie("Recipient Number can not be empty");

            if(empty($network))
                ajaxFormDie("Please select a valid network");

            if(empty($dataplan))
                ajaxFormDie("Please select a dataplan");


            $mybill = new mybill();
            $mybill->set_dataplan($numbers, $network, $dataplan);

            $balance = (Float) user_data("balance", null, 0);

            if($this->input->post("method") != "wallet"){
                redirect(url("wallet/recharge".construct_url($mybill->total_cost(), $this->input->post("method"))), "Please proceed with payment");
            }

            if($mybill->total_cost() > $balance)
                ajaxFormDie("Insufficient Funds in the wallet");

            $sent = $mybill->buy_now();

            if($sent['sent'])
                s()->set_flashdata('flash_message',"Successful");
            else
                s()->set_flashdata('flash_message',"Error: ".$sent['result']);

        }

        $page_data['page_name'] = 'bill/buy_dataplan';
        $page_data['page_title'] = "DataPlan";
        $this->load->view('backend/index', $page_data);
    }

    function buy_epins($param1 = "", $param2 = "", $param3 = ""){
        rAccess("buy_epins");

        if(post_set("epin")){
            $quantity = $this->input->post("quantity");
            $epin_type = $this->input->post("epin_type");


            if(empty($quantity))
                ajaxFormDie("Quantity can not be empty");

            if(empty($epin_type))
                ajaxFormDie("Please select a pin type");

            d()->where("id", $epin_type);
            $array = c()->get("epins_category")->row_array();


            if(empty($array))
                ajaxFormDie("Invalid Epin Type selected");

            //Fetch the main category
            d()->where("id", $array['parent_id']);
            $row = c()->get("epins_category")->row_array();
            $category_name = $row['name'];

            $cost = parse_amount($array['amount']) * $quantity;

            if($cost > user_balance())
                ajaxFormDie("Insufficient Balance");

            d()->where("category", $epin_type);
            d()->where("date_used", 0);
            $remainder = c()->count_all("epins");

            if($quantity > $remainder){
                ajaxFormDie("Low stock Value. We only have $remainder in stock.<br>Please enter lower than that");
            }

            //Save to bill history
            $type_name = "$category_name ".$array['name']." E-Pin(s)";
            $bill['bill_type'] = "epin";
            $bill['type'] = $type_name;
            insert_history($bill);
            $bill_id = d()->insert_id();

            //Mark purchase pins active
            d()->where("category", $epin_type);
            d()->where("date_used", 0);
            $data['user_id'] = login_id();
            $data['date_used'] = time();
            $data['bill_history_id'] = $bill_id;
            c()->limit($quantity);
            c()->update("epins", $data);


            //Count all successfully purchased pins
            d()->where("bill_history_id", $bill_id);
            $result = c()->get("epins")->result_array();
            $bought = count($result);
            $amount = parse_amount($array['amount']) * $bought;

            //Update user balance when amount is not empty
            if(!empty($amount)){
                update_user_balance($amount, false);
            }

            //Update user history
            $update['type'] = "$bought; $type_name";
            $update['amount'] = $amount;
            $update['balance'] = user_balance();
            //Calculate the profit if the cost price is set
            if(!empty(parse_amount($array['cost_price']))){
                $cost_price = parse_amount($array['cost_price']) * $bought;
                $profit = $amount - $cost_price;
                $update['profit'] = $profit;
            }
            d()->where("id", $bill_id);
            c()->update("bill_history", $update);

            s()->set_flashdata('flash_message',"Successful<br>Check History Below to view pins");

        }

        $page_data['page_name'] = 'bill/buy_epins';
        $page_data['page_title'] = "E-Pins";
        $page_data['include_header'] = false;
        $this->load->view('backend/index', $page_data);
    }

    function view_epins($param1 = ""){
        rAccess("buy_epins");


        $page_data['bill_id'] = $param1;
        $page_data['page_name'] = 'epins/view_paid_epins';
        $page_data['page_title'] = "View E-Pins";
        $this->load->view('backend/default/load', $page_data);
    }

    function pay($param1 = "", $param2 = "", $param3 = ""){
//        dstv_bill
        if(post_set("recipients")){
            $numbers = $this->input->post("recipients");
            $bill_type = $this->input->post("bill");
            $bill_plan = $this->input->post("bill_type");

            if(empty($numbers))
                ajaxFormDie("Recipient Number can not be empty");

            if(empty($bill_type))
                ajaxFormDie("Please select a subscription");

            if(empty($bill_plan))
                ajaxFormDie("Please select a plan");

            $mybill = new mybill();
            $mybill->set_bill($numbers, $bill_type, $bill_plan);


            if($this->input->post("method") != "wallet"){
                redirect(url("wallet/recharge".construct_url($mybill->total_cost(), $this->input->post("method"))), "Please proceed with payment");
            }

            $balance = (Float) user_data("balance", null, 0);
            if($mybill->total_cost() > $balance)
                ajaxFormDie("Insufficient Funds in the wallet");

            $sent = $mybill->buy_now();

            if($sent['sent'])
                s()->set_flashdata('flash_message',"Successful");
            else
                s()->set_flashdata('flash_message',"Error: ".$sent['result']);

        }

        $page_data['param1'] = $param1;
        $page_data['page_name'] = 'bill/buy_bill';
        $page_data['page_title'] = "Pay Dstv, GoTv and Startimes - Instant Activation";
        $this->load->view('backend/index', $page_data);
    }

    function history($bill_type = "",$trans_type = "", $user_id = "", $search = "", $start_date = "", $end_date = ""){

        $page_data['date1'] = $start_date;
        $page_data['date2'] = $end_date;
        $page_data['user_id'] = $user_id;

        $page_data['bill_type'] = $bill_type;
        $page_data['trans_type'] = $trans_type;

        $history = array();

        $page_data['page_name'] = 'bill/history';

        if($bill_type == "search"){
            $trans_type = $this->input->post("trans_type");
            $bill_type = $this->input->post("bill_type");
            $user_id = $this->input->post("user_id");
            $search = uri_encode($this->input->post("search"));
            $date1 = parse_date($this->input->post("date1"));
            $date2 = parse_date($this->input->post("date2"));

            return return_function("history".construct_url($bill_type,$trans_type,$user_id,$search,$date1,$date2));
        }

        $count = 0;
        $search = trim(uri_decode($search));
        $page_data['search'] = $search;
        while(true) {
            if (!empty($trans_type)) {
                if ($trans_type == "all_bill") {
                    $b = array("airtime", "dataplan", "bill");
                    d()->where_in("bill_type", $b);
                } else {
                    d()->where("bill_type", $trans_type);
                }
            }

            if (!empty($bill_type)) {
                d()->where('bill_type', $bill_type);
            }

            if (!empty($page_data['user_id']) && is_admin()) {
                d()->where('user_id', $page_data['user_id']);
            } else if (!is_admin()) {
                d()->where("user_id", login_id());
            }

            if (!empty($start_date) || !empty($end_date)) {
                d()->where('date >=', strtotime($start_date));
                d()->where('date <=', strtotime($end_date));
            }

            if (!empty($search)) {
                d()->group_start();
                d()->like('transaction_id', $search);
                d()->or_like('network', $search);
                d()->or_like('recipient', $search);
                d()->or_like('status', $search);
                d()->or_like('remark', $search);
                d()->group_end();
            }

            d()->order_by("date", "DESC");

            if($count == 0){

                d()->limit(empty(g("length"))?datatable_limit():g("length"));
                d()->offset(empty(g("start"))?0:g("start"));
                $history = c()->get("bill_history")->result_array();
            }else{
                $history_count = c()->count_all("bill_history");
                break;
            }

            $count++;
        }
//            d()->order_by("date", "DESC");
//            d()->where('date >=',strtotime("01-".date("m-Y")));
//            d()->where('date <=',strtotime("31-".date("m-Y")));
//            $history = c()->get("bill_history")->result_array();



        $page_data['trans_type'] = $trans_type;
        $page_data['is_search'] = !empty($bill_type)?"":true;
        $page_data['history_bill_type'] = $bill_type;

        $page_data['bill_history'] = $history;
        $page_data['bill_history_count'] = $history_count;

        $page_data['page_title'] = "Transaction History";
        $this->load->view('backend/index', $page_data);
    }

    function request($transaction_id = "", $id = "", $action = "", $reason = ""){

        if(empty($transaction_id) || empty($id) || empty($action)){
            die("Invalid Request");
        }

        d()->where("transaction_id", $transaction_id);
//        d()->where("id", $id);
        d()->where_in("bill_type", array("airtime","dataplan", "bill"));
        $row = d()->get("bill_history")->row_array();

        if(empty($row)){
            die("Invalid Transaction ID");
        }

        if($action == "accept"){
            if(empty($reason)){
                print <<<eof
<script>
    if(confirm('Approve Transaction?')){
        var x = "yes";
    }else{
        var x = "no";
    }
        window.location = window.location + "/"+ x;
</script>
eof;

            }else if($reason == "yes") {

                d()->where("id", $row['id']);
                d()->update("bill_history", array("status" => "ORDER_PROCESSING", "remark" => "Successful"));
                print "<h1 style='color: green;'>APPROVED</h1>";
            }else{
                print "Not Processed";
            }
            die();
        }else if($action == "refund"){
            if(empty($reason)){
                print <<<eof
<script>
    if(confirm('Cancel and Refund User?')){
        var x = prompt("Enter Reason for Failure");
        window.location = window.location + "/"+ encodeURI(x);
    }else{
        window.close();
    }
</script>
eof;
die();

            }
            if($row['status'] == "ORDER_CANCELLED" || $row['status'] == "ORDER_ONHOLD"){
                die("Already Marked as rejected". $row['status']);
            }

            if($row['status'] != "ORDER_RECEIVED"){
                die("Order has already been processed. Current Status ".$row['status']);
            }
            $data = array("status"=>"ORDER_ONHOLD", "remark"=>$reason."<br><i style='color: red'>Refunded</i>");
            if(empty($row['order_id']) || $row['order_id'] == -1){
                $data['order_id'] = $row['transaction_id'];
            }
            print_r($row);
            d()->where("id", $row['id']);
            d()->update("bill_history",$data);
            print "<h1 style='color: red;'>CANCELLED</h1>$reason";
die();

        }

    }







}
