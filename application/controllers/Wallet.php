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

class Wallet extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('billpayment');
        this()->load->library("PaymentMethods");
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    function recharge($amount = "", $method = ""){
        $_POST['amount'] = $amount;
        $_POST['send_amount'] = $amount;
        $_POST['method'] = $method;

        return return_function("fund/proceed/0/0");
    }

    function fund($param1 = "", $method = "", $amount = ""){
        rAccess("fund_wallet");


        if($param1 == "proceed"){
            $method = $this->input->post("method");
            $amount = parse_amount($this->input->post("amount"));
            $type = $this->input->post("type");

            if(!empty($type))
                return return_function("proceed");
        }

        $page_data['method'] = $method;
        $page_data['amount'] = $amount;

        $page_data['page_name'] = 'wallet/fund';
        $page_data['page_title'] = "Fund Wallet";
        $this->load->view('backend/index', $page_data);
    }

    function proceed($param1 = "", $param2 = ""){
        rAccess("fund_wallet");

        if(empty($_POST))
            return return_function("fund");

        $page_data['page_name'] = 'wallet/preview';
        $page_data['page_title'] = "Fund Wallet";
        $this->load->view('backend/index', $page_data);
    }

    function process_transaction($id = "", $requery_now = ""){


        $page_data['id'] = $id;
        $page_data['requery_now'] = $requery_now;
        $page_data['page_name'] = 'wallet/response';
        $page_data['page_title'] = "Fund Wallet";
        $this->load->view('backend/index', $page_data);
    }

    function notify($transaction_id = "", $param2 = ""){
        if($transaction_id == "crytocurrency")
            $transaction_id = "cryptocurrency";

        $this->transaction_notify($transaction_id, $param2);
    }

    function transaction_notify($transaction_id = "", $param2 = ""){
        $pg = new PaymentMethods();
        $pg->load_classes();

        if($transaction_id == "cryptocurrency"){
            $array['payment_method'] = $param2;
            $array['gateway'] = $param2;
        }else {
            d()->where("transaction_id", $transaction_id);
            d()->where("bill_type", "fund_wallet");
            d()->where("owner", owner);

            $array = c()->get("bill_history")->row_array();
        }
        if(!empty($array)){
            $method = $array['payment_method'];
            $type = $array['gateway'];
            if ($method == "atm" || $method == "bitcoin") {
                $func = "payment_" . $type;
            } else {
                $func = "payment_" . $method;
            }

            if(class_exists($func)) {
                $x = new $func($array);
                if (method_exists($x, "notify")) {
                    $x->notify();
                }
            }

        }

    }

    function call_payment_method($method = "", $class_name = "", $class_name2 = ""){
        $pg = new PaymentMethods();
        $pg->load_classes();

            if ($class_name == "atm" || $class_name == "bitcoin") {
                $func = "payment_" . $class_name2;
            } else {
                $func = "payment_" . $class_name;
            }

            if(class_exists($func)) {
                $x = new $func($this->input->post());
                if (method_exists($x, $method)) {
                    call_user_func_array(array($x, $method), array());
                }
            }

    }

    function transfer($param1 = ""){
        rAccess("transfer_fund");

        if($param1 == "proceed"){
            $receiver = $this->input->post("receiver");
            $amount = parse_amount($this->input->post("amount"));
            $this->load->library("user");
            $x = implode(",", default_login_column());
            $user = new User($receiver, $x);

            if(empty($user->get_user_id()))
                ajaxFormDie("Invalid Receiver Detail Provider");

            if(empty($amount))
                ajaxFormDie("Invalid Amount Specified");

            if($amount > user_balance()){
                ajaxFormDie("Insufficient Funds");
            }

            if($user->get_user_id() == login_id())
                ajaxFormDie("Cant transfer amount to yourself");

            update_user_balance($amount, false, false);

            update_user_balance($amount, true, true, $user->get_user_id());

            ajaxFormDie(format_wallet($amount)." Successfully transferred to '$receiver'", "success");
        }

        $page_data['page_name'] = 'wallet/transfer';
        $page_data['page_title'] = "Transfer Funds";
        $this->load->view('backend/index', $page_data);
    }



}
