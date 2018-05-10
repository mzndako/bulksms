<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 30-11-17
 * Time: 4:17 AM
 */

class my_payment_methods{
	public $name = "";
	public $setting_name = "";
	public $payment_method = "";
	public $payment_gateway = "";
	public $options = array();
	public $show_proceed = true;
	private $transaction_id = "";
	public $user_id = "";

	function get_setting($key, $fetchFromFounder = false){
        $owner = null;
	    if($this->use_reseller_gateway()){
            $founder = founder();
            if(!empty($founder)){
                $owner = $founder['owner'];
            }
        }

		if(!empty($this->payment_method))
			$name = $this->payment_method."_".$this->payment_gateway;
		else
			$name = $this->payment_gateway;

		return PaymentMethods::get_custom_setting($key, $name, $owner);
	}

	function set_setting($key, $value){
		$name = $this->payment_method."_".$this->payment_gateway;
		return PaymentMethods::set_custom_setting($key, $value, $name);
	}


	function get($key, $default = ""){
		$x = getIndex($this->options, $key, $default);
		if($x == "")
			return $default;
		return $x;
	}

	public function show(){
	}

	public function response(){

	}

	public function set_transaction_id($id){
		$this->transaction_id = $id;
	}

	public function save_transaction($data_ = array()){
		if(!empty($this->transaction_id))
			return $this->transaction_id;

		$this->transaction_id = generate_transaction_id();

		$trans = $this->process_transaction_fee();

		$data['owner'] = owner;
		$data['date'] = time();
		$data['user_id'] = empty($this->user_id)?login_id():$this->user_id;
		$data['bill_type'] = "fund_wallet";
		$data['transaction_id'] = $this->transaction_id;
		$data['status'] = "Pending Payment";
		$data['type'] = "Fund Wallet";
		$data['amount'] = $trans['amount'];
		$data['payment_method'] = $this->payment_method;
		$data['gateway'] = $this->payment_gateway;

		$data['transaction_fee'] = $trans['transaction_fee'];

		$data = array_merge($data, $data_);

		d()->insert("bill_history", $data);

		return $this->transaction_id;
	}

	public function update_transaction($data){
		$id = $this->save_transaction($data);

		d()->where("transaction_id", $id);
		d()->update("bill_history", $data);
	}

	public function process_transaction_fee($amount = 0){
		$amount = empty($amount)?round(parse_amount($this->get("amount")), 2, PHP_ROUND_HALF_UP):$amount;
		$tf = $this->get_setting("transaction_fee");
		$transaction_fee = 0;
		$total = $amount;

		if(!empty($tf)){
			$loop = explode(",", $tf);
			foreach($loop as $tf) {
				if (strpos($tf, "=") !== false){
					$x = explode("=", $tf);
					if(count($x) != 2)
						continue;
					$equa = $x[0];
					$amt = $x[1];
					if($amount >= $equa){
						$tf = $amt;
					}else{
						continue;
					}

				}
				$mytf = parse_amount($tf);
				if (strpos($tf, "%") !== false) {
					$ttff = round($amount / (1 - ($mytf / 100)), 2, PHP_ROUND_HALF_UP);
					$mytf = ($ttff- $amount);
				}
				$transaction_fee += $mytf;

			}//END OF LOOP

			$total = ($transaction_fee + $amount);
		}
		return array("amount"=>$amount, "transaction_fee"=>$transaction_fee, "total"=>$total);
	}

	public function notify(){

	}

	public function get_user_name(){
		return user_data("fname")." ".user_data("surname");
	}

	public function send_data($link, $post = null, $options = array(), $json = true){
		$ch = curl_init($link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		if(!empty($post)){
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
		}

		foreach($options as $key=>$value){
			curl_setopt( $ch, $key, $value );
		}

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		if(curl_error($ch)) {
			$response = curl_error($ch);
		}
		curl_close($ch);

		if(!$json)
			return $response;

		$array = json_decode($response, true);
		return $array;
	}

	public function status_code($status){
		switch(strtolower($status)){
			case "amount_different":
				return "Error: Amount is Different";
		}
		return $status;
	}

	function get_user_address(){
		d()->where("user_id", login_id());
		$array = c()->get("cryptocurrency")->row_array();

		return getIndex($array, "address");
	}

	function save_address($address){
		$data['user_id'] = login_id();
		$data['address'] = $address;
		$data['date'] = time();
		c()->insert("cryptocurrency", $data);
	}

	function bank_accounts(){
		$x = $this->get_setting("accounts");
		$array = explode("\n", $x);

		$banks = array();
		foreach($array as $value){
			$y = explode("=",$value);
			$bk = getIndex($y, 0);
			$no = getIndex($y, 1);
			$name = getIndex($y, 2);
			$banks[$bk]['bank'] = $bk;
			$banks[$bk]['account'] = $no;
			$banks[$bk]['name'] = $name;
		}
		return $banks;
	}
	function airtime_network(){
		$x = $this->get_setting("network");
		$array = explode(",", $x);

		return $array;
	}

	function use_reseller_gateway(){
	    if(!empty(pay()->payment_enabled($this->payment_method."_reseller"))){
	        return true;
        }
        return false;
    }

    function update_resellers($id){
        if(!$this->use_reseller_gateway()){
            return true;
        }


        d()->where("owner", owner);
        $reseller = d()->get("reseller")->row_array();

        if(empty($reseller['parent'])){
            return false;
        }

        d()->where("id", $id);
        $data = c()->get("bill_history")->row_array();

        if(empty($data['order_id'])){
            return false;
        }
        unset($data['id']);
        $recipient = "";

        while(!empty($reseller['owner'])){
            $owner = $reseller['owner'];
            $user_id = $reseller['user_id'];
            $username = c()->get_full_name($user_id, $owner);
            $p_trans_id = $data['transaction_id'];
            if(!empty(parse_amount($data['amount_credited']))){
                update_user_balance($data['amount_credited'], true, true, $user_id, false);
            }

            $data['user_id'] = $user_id;
            $data['owner'] = $reseller['parent'];
            $data['balance'] = user_balance($user_id, "balance");
            $data['transaction_id'] = generate_transaction_id(10, $reseller['owner']);
            $recipient .= "Through Reseller ".$username." ($p_trans_id) <br>";
            $data['recipient'] = $recipient;
            d()->insert("bill_history", $data);

            $reseller = reseller_owner($owner);
        }

    }

}