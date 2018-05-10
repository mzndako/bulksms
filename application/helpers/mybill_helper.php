<?php

class mybill{
	private $network;
	private $numbers;
	private $amount;
	private $data_plan;
	private $bill_type;
	private $bill_plan;
	private $user_id;
	public $charge = true;
	public $is_sender = true;
	private $owner;
	private $route = 0;
	private $type = "text";
	private $method = "desktop";
	private $gateways_array = array();
	private $cost = array();
	private $default_cost = array();
	private $reseller_cost = array();

	private $clubkonnect_client_id;
	private $clubkonnect_token;

	function __construct($owner = ""){
		$this->user_id = login_id();
		$this->owner = $owner === ""?owner:$owner;
		$this->clubkonnect_client_id = $this->get_setting("bill_client_id");
		$this->clubkonnect_token = $this->get_setting("bill_token");
	}

	function set_user($user){
		$this->user_id = $user;
	}

	function set_airtime($numbers, $amount, $network=""){
		$this->numbers = $numbers;
		$this->amount = $amount;
		$this->network = $network;
		$this->type = "airtime";
	}

	function set_dataplan($number, $network,  $plan){
		$this->numbers = $number;
		$this->network = $network;
		$this->data_plan = $plan;
		$this->type = "dataplan";
	}

	function set_bill($number, $type,  $plan){
		$this->numbers = $number;
		$this->bill_type = $type;
		$this->bill_plan = $plan;
		$this->type = "bill";
	}




	function total_cost(){
		$gateways = $this->gateways();
		$user_rate = $this->user_data("bill_rate");
		$default_rate = $this->get_setting("default_bill_rate");
		$total = 0;
		foreach($gateways as $id => $num){
			if(empty($user_rate)){
				$rate = $default_rate;
			}else{
				$rate = $user_rate;
			}
			$total += $this->cost($rate, $num);
		}

		return $total;
	}

	public function rate($convert_to_array = false, $remove_disabled = false){
		$default_rate = $this->user_data("bill_rate");
		if(empty($default_rate)){
			$default_rate = $this->get_setting("default_bill_rate");
		}
		d()->where("id", $default_rate);
		$bill = getIndex(d()->get("bill_rate")->row_array(), "bill", "");

		if($remove_disabled){
			$array = json_decode($bill, true);
			$array = empty($array)?array():$array;
			$new_array = array();
			foreach($array as $bill_type => $row1){
				foreach($row1 as $type => $price){
					if($bill_type == "airtime"){
						if($price != "-1") {
							$new_array[$bill_type][$type] = $price;
						}
					}else if(is_array($price)){
						foreach($price as $k => $v){
							if($v != "-1"){
								$new_array[$bill_type][$type][$k] = $v;

							}
						}
					}
				}
			}
			$bill = json_encode($new_array);
		}

		if($convert_to_array){
			$array = json_decode($bill, true);
			return $array;
		}
		return $bill;
	}


	private $bill_gateway_id = 0;
	private function cost($rate, $numbers){


		if(empty($rate) || is_commission_system())
			$rate = $this->get_setting("default_bill_rate");

		if(is_numeric($rate) && $rate > 0) {
			d()->where("id", $rate);
			$rate = getIndex(d()->get("bill_rate")->row_array(), "bill", "");
		}

		$bill = json_decode($rate, true);

		if(empty($bill)){
			return false;
		}


		if(!is_array($numbers))
			$numbers = explode(",", $numbers);

		$total = 0;
		$amount = 0;
		foreach($numbers as $num){
			if($this->type == "airtime"){
				$airtime = getIndex($bill, "airtime");
				$network = empty($this->network)?network($num):$this->network;
				$rate = getIndex($airtime, $network);
				$amount = $this->airtime_percentage($this->amount, $rate);
			}

			if($this->type == "dataplan"){
				$plan = getIndex($bill, "dataplan");
				$amount= $this->parse_amount(getIndex($plan, $this->network.",".$this->data_plan));
			}

			if($this->type == "bill"){
				$mybill = getIndex($bill, "bill");
				$amount = $this->parse_amount(getIndex($mybill, $this->bill_type.",".$this->bill_plan));

			}
			$total += $amount;
			$this->cost[$num] = $amount;
		}

		return $total;

	}

	function default_cost($numbers, $default = "default_bill_rate"){

		$rate = $this->get_setting($default);

		if(is_numeric($rate) && $rate > 0) {
			d()->where("id", $rate);
			$rate = getIndex(d()->get("bill_rate")->row_array(), "bill", "");
		}

		$bill = json_decode($rate, true);

		if(empty($bill)){
			return false;
		}


		if(!is_array($numbers))
			$numbers = explode(",", $numbers);

		$total = 0;
		$amount = 0;
		foreach($numbers as $num){
			if($this->type == "airtime"){
				$airtime = getIndex($bill, "airtime");
				$network = empty($this->network)?network($num):$this->network;
				$rate = getIndex($airtime, $network);
				$amount = $this->airtime_percentage($this->amount, $rate);
			}

			if($this->type == "dataplan"){
				$plan = getIndex($bill, "dataplan");
				$amount= $this->parse_amount(getIndex($plan, $this->network.",".$this->data_plan));
			}

			if($this->type == "bill"){
				$mybill = getIndex($bill, "bill");
				$amount = $this->parse_amount(getIndex($mybill, $this->bill_type.",".$this->bill_plan));

			}
			$total += $amount;
			$this->default_cost[$num] = $amount;
		}

	}

	private function parse_amount($amount){
		return preg_replace("/[^\d.-1]/", "", $amount);;
	}

	public function airtime_percentage($amount, $rate){
		if($rate == "-1")
			return 0;

		$r = $this->parse_amount($rate);

		if(empty($r))
			return 0;

		if(strpos($rate, "%") !== false){
			$price = round($amount * ($r/100), 2);
			if(strpos($rate, "-") !== false){
				$price += $amount;
			}else{
				$price = $amount - $price;
			}

		}else{
			if(strpos($rate, "-") !== false){
				$price = $amount + $r;
			}else{
				$price = $amount - $r;
			}
		}

		return $price;




	}

	private function filter_numbers(){
		$numbers = $this->numbers;
		$numbers = preg_replace("/[^\d]/",",",$numbers);
		$text = "";
		$array = explode(",", $numbers);
		foreach ($array as $key => $value) {
			$value = trim($value);
			$len = strlen($value);

			if($this->type == "bill"){
				if($len > 4 && $len < 20)
					$text .= ",$value";
				continue;
			}

			if(empty($value) || $len < 10 || $len > 14)
				continue;

			$first = $value[0];
			$second = $value[1];

				$pos = strpos($value, "0");
				$pos1 = strpos($value, "234");

				if($pos===0 && $len == 11){
					$text .= ",$value";
				}else if($pos1===0 && $len == 13){
					$text .= ",0".substr($value, 3);
				}else if($len == 10 && $first > 6 && $second < 3){
					$text .= "0$value";
				}
		}

		return substr($text, 1);
	}

	private function gateways(){


//		$gateway = get_setting("default_bill_gateway");

		$numbers = explode(",",$this->filter_numbers());

		if($this->is_reseller()){
			$data['reseller'] = $numbers;
		}else{
			$data[1] = $numbers;
		}

		return $data;

		if(empty($gateway)){
			return array();
		}


		$mygateways = array();

		d()->where("owner", $this->owner);
		d()->where("route !=", "");
		d()->where("active", 1);
		$rows = d()->get("bill_gateway")->result_array();

		$route = array();
		foreach($rows as $row){
			if(empty($row['route']))
				continue;
			$rt = preg_replace("/[^\d-]/",",", $row['route']);
			$array = explode(",", $rt);
			foreach($array as $x){
				if(empty($x))
					continue;
				$route[$row['id']][] = $x;
			}
		}

		foreach($numbers as $num){
			$found = false;
			foreach($route as $gid => $array){
				foreach($array as $rt){
					if(strpos($num, $rt) === 0)
						$found = $gid;
				}
			}
			if($found === false){
				$mygateways[$gateway][] = $num;
			}else{
				$mygateways[$found][] = $num;
			}
		}

		$this->gateways_array = $mygateways;
		return $mygateways;
	}

	function select_gateway($num){
		$bill = json_decode($this->get_setting("bill_gateway"), true);
		if(empty($bill))
			return 0;

		$gid = 0;
		if($this->type == "airtime"){
			$airtime = getIndex($bill, "airtime");
			$network = empty($this->network)?network($num):$this->network;
			$gid = getIndex($airtime, $network);
		}

		if($this->type == "dataplan"){
			$plan = getIndex($bill, "dataplan");
			$gid = getIndex($plan, $this->network.",".$this->data_plan);
		}

		if($this->type == "bill"){
			$mybill = getIndex($bill, "bill");
			$gid = getIndex($mybill, $this->bill_type.",".$this->bill_plan);
		}
		$this->bill_gateway_id = $gid;
		return $gid;
	}

	function buy_now(){

		d()->where("owner", $this->owner);
		$mine = d()->get("reseller")->row_array();
		if(empty($mine)){
			return $this->failed("Invalid Owner ID");
		}
		$my_user_id = $mine['user_id'];
		$my_reseller_owner = $mine['parent'];

		$gate = get_arrange_id("bill_gateway", "id");

		$dr = $default_rate = $this->user_data("bill_rate");
		if(empty($default_rate)){
			$default_rate = $this->get_setting("default_bill_rate");
		}


		$gateways = $this->gateways();
		$result = array();
		$from = array();
		foreach($gateways as $gid => $numbers){

			if($gid == "reseller"){

				d()->where("owner", $my_reseller_owner);
				$reseller = d()->get("reseller")->row_array();
				if(empty($reseller)){
					return $this->failed("Invalid Reseller ID -> $my_reseller_owner");
				}

				$rate = $default_rate;

				$cost = $this->cost($rate, $numbers);
				$this->default_cost($numbers);

				$bal = $this->user_balance();

				if($bal < $cost){
					$result[] = $this->failed($this->is_sender?"1111":"2222");
				}else{
					$this->deduct_unit($cost);

					$bb = new mybill($my_reseller_owner);
					$bb->set_user($my_user_id);
					$bb->is_sender = false;
					if($this->type == "airtime"){
						$bb->set_airtime($this->numbers, $this->amount, $this->network);
					}
					if($this->type == "dataplan"){
						$bb->set_dataplan($this->numbers, $this->network, $this->data_plan);
					}
					if($this->type == "bill"){
						$bb->set_bill($this->numbers, $this->bill_type, $this->bill_plan);
					}

					$response = $bb->buy_now();
					if($response['sent']){
						$this->reseller_cost = $response['from']['reseller_cost'];
						foreach($response['from']['all'] as $from){
							$this->process_response($from['array'], $from['num'], $from['network'], $from['gateway']);
						}
					}else{
						$this->add_unit($cost);
					}
					$response['from']['reseller_cost'] = $this->cost;
					return $response;
				}
			}else{

				$rate = $default_rate;
				$cost = $this->cost($rate, $numbers);
				$bal = $this->user_balance();

				if($bal < $cost){
					$result[] = $this->failed($this->is_sender?"1111":"2222");
				}else{
					$billgateway = new Billpayment();
					foreach($numbers as $num){
							$network = empty($this->network)?network($num):$this->network;
							$cost = $this->cost($rate, $num);
							$this->default_cost($num, "cost_bill_rate");
							$bal = $this->user_balance();
							$gateway = "";
							if($cost > $bal){
								$array = array();
							}else{
								$this->deduct_unit($cost);
								$gateway = $this->select_gateway($num);
								$billgateway->set_gateway($gateway);
								$billgateway->set_mybill_class($this, array("number"=>$num, "amount"=>$this->amount, "network"=>$this->network, "type"=>$this->type, "data_plan"=>$this->data_plan, "bill_plan"=>$this->bill_plan, "bill_type"=>$this->bill_type));
								$array = $billgateway->connect();
							}
							$res = $this->process_response($array, $num, $network, $gateway);
							$result[] = $res['status'];
							$from[] = array("array"=>$res['status'], "num"=>$num, "network"=>$network, "gateway"=>$gateway);
							if(!empty($array['send_mail'])){
								$send_mail = $array['send_mail'];
								$html = $send_mail['html'];
								$tras_id = $res['data']['transaction_id'];
								$id = $res['data']['id'];
								$html .= "<br><br><a style='color:green' href='http://quicksms1.com/bill/request/$tras_id/$id/accept'>APPROVE</a>";
								$html .= "<br><br><a style='color:red' href='http://quicksms1.com/bill/request/$tras_id/$id/refund'>CANCEL AND REFUND</a>";
								send_mail($html,$send_mail['subject'] , $send_mail['to'], "info@quicksms1.com");
							}
					 }

				}//END OF ELSE FOR if ACCOUNT BALANCE IS SUFFICIENT
			} //END OF ELSE FOR IF GATEWAY ID = RESELLER

		} //END OF FOREACH


		$finals = array();
		$sent = false;
		foreach($result as $res){
			if(getIndex($res, "sent", false))
				$sent = true;
			$finals = array_merge($finals, $res);
		}

		$finals['sent'] = $sent;
		$finals['from'] = array("all"=>$from, "reseller_cost"=>$this->cost);
		return $finals;
	}

	function update_current_status($array){


		$billgateway = new Billpayment();
		$billgateway->set_gateway($array['gateway']);
		$billgateway->set_mybill_class($this, $array);

		$array = $billgateway->query();

		return $array;
	}
	private function connect($sendURL){
		$ch = curl_init($sendURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		if(curl_error($ch)) {
			$response = curl_error($ch);
		}
		curl_close($ch);
		return $response;
	}

	function reseller_id(){
//	return 1;
		d()->where("owner", $this->owner);
		$mine = d()->get("reseller")->row_array();
		return getIndex($mine, "parent");
	}



	function is_reseller(){
		return empty($this->reseller_id())?false:true;
	}

	function is_owner(){
		return empty($this->reseller_id())?true:false;
	}

	private function jdecode($string){
		$x = json_decode($string,true);
		return $x;
	}
	private function process_response($array, $num, $network = "", $gateway = ""){
		$data['owner'] = $this->owner;
		$data['date'] = time();
		$data['user_id'] = $this->user_id;
		$data['network'] = $network;
		$data['recipient'] = $num;
		$data['bill_type'] = $this->type;
		$data['gateway'] = $gateway;
		$data['transaction_id'] = generate_transaction_id(10,$this->owner);

		if($this->type == "airtime"){
			$data['type'] = format_amount($this->amount,-1)." Credit";
//			$data['amount'] = $this->amount;
			$data['amount'] = $this->cost[$num];
		}

		if($this->type == "dataplan"){
			$data['type'] = bill()->convert_to_mb($this->data_plan);
			$data['amount'] = $this->cost[$num];
		}

		if($this->type == "bill"){
			$bb = bill()->bill_payment_rate()["bill"];
			$name = getIndex($bb, "{$this->bill_type},{$this->bill_plan},name");
			$data['type'] = ucwords($this->bill_type).": $name";
			$data['amount'] = $this->cost[$num];
		}


		$commission = 0;

		if($this->is_reseller()) {
			$profit = $data['amount'] - getIndex($this->reseller_cost, $num, 0);
			$commission = $data['amount'] - getIndex($this->default_cost, $num, 0);
		}else{
			$profit = $data['amount'] - getIndex($this->default_cost, $num, 0);
		}


		$status = getIndex($array, "status");
		$data['status'] = $status;
		$data['status_code'] = getIndex($array, "statuscode");
		$orderid = empty($array['orderid'])?$data['transaction_id']:$array['orderid'];
		$array['orderid'] = $orderid;
		$data['order_id'] = getIndex($array, "orderid");
		$data['recipient'] = $num;

		if($status == "ORDER_ONHOLD" || $status == "ORDER_COMPLETED" || $status == "ORDER_RECEIVED"){
			$array['sent'] = true;
			$array['result'] = "Successfully Sent";
			if(is_commission_system()){
				$data['commission'] = $commission;
				$this->add_commission($commission);
			}
			$data['profit'] = $profit;
		}else{
			$this->add_unit($this->cost[$num]);
			$data['amount'] = 0;
			$array['sent'] = false;
			$array['result'] = empty($status)?"Error Performing Transaction":bill()->errors($status, $data['status_code']);
		}
		$data['balance'] = $this->user_balance();

		d()->insert("bill_history", $data);
		$data['id'] = d()->insert_id();
		return array("status"=>$array, "data"=>$data);
	}


	private function translate($code){
		switch($code){
			case "1111":
			return "Insufficient Balance. Please Recharge Your account";
			case "2222":
			return "Gateway Error: 2222";
		}
	}

	public function get_setting($key){
		return get_setting($key, "", $this->owner);
	}

	public function set_setting($key, $value){
		return set_setting($key, $value, $this->owner);
	}

	private function add_unit($unit){
		if(!$this->charge)
			return;
		d()->where("id", $this->user_id);
		d()->set("balance", "balance + $unit", false);
		d()->limit(1);
		d()->update("users");
	}

	private function add_commission($amount){
		if(!$this->charge)
			return;
		d()->where("id", $this->user_id);
		d()->set("commission", "commission + $amount", false);
		d()->limit(1);
		d()->update("users");
	}

	private function deduct_unit($unit){
		if(!$this->charge)
			return;
		d()->where("id", $this->user_id);
		d()->set("balance", "balance - $unit", false);
		d()->limit(1);
		d()->update("users");
	}

	private function user_data($field = null){
		d()->where("id", $this->user_id);
		$user = d()->get("users")->row_array();

		if($field === null)
			return $user;

		return getIndex($user, $field);
	}

	function user_balance(){
		return (Float) $this->user_data("balance", null);
	}

	private function failed($result){
		return array("sent"=>false, "result"=>$result);
	}

	private function success($result){
		return array("sent"=>true, "result"=>$result);
	}

	private function get_string_between($string, $start, $end){
		$r = explode($end, $string);
		if (isset($r[0])){
			$r = end(explode($start, $r[0]));
			if ((stripos($r,'http') !== false)){
				$r = end(explode('?', $r));
			}
			return $r;
		}
		return '';
	}



	private	function reason($value){
		$value = str_replace("_"," ",strtolower($value));
		switch ($value){
			case "order completed": return "Successfully Completed";
			case "delivered": case "deliverd": case "delivrd": return 1;
			case "undelivered": case "undelivrd": case "undeliv": return 2;
			case "expired": case "expird": return 3;
			case "rejected": case "rejectd": return 4;
			case "invalid no.": return 5;
			case "smsc expired": return 6;
			case "not sent": return 7;
			case "no report": return 8;
			case "dnd": return 9;
			default: return -1;
		}
	}


}