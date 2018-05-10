<?php

/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 28-09-17
 * Time: 10:12 PM
 */
class PaymentMethods
{



	private $init = "payment_gateway_settings_";
	private $options = array();
	private $method_id = "";
	private $mybill;
	public $payment_path = __DIR__."/payment_methods";

	function atm_methods(){
		include __DIR__."/payment_methods/atm/config.php";
		return $config;
	}

	function set_method_id($method){

	}

	function bitcoin_methods(){
		include __DIR__."/payment_methods/bitcoin/config.php";
		return $config;
	}

	function load_classes(){
		safer_include($this->payment_path."/my_payment_methods.php");

		foreach($this->atm_methods() as $key => $config){
			$file = $this->payment_path."/atm/{$key}.php";
			safer_include($file);
		}
		foreach($this->bitcoin_methods() as $key => $config){
			$file = $this->payment_path."/bitcoin/{$key}.php";
			safer_include($file);
		}
		$array = scandir($this->payment_path);
		foreach($array as $row){
			if(strpos($row, ".php") !== false){
				safer_include_once($this->payment_path."/$row");
			}
		}
	}


	function save_settings($key, $value){
		return save_setting($this->init."$key", $value);
	}

	function get_setting($key, $default = ""){
//		$founder = founder();
		return get_setting($this->init."$key", $default);
	}

	function is_enabled($key, $reseller_enable_key = ""){

	    $rEnabled = false;
	    if(is_reseller() && !empty($reseller_enable_key) && !empty(pay()->payment_enabled($reseller_enable_key))){
	        $rEnabled = true;
        }

		$x = get_setting($this->init."$key");

		if(empty($x) || $rEnabled){
		    if($rEnabled){
                $founder = founder();
                $x = get_setting($this->init."$key", "", $founder['owner']);
                return empty($x)?true:false;
            }
			return true;
		}

		return false;
	}

	static function get_custom_setting($key, $method_id = "", $owner = null){
		$method_id = empty($method_id)?$method_id:"{$method_id}_";
		return get_setting("payment_gateway_settings_".$method_id."$key", "", empty($owner)?owner:$owner);
	}

	static function set_custom_setting($key, $value, $method_id = "", $owner = null){
		$method_id = empty($method_id)?$method_id:"{$method_id}_";
		return set_setting("payment_gateway_settings_".$method_id."$key", $value, empty($owner)?owner:$owner);
	}
}

