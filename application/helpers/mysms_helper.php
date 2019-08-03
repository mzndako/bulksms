<?php

class sms{
	private $message;
	private $recipient;
	private $filtered_recipient;
	private $sender;
	private $dnd_sender = "";
	private $user_id;
	public $is_sender = true;
	public $is_flash = false;
	public $charge = true;
	private $owner;
	private $route = 0;
	private $type = "text";
	public $method = "desktop";
	private $gateways_array = array();
	public $number_format = "international";
	public $justnigeria = false;
	public $balance_source = "balance";
	public $translate = true;
	private $temp_numbers = array();
	public $testing = false; //VERY IMPORTANT
	public $reset = false;
	public $encodeOnSerialize = false;
	public $trim_sender_id = true;
	private $reseller_cost = 0;
	public $default_cost = 0;
	public $switch_balance_on_insufficient = false;

	function __construct($owner = ""){
		$this->user_id = login_id();
		$this->owner = $owner === ""?owner:$owner;
        mb_internal_encoding('utf-8');
		$x = 10;
	}

	function set_message($message){
		$this->message = $message;
	}

	function set_recipient($recipient){
		if(is_array($recipient))
			$recipient = implode(",", $recipient);

		$this->recipient = $recipient;
		$this->filtered_recipient = $this->filter_numbers();
	}

	function set_route($route){
		$this->route = $route;
	}

	function set_sender($sender){
		$this->sender = $sender;
	}

	function set_dnd_sender($sender){
		$this->dnd_sender = $sender;
	}

	function set_user($user){
		$this->user_id = $user;
	}
	function set_type($type){
		$this->type = $type;
	}

	function get_numbers(){
		return $this->filtered_recipient;
	}

	function get_numbers_count(){
		$num = $this->get_numbers();
		if(empty($num))
			return 0;
		$count = explode(",", $num);
		return count($count);
	}

	function get_message(){
		$result = urlencode($this->message);
		$result = str_replace("%0D%0A", "%0A", $result);
		$result = str_replace("%5Cr%5Cn", "%0A", $result);
		$result = urldecode($result);
		if($this->type == "unicode"){
			return $this->str2unicode($result);
		}

		return $result;
	}

	function get_sender(){
		return $this->sender;
	}

	function total_cost(){
		$gateways = $this->gateways();
		$gid = $this->get_arrange_id("gateway", "id");
		$rid = $this->get_arrange_id("rate", "id");

		$default_rate = $this->user_data("rate");

		$total = 0;
		foreach($gateways as $id => $num){

			if(empty($default_rate)){
				$rate = getIndex($gid, "$id,rate");
				if(empty($rate)){
					$rate = $this->get_setting("default_rate");
				}
				if(is_numeric($rate) && $rate > 0)
					$rate = getIndex($rid, "$rate,rate");
			}else{
				$rate = $default_rate;
			}
			$total += $this->cost($rate, $num);
		}

		return $total;
	}

	function rate_array($include_route = true,  $fordnd = false){
		$source = $fordnd?"dnd_rate":"rate";

		$rate = $this->user_data($source);

		if(empty($rate))
			$rate = $this->get_setting("default_$source");

		if(is_numeric($rate) && $rate > 0){
			d()->where("id", $rate);
			$rate = getIndex(d()->get("rate")->row_array(), "rate");
		}

		if($include_route && !$fordnd){
			d()->where("owner", $this->owner);
			d()->where("route !=", "");
			d()->where("active", 1);
			$rows = d()->get("gateway")->result_array();
			foreach($rows as $row){
				$r = $row['rate'];
				if(is_numeric($row['rate']) && $row['rate'] > 0){
					d()->where("id", $r);
					$r = getIndex(d()->get("rate")->row_array(), "rate");
				}

				if(!empty($r)){
					$rate .= "\n". $r;
				}
			}
		}

		$rate = preg_replace("/[^\d=.]/",",", $rate);
		$array = explode(",", $rate);
		$price = array();
		foreach($array as $rt){
			if(empty($rt))
				continue;
			$x = explode("=", $rt);
			if(count($x) == 1){
				$default = $x[0];
			}
			if(count($x) != 2)
				continue;
			$price[$x[0]] = $x[1];
		}

			return $price;

	}

	private function cost($rate, $numbers, &$valid_numbers = array(), $source = "default_rate"){

		if(empty($rate))
			$rate = $this->get_setting($source);

		if(empty($rate)){
			return 0;
		}
		if(is_numeric($rate) && $rate > 0){
			d()->where("id", $rate);
			$rate = getIndex(d()->get("rate")->row_array(), "rate");
		}

		if(is_array($numbers))
			$numbers = implode(",", $numbers);

		$rate = preg_replace("/[^\d.=]/",",", $rate);
		$array = explode(",", $rate);
		$price = array();
		$default = 0;
		$total_amount = 0;
		foreach($array as $rt){
			if(empty($rt))
				continue;
			$x = explode("=", $rt);
			if(count($x) == 1){
				$default = $x[0];
			}
			if(count($x) != 2)
				continue;
			$price[$x[0]] = $x[1];
		}
		$numbers = explode(",", $numbers);
		foreach($numbers as $num){
			$amt = -1;
			foreach($price as $no => $amount){
				$len = strlen($no);
				if(substr($num,0, $len) == $no){

					$amt = (Float) ($this->balance_source == "previous_balance"?1:$amount);
					break;
				}
			}
			if($amt > -1) {
				$total_amount += $amt;
			}else {
				$total_amount += $default;
			}

			if($amt > 0)
				$valid_numbers[] = $num;

		}
		return $total_amount * $this->count_sms();
	}

	function count_sms(){
		if(empty($this->message))
			return false;
		$msglen = $this->msglen();
		$max_length = 160;
		if($this->type == "unicode")
			$max_length = 70;

		if($msglen <= $max_length)
			return 1;

		if($max_length == 160){
			$x = ceil($msglen/$max_length) * 7;
		}else{
			$x = ceil($msglen/$max_length) * 3;
		}
		$y = $x + $msglen;
		$a = ceil($y/$max_length);
		return $a;
	}

	function msglen(){
		$result = $this->get_message();
		$extraChars = 0;
		$result = urlencode($result);
		$result = str_replace("%0D%0A", "%0A", $result);
		$result = str_replace("%5Cr%5Cn", "%0A", $result);
		$result = urldecode($result);

		for($i = 0; $i < strlen($result); $i++) {
			$char = $result[$i];
			if ($char == '^') {
				$extraChars++;
			}
			else if ($char == '{') {
				$extraChars++;
			}
			else if ($char == '}') {
				$extraChars++;
			}
			else if ($char == '\\') {
				$extraChars++;
			}

			else if ($char == '[') {
				$extraChars++;
			}
			else if ($char == '~') {
				$extraChars++;
			}
			else if ($char == ']') {
				$extraChars++;
			}
			else if ($char == '|') {
				$extraChars++;
			}else if($char == "�"){
				$extraChars++;
			}
		}

		return mb_strlen($result, 'UTF-8') + $extraChars;
	}

	public function sms_dec($message){
		$uni_str = $message;
		$All = "";
			for($i=0; $i<strlen($uni_str); $i+=4)
			{
				$new="&#x".substr($uni_str,$i,4).";";
				$txt = html_entity_decode("$new", ENT_COMPAT, "UTF-8");
				$All.=$txt;
			}

			return $All;
	}

	function get_rate(){
		$rate = user_data("rate");
		if(empty($rate)){

		}
	}

	function str2unicode($data){
		$mb_hex = '';
		$mb_chars = "";
		$ord = 0;
		for ($i=0; $i<mb_strlen($data, 'UTF-8'); $i++) {
			$c = mb_substr($data, $i, 1, 'UTF-8');
			$mb_chars .= '{'. ($c). '}';
			$o = unpack('N', mb_convert_encoding($c, 'UCS-4BE', 'UTF-8'));
			if ($ord==10 OR $ord==13) {
				$mb_hex .= "000D000A";
			} else {
				$tmp = $this->hex_format($o[1]);
				$mb_hex .= (strlen($tmp)==2) ? "00{$tmp}" : $tmp;
			}
		}
		return $mb_hex;
	}

	private function hex_format($o) {
		$h = strtoupper(dechex($o));
		$len = strlen($h);
		if ($len % 2 == 1)
			$h = "0$h";
		return $h;
	}

	private function filter_numbers($numbers = ""){
		if(empty($numbers))
			$numbers = $this->recipient;

		$numbers = preg_replace("/[^\d]/",",",$numbers);
		$text = "";
		$array = explode(",", $numbers);
		foreach ($array as $key => $value) {
			$value = trim($value);
			$len = strlen($value);

			if(empty($value) || $len < 5 || $len > 20)
				continue;

			$first = $value[0];
			$second = $value[1];

				$pos = strpos($value, "0");
				$pos1 = strpos($value, "234");

				if($pos===0 && $len == 11){
					$value = "234".substr($value, 1);
				}else if($pos1===0 && $len == 13){
//					$value = $value;
				}else if($len == 10 && $first > 6 && $second < 3){
					$value = "234$value";
				}else{
					if($this->number_format == "nigeria")
						continue;
				}

				if(countryExit($value)) {
					if(strpos($text, $value) !== false)
						continue;
					if($this->number_format == "nigeria" || $this->justnigeria){
						if(strlen($value) == 13)
							$text .= ",0".substr($value, 3);
					}else
						$text .= ",$value";
				}
		}

		$all = substr($text, 1);

		return $all;
	}

	private function gateways(){
		if(!empty($this->gateways_array) && !$this->reset)
			return $this->gateways_array;

		$gateway = $this->user_data("gateway");
		if(empty($gateway)){
			$gateway = $this->get_setting("default_gateway");
		}

		if(empty($gateway)){
			return array();
		}

		$numbers = explode(",",$this->get_numbers());
		$mygateways = array();

		d()->where("owner", $this->owner);
		d()->where("route !=", "");
		d()->where("active", 1);
		$rows = d()->get("gateway")->result_array();

		$route = array();
		foreach($rows as $row){
			if(empty($row['route']))
				continue;
			$rt = preg_replace("/[^\d]/",",", $row['route']);
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

		$this->reset = false;
		$this->gateways_array = $mygateways;
		return $mygateways;
	}


	function validate_sms(){
		if(empty($this->sender) || strlen($this->sender) > 11) {
			if($this->trim_sender_id && strlen($this->sender) > 11){
				$this->set_sender(substr(trim($this->sender),0, 11));
			}else
				return $this->failed(1002);
		}

		if(empty_0(trim($this->message))){
			return $this->failed(1003);
		}

		if(empty(trim($this->filtered_recipient))){
			return $this->failed(1004);
		}

		$message = strtolower($this->message);
		$sender = strtolower($this->sender);

		if($this->is_spam($sender, $message)){
			$message = "Error: You were trying to send SPAM sms, your account has been temporary disabled. Contact Support";
			d()->where("id", $this->user_id);
      d()->update("users", array("disabled"=>time(),"disabled_text"=>$message));
      $mail = "Email: ". user_data("email", $this->user_id, "", false, $this->owner). "<br>Sender: " . $this->sender. "<br>MESSAGE: ". $this->message;

      send_mail($mail, "User Sending Spam Message", "quicksmsone@gmail.com");

      return $this->failed($message);
		}

		return array();
	}

	function is_spam($sender, $message){
    $sender = strtolower($sender);
    $message = strtolower($message);

    $sender = str_replace(" ", "", $sender);
    $message = str_replace(" ", "", $message);

		if(strpos($message, "callcustomer") !== false)
			return true;

		if(strpos($message, "customer") !== false && (strpos($message, "atm") !== false || strpos($message, "atm") !== false))
			return true;

		if(strpos($sender, "firstbank") !== false)
			return true;

		if(strpos($sender, "bank") !== false && strpos($message, "atm") !== false)
      return true;
    
    if(strpos($sender, "mtn") !== false)
      return true; 

    if(strpos($message, "08108209591") !== false)
			return true;  

    if(strpos($message, "mtn") !== false && (strpos($message, "congrats") !== false || strpos($message, "win") !== false || strpos($message, "won") !== false))
			return true;  

    if(strpos($message, "promo") !== false)
      return true;

		return false;
	}

	function send_sms(){

		$validate = $this->validate_sms();
		if(!empty($validate)){
			return $this->failed($validate['result']);
		}

		if($this->get_setting("suspend_send_sms") == 1) {
			return $this->failed("Gateway Busy, Please Try again later");
		}

			d()->where("owner", $this->owner);
		$mine = d()->get("reseller")->row_array();
		if(empty($mine)){
			return $this->failed("Invalid Owner ID");
		}
		$my_user_id = $mine['user_id'];
		$my_reseller_owner = $mine['parent'];

		$gate = $this->get_arrange_id("gateway", "id");
//		$rid = get_arrange_id("rate", "id");

		$dr = $default_rate = $this->user_data("rate");
		if(empty($default_rate)){
			$default_rate = $this->get_setting("default_rate");
		}

		$default_dnd_rate = $this->user_data("dnd_rate");
		if(empty($default_dnd_rate)){
			$default_dnd_rate = $this->get_setting("default_dnd_rate");
		}

		$test = false;
		$gateways = $this->gateways();
		$result = array();
		foreach($gateways as $gid => $numbers){
			$this->temp_numbers = $numbers;

			if($gid == "reseller"){
				d()->where("owner", $my_reseller_owner);
				$reseller = d()->get("reseller")->row_array();
				if(empty($reseller)){
					return $this->failed("Invalid Reseller ID");
				}
				if($this->route == 0 || $this->route == 1){
					$sending_route = 0;
					$rate = $default_rate;
				}else if($this->route == 2){
					$sending_route = 2;
					$rate = $default_dnd_rate;
				}else{
					$sending_route = $this->route;
					$rate = $default_rate;
				}

				dnd_continue:
				$temp = $numbers;
				$numbers = array();
				$cost = $this->cost($rate, $temp, $numbers);
				$null = array();
				$d_cost = $this->cost(0, $temp, $null, $sending_route == 0?"default_rate":"default_dnd_rate");
				$bal = $this->user_balance();

				if($bal < $cost && $this->charge){
					$result[] = $this->failed($this->is_sender?"1111":"2222");
				}else{
					$this->deduct_unit($cost, $sending_route, $d_cost);

					$sms = new sms($my_reseller_owner);
					$sms->set_message($this->message);
					$sms->set_route($sending_route);
					$sms->set_recipient($numbers);
					$sms->set_sender($this->sender);
					$sms->set_dnd_sender($this->dnd_sender);
					$sms->set_user($my_user_id);
					$sms->is_sender = false;
					$sms->switch_balance_on_insufficient = true;
					$sms->is_flash = $this->is_flash;
					$response = $sms->send_sms();
					if($response['sent']){
//						$this->reseller_cost = $sms->total_unit_used;
						$this->reseller_cost += $sms->total_unit_used;
						$this->sent_id = getIndex($response, "sent_id");

						$response = $this->save_msg($response, $numbers, $sending_route, $rate, $gid);
						if( $this->route == 1 && $sending_route == 0 && !empty($response['numbers_refund'])){
							$numbers = $response['numbers_refund'];
							$sending_route = 2;
							$rate = $default_dnd_rate;
							$result[] = $response;
							goto dnd_continue;
						}
					}else{
						$this->add_unit($cost, $sending_route, $d_cost);
					}
					$result[] = $response;
				}
			}else{
				$join = array_chunk($numbers, 35);
				foreach ($join as $k => $numbers) {
					$rate = $dr;


					if (empty($rate)) {
						$rate = getIndex($gate, "$gid,rate");
					}
					if (empty($rate)) {
						$rate = $default_rate;
					}

					$activeGateway = getIndex($gate, $gid);
					if ($this->route == 2) {
						$sending_route = 2;
						$rate = $default_dnd_rate;
					} else if ($this->route == 1) {
						$sending_route = 0;
					} else {
						$sending_route = $this->route;
					}

					dnd_continue2:
					if ($sending_route == 2) {
						$activeGateway = getIndex($gate, $this->get_setting("default_dnd_gateway"), array());
					}

					if ($sending_route == 3) {
						$activeGateway = getIndex($gate, $this->get_setting("default_all_gateway"), array());
					}


					balance_switched:

					$temp = $numbers;
					$numbers = array();
					$cost = $this->cost($rate, $temp, $numbers);
					$null = array();
					$d_cost = $this->cost(0, $temp, $null, $sending_route == 0?"cost_sms_rate":"cost_dnd_rate");
					$bal = $this->user_balance();
					if ($bal < $cost && $this->charge) {
						if($this->switch_balance_on_insufficient){
							$this->balance_source = $this->balance_source == "balance"?"previous_balance":"balance";
							$this->switch_balance_on_insufficient = false;
							goto balance_switched;
						}
						$result[] = $this->failed($this->is_sender ? "1111" : "2222");
					} else {

						if ($this->is_flash) {
							$sendURL = getIndex($activeGateway, "flash_api");
							$error = "No flash gateway configured";
						} elseif ($this->type == "unicode") {
							$sendURL = getIndex($activeGateway, "unicode_api");
							$error = "No unicode gateway configured";
						} else {
							$sendURL = getIndex($activeGateway, "send_api");
							$error = "Invalid Send Gateway configured";
						}

						if (empty($sendURL)) {
							$result[] = $this->failed($error);
							continue;
						}
						$sendURl2 = $sendURL;

						//DEDUCT UNIT
						$this->deduct_unit($cost, $sending_route, $d_cost);

						$method = getIndex($activeGateway, "method");

						$sendURL = str_replace('@@sender@@', urlencode($this->sender), $sendURL);
						$sendURL = str_replace('@@recipient@@', implode(",", $numbers), $sendURL);
						$sendURL = str_replace('@@message@@', urlencode($this->get_message()), $sendURL);
//						JUST TESTING
						if($this->get_setting("suspend_send_sms") == 1) {
							$response = "1702";
						}elseif($this->testing) {
								$successWord = getIndex($activeGateway, "success_word");
								$response = $successWord;
						}else{
							if ($method == 'POST') {
								$url = $sendURl2;

								$senderVal = $this->get_string_between($url, '&', '=@@sender@@');
								$toVal = $this->get_string_between($url, '&', '=@@recipient@@');
								$messageVal = $this->get_string_between($url, '&', '=@@message@@');
								$data = array("$senderVal" => $this->sender, "$toVal" => implode(",", $numbers), "$messageVal" => $this->message);

								$data_string = json_encode($data);

								$url = explode('?', $url);
								$url = $url[0];
								$ch = curl_init($url);
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
										'Content-Type: application/json',
										'Accept: application/json',
										'Content-Length: ' . strlen($data_string))
								);

								curl_setopt($ch, CURLOPT_TIMEOUT, 15);
								curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

								$response = curl_exec($ch);
								if (curl_error($ch)) {
									$response = curl_error($ch);
								}
								curl_close($ch);
							} else {  //use normal GET
								$ch = curl_init($sendURL);

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_FAILONERROR, true);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

								//SET PROXY SERVER
//                                curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
//                                curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
//                                curl_setopt($ch, CURLOPT_PROXY, "94.16.117.29");
								$response = curl_exec($ch);
								//TESTING PURPOSE
//								if($test){
//									$response = "1701";
//								}else{
//									$response = "1701|2349038781253,1032|2349038781252";
//								}
//								$test =

								if (curl_error($ch)) {
									$response = curl_error($ch);
								}
								curl_close($ch);
							}
						}

						$response = $this->process_response($response, $activeGateway);

						if ($response['sent']) {

							$response = $this->save_msg($response, $numbers, $sending_route, $rate, $gid);
							if ($this->route == 1 && $sending_route == 0 && !empty($response['numbers_refund'])) {
								$numbers = $response['numbers_refund'];
								$sending_route = 2;
								$rate = $default_dnd_rate;
								$result[] = $response;
								goto dnd_continue2;
							}

						} else {

							$this->add_unit($cost, $sending_route, $d_cost);
						}

						$result[] = $response;

					}//END OF ELSE FOR if ACCOUNT BALANCE IS SUFFICIENT
				}//END OF JOIN FOREACH
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
		$finals['count'] = array("sent"=>array(), "failed"=>array(), "dnd"=>array());

		if($sent){
			d()->where("owner", $this->owner);
			d()->where("sent_id", $this->sent_id);
			d()->where("user_id", $this->user_id);

			$array = d()->get("recipient")->result_array();

			foreach($array as $row){
				$status = $row['status'];
				$num = $row['phone'];

				switch($status){
					case 0: $finals['count']['sent'][] = $num; break;
					case 9: $finals['count']['dnd'][] = $num; break;
					default:
						$finals['count']['failed'][] = $num;
				}
			}
			$this->save_history($finals);
		}

		return $finals;
	}

	private function save_msg($response, $numbers, $sending_route, $rate, $gid){
		$sent_id = $this->db_insert_message();
		$refund = 0;
		$refund_dcost = 0;
		$array = getIndex($response,'result', array());
		$insert = array();
		$update = array();

		$data['sent_id'] = $sent_id;
		$data['owner'] = $this->owner;
		$data['user_id'] = $this->user_id;
		$data['route'] = $sending_route;
		$null = array();
		foreach($numbers as $num){
			d()->where("sent_id", $sent_id);
			d()->where("user_id", $this->user_id);
			d()->where("phone", $num);
			d()->limit(1);
			$id = getIndex(d()->get("recipient")->row_array(), "id");

			if(is_array($array)){
				$status = getIndex($array, "$num,status");
			}else{
				$status = "SENT";
			}

			if(empty($status)){
				$status = "SENT";
			}

			$msgid = getIndex($array, "$num,msgid");
			$mycost = $this->cost($rate, $num);
			$d_mycost = $this->cost(0, $num, $null, $sending_route == 0?"cost_sms_rate":"cost_dnd_rate");

			$data['status'] = $this->getDID($status);
			$data['msg_id'] = $msgid;
			$data['cost'] = $mycost;
			$data['phone'] = $num;
			$data['gid'] = $gid;

			if(strtoupper($status) != "SENT"){
				$refund += $mycost;
				$refund_dcost += $d_mycost;
				$data['cost'] = 0;
			}

			if(!empty($id)){
				$data['id'] = $id;
				$update[] = $data;
			}else{
				unset($data['id']);
				$insert[] = $data;
			}


		}

		if(!empty($insert)){
			d()->insert_batch("recipient", $insert);
		}

		if(!empty($update)){
			d()->update_batch("recipient", $update, "id");
		}

		if(!empty($refund)){
			$this->add_unit($refund, $sending_route, $refund_dcost);
		}


		$response['sent_id'] = $sent_id;
		return $response;
	}


	private function process_response($response, $activeGateway){
		$successWord = getIndex($activeGateway, "success_word");
		$tag = getIndex($activeGateway, "tag");

		if(!$response) {
			$return = $this->failed('Connection to Gateway Failed. Please try again later');  //. curl_error($ch)
		} else {
			if ((stripos($response, $successWord) !== false) || ($tag == 'routesms' && (strpos($response, "1032") !== false || strpos($response, "1715") !== false))) {

				$return = array("sent" => true, "result" => "Successfully Sent");

				if ($tag == 'routesms') {       //RouteSMS
					$return = $this->process_response_routesms($response);
				}

				if ($tag == 'quicksms1') {       //Quick SMS
					$return = $this->process_response_quicksms1($response);
				}

			} else {
				$return = array("sent" => false, "result" => $response);

			}
		}
		return $return;
	}

	private function process_response_routesms($results){
			$split = ","; $innersplit = "|";
			$response = Array();
			$return = Array();
			$response['sent'] = true;
			$xres = explode($split, $results);
			$cnt = 0;

			foreach($xres as $value){
				$cnt++;
				$x = explode($innersplit,$value);
				$status = trim($x[0]);
				$phone = isset($x[1])?$x[1]:"0000000000$cnt";
				$dlr_report = isset($x[2])?$x[2]:"";
				//                    print "status$status";
				if($status == 1701 || $status == 1715) {
					$return[$phone] = Array("msgid" => $dlr_report, "operatorid" => "", "cost" => "", "status" => "SENT" ,"error"=>"Message Sent Successfully");
					$response['numbers_sent'][] = $phone;
				}else if($status == 1032) {

					$return[$phone] = Array("msgid" => "0", "operatorid" => "", "cost" => "", "status" =>
						"DND", "error"=>"Number is on Do Not Disturb");
					$response['numbers_refund'][] = $phone;
				}else{
					if($status == 16){
						$this->set_setting("suspend_send_sms", 1);
					}
					$return[$phone] = Array("msgid" => "0", "operatorid" => "", "cost" => "", "status" =>
						'FAILED',"error"=>"Error: $status");
					$response['numbers_fail'][] = $phone;

				}
			}
			$response['result'] = $return;
			return $response;
		}

	private function process_response_quicksms1($results){
			$response = Array();
			$return = Array();
			$response['sent'] = true;
			$xres = explode("=", $results);

			$x = getIndex($xres, 1, 0);
			$dnd_numbers = array();
			if(stripos($x,"|") !== false){
				$y = explode("|", $x);
				$x = $y[0];
				$n = $y[1];
				$dnd_numbers = explode(",", $this->filter_numbers($n));
				$response['numbers_refund'] = $dnd_numbers;
			}
			foreach($this->temp_numbers as $num) {
				$return[$num]['msgid'] = trim($x);
				$return[$num]['status'] = in_array($num,$dnd_numbers)?"DND":"SENT";
			}
			$response['result'] = $return;
			return $response;
		}

	private $sent_id = null;
	private function db_insert_message(){
		if(!empty($this->sent_id)){
			return $this->sent_id;
		}
		$data['owner'] = $this->owner;
		$data['sender_id'] = $this->sender;
		$data['sender_id_dnd'] = $this->dnd_sender;
		$data['message'] = $this->get_message();
		$data['date'] = time();
		$data['method'] = $this->method;
		d()->insert("sent", $data);
		$this->sent_id = d()->insert_id();

		return $this->sent_id;
	}

	private function save_history($finals){
		$sent_id = $this->sent_id;
		if(empty($sent_id))
			return null;

		if(empty($finals['count']['sent']))
			return null;

		d()->where("owner", $this->owner);
		d()->where("user_id", $this->user_id);
		d()->where("order_id", $sent_id);
		d()->where("bill_type", "sms");

		$array = d()->get("bill_history")->row_array();

		if(!empty($array)){
			$amount = parse_amount($array['amount']);
			$recipient = parse_amount($array['recipient']);
			$data_profit = parse_amount($array['profit']);
			$data_commission = parse_amount($array['commission']);

			$data['amount'] = $amount + $this->total_unit_used;

			$commission = 0;
			if($this->is_reseller()){
				$profit = $this->total_unit_used - $this->reseller_cost;
			}else{
				$profit = $this->total_unit_used - $this->default_cost;
			}

			if($this->balance_source == "previous_balance"){
				$profit = 0;
			}

			if(is_commission_system() && is_reseller()){
				$commission = $this->total_unit_used - $this->default_cost;
			}

			$data['profit'] = $data_profit + $profit;
			$data['commission'] = $data_commission + $commission;

			$data['recipient'] = ($recipient + $this->get_numbers_count()) . " Numbers";
			$data['balance'] = $this->user_balance();
			d()->where("id", $array['id']);
			d()->update("bill_history", $data);
			return true;
		}




		$data['owner'] = $this->owner;
		$data['date'] = time();
		$data['user_id'] = $this->user_id;
		$data['network'] = "";
		$data['recipient'] = $this->get_numbers_count() . " Numbers";
		$data['bill_type'] = "sms";
		$data['type'] = "Bulk SMS";
		$data['transaction_id'] = generate_transaction_id(10,$this->owner);
		$data['amount'] = $this->total_unit_used;
		$data['status'] = "Completed";

		$commission = 0;
		if($this->is_reseller()){
			$profit = $this->total_unit_used - $this->reseller_cost;
		}else{
			$profit = $this->total_unit_used - $this->default_cost;
		}

		if(is_commission_system() && is_reseller()){
			$commission = $this->total_unit_used - $this->default_cost;
		}

		if($this->balance_source == "previous_balance"){
			$profit = 0;
		}

		$data['profit'] = $profit;
		$data['commission'] = $commission;

		$data['remark'] = "Sent Successfully ".($this->balance_source=="previous_balance"?"<br>(From Previous Wallet)":"");
		$data['order_id'] = $sent_id;
		$data['balance'] = $this->user_balance();


		d()->insert("bill_history", $data);
	}


	private function translate($code){
		switch($code){
			case "1111":
			return "Insufficient Balance. Please Recharge Your account";
			case "2222":
			return "Gateway Error: 2222";
		}
	}

	function reseller_id(){
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

	private function get_setting($key){
		return get_setting($key, "", $this->owner);
	}

	private function set_setting($key, $value){
		return set_setting($key, $value, $this->owner);
	}

	public $total_unit_used = 0;
	private function add_unit($unit, $sending_route, $d_cost = 0){
		if($this->balance_source != "previous_balance"){
			$this->default_cost -= $d_cost;
		}

		if(!$this->charge)
			return;

		if($sending_route == 2 && $this->balance_source == "previous_balance")
			$unit = $unit * 2;

		$this->total_unit_used -= $unit;
		d()->where("id", $this->user_id);
		d()->set($this->balance_source, "{$this->balance_source} + $unit", false);
		d()->limit(1);
		d()->update("users");
	}

	private function deduct_unit($unit, $sending_route = 0, $d_cost = 0)
	{
		if($this->balance_source != "previous_balance"){
			$this->default_cost += $d_cost;
		}
		if (!$this->charge)
			return;

		if($sending_route == 2 && $this->balance_source == "previous_balance")
			$unit = $unit * 2;

		$this->total_unit_used += $unit;

		d()->where("id", $this->user_id);
		d()->set($this->balance_source, "{$this->balance_source} - $unit", false);
		d()->limit(1);
		d()->update("users");
	}

	private function get_arrange_id($table,$column_name){
		if(is_array($table)){
			$x = $table;
		}else {
			d()->where("owner", $this->owner);
			$x = d()->get($table)->result_array();
		}
		$y = array();
		foreach($x as $row)
			$y[$row[$column_name]] = $row;
		return $y;
	}
	private function user_data($field = null){
		d()->where("id", $this->user_id);
		$user = d()->get("users")->row_array();

		if($field === null)
			return $user;

		return getIndex($user, $field);
	}

	function user_balance(){
		$source = $this->balance_source;
		return (Float) $this->user_data($source);
	}

	private function failed($result){
		return array("sent"=>false, "result"=>$this->translate?$this->reseller_translate(api_response_code($result)):$result);
	}

	private function reseller_translate($code){
		switch($code){
			case 2222:
				return "Site Account Limit Exceeded. Please try again later or contact Admin";
		}
		return $code;
	}
	private function success($result){
		return array("sent"=>true, "result"=>$result);
	}

	private function get_string_between($string, $start, $end){
		$r = explode($end, $string);
		if (isset($r[0])){
			$array = explode($start, $r[0]);
			$r = end($array);
			if ((stripos($r,'http') !== false)){
				$r = end(explode('?', $r));
			}
			return $r;
		}
		return '';
	}


	function getDID($value){
		$value = strtolower($value);
		switch ($value){
			case "sent": return 0;
			case "delivered": case "deliverd": case "delivrd": return 1;
			case "undelivered": case "undelivrd": case "undeliv": return 2;
			case "expired": case "expird": return 3;
			case "rejected": case "rejectd": return 4;
			case "invalid no.": return 5;
			case "smsc expired": return 6;
			case "not sent": case "failed": return 7;
			case "no report": return 8;
			case "dnd": return 9;
			default: return -1;
		}
	}

	function getDStatus($id){
		switch($id){
			case 0: return "SENT";
			case 1: return "DELIVRD";
			case 2: return "UNDELIVRD";
			case 3: return "EXPIRED";
			case 4: return "REJECTED";
			case 5: return "INVALID NO.";
			case 6: return "SMSC EXPIRED";
			case 7: return "NOT SENT";
			case 8: return "NO REPORT";
			case 9: return "DND (Refunded)";
			default: return "UNKNOWN";
		}
	}

	function get_display_rate($fordnd = false){
		$rates = $this->rate_array(true, $fordnd);
		$national = array();
		$international = array();
		foreach($rates as $num => $price){
			$len = strlen($num);
			if(strpos($num,"234") !== false){
				if($len == 3)
					$national['all'] = $price;
				else{
					$rem = 11 - $len;
					$num = $num."08".random_string("numeric", $rem);
					$net = network($num);
					if(!empty($net)){
						$national[$net] = $price;
					}else if(!empty($price)){
						$national['all'] = $price;
					}
				}
			}else{
				$name = country_name($num);
				if(!empty($name))
					$international[$name] = $price;
			}
		}
		$return['national'] = $national;
		$return['international'] = $international;

		return $return;
	}

}