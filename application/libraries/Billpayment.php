<?php

/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 28-09-17
 * Time: 10:12 PM
 */
class Billpayment
{

	static function bills($id = null){
		$bills = array(1=>"MTN", 2=>"GLO", 3=>"AIRTEL", 4=>"9 MOBILE");
		return $id == null?$bills:$bills[$id];
	}

	function bill_gateway($id = null){
		$bill_gateway = array("1"=>"Email", "2"=>"Club Konnect");
		if(is_mz()){
			$bill_gateway[3] = "Topup Africa";
		}
		return $id === null?$bill_gateway:getIndex($bill_gateway, $id);
	}

	private $gateway_id = 0;
	private $options = array();
	private $mybill;

	function set_gateway($gateway_id){
		$this->gateway_id = $gateway_id;
	}

	function set_mybill_class(mybill $mybill, $array = array()){
		$this->mybill = $mybill;
		$this->options = $array;
	}

	private function get_option($key){
		return getIndex($this->options, $key, "");
	}

	function connect(){
		if(empty($this->gateway_id))
			return array();

		$filename = __DIR__."/bill_gateway_library/".strtolower(str_replace(" ","_", $this->bill_gateway($this->gateway_id)))."/connect.php";
		if(!file_exists($filename))
			return false;

		return include $filename;
	}

	function query(){
		if(empty($this->gateway_id))
			return array();

		$filename = __DIR__."/bill_gateway_library/".strtolower(str_replace(" ","_", $this->bill_gateway($this->gateway_id)))."/query.php";

		if(!file_exists($filename))
			return false;

		return include $filename;
	}


	function config(){
		include __DIR__."/bill_gateway_library/".strtolower(str_replace(" ","_", $this->bill_gateway($this->gateway_id)))."/config.php";
		return $config;
	}

	function get_mysetting($key){
		$key = "bill_gateway_".$this->gateway_id."_".$key;
		if(empty($this->mybill))
			return get_setting($key);

		return $this->mybill->get_setting($key);
	}

	function set_mysetting($key, $value){
		$key = "bill_gateway_".$this->gateway_id."_".$key;
		if(empty($this->mybill))
			return save_setting($key, $value);

		return $this->mybill->set_setting($key, $value);
	}



}

