<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Class Cart
 * @property Payment_model $payment_model Cart module
 */
class Payment_model extends CI_Model {

    private $m_status = "payment_method_status";

    function __construct() {
        parent::__construct();

    }

    function methods($id = null){
        $methods = array("wallet"=>"Wallet", "atm"=>"ATM Card (Master, Verve Or Visa)", "bitcoin"=>"Bitcoin", "bank"=>"Cash/Bank Deposit", "internet"=>"Internet Bank Transfer", "mobile"=>"Mobile Banking", "airtime"=>"Airtime/Recharge Card");
        $return = $id === null?$methods:getIndex($methods,$id);
        return $return;
    }

    function get_enabled_methods(){
        $status = get_setting($this->m_status);
        $array = json_decode($status, true);
        $array = empty($array)?array():$array;
        $names = $this->get_updated_method_names();
        $y = array();
        $y['wallet'] = "Wallet (".format_wallet(user_balance(), -1).")";
        foreach($names as $key => $name){
            if(getIndex($array, $key) == 1){
                if($key == 1){
                    $name = "$name (".format_amount(user_data("balance",null, 0)).")";
                }
                $y[$key] = $name;
            }
        }
        return $y;
    }

    function payment_enabled($method_id = null){
        $status = get_setting($this->m_status);
        $array = json_decode($status, true);
        return getIndex($array, $method_id) == 1?true:false;
    }

    function save_method_status($payment_gateway, $st){
            $status = get_setting($this->m_status);
            $array = json_decode($status, true);
        $array = !empty($array)?$array:array();
        $array[$payment_gateway] = $st;
        $save = json_encode($array);
        set_setting($this->m_status, $save);
    }

    function change_method_names($names = array()){
        $save = json_encode($names);
        set_setting("payment_method_names", $save);
    }

    function get_updated_method_names($method_id = null){
        $names = get_setting("payment_method_names", "");
        $array = json_decode($names, true);
        $array = empty($array)?array():$array;
        $methods = $this->methods();
        foreach($array as $key => $name){
            if(isset($methods[$key])){
                $methods[$key] = $name;
            }
        }
        return $method_id == null?$methods:getIndex($methods, $method_id);
    }
}
