<?php
class payment_airtime extends my_payment_methods
{
	public $options = array();
	public $name = "airtime";
	public $setting_name = "airtime";
	public $payment_method = "";
	public $payment_gateway = "airtime";
	public $show_back = false;
	function __construct($options = array()){
		$this->options = $options;
	}

	function connect()
	{
		$amount = $this->get("amount");
		$pins = $this->get("pins");
		$network = $this->get("network");
		$array_pins = explode(",",$pins);

		$recipient = count($array_pins)." $network recharge PIN:<br>$pins";
		$this->save_transaction(array("payment_method"=>"airtime","recipient"=>$recipient, "amount"=>parse_amount(this()->input->post("amount"))));

		?>
			<div class="col-md-12" align="center">
				<b><?=$recipient;?></b>
			</div>

			<div class="col-md-12" align="center">
				<H3><b>RECEIVED</b></H3>
				<span style="color: black;">Your account will be credited immediately your PINs are confirmed</span>
			</div>

		<div class="col-md-12" align="center">
			<span class="btn btn-info btn-raised" onclick="history.back()">
<i class="fa fa-backward" aria-hidden="true"></i>				Back
			</span>
		</div>



		<?php
		$message = "";
		if(is_mz())
			$message .= "<B>Username:</B> ".user_data("username", login_id())."<br>";

		$message .= "<b>Phone:</b> ".user_data("phone", login_id())."<br>";
		$message .= "<b>Amount Sent:</b> ".format_wallet($this->get("amount"))."<br>";
		$message .= "<b>Amount to be Credit:</b> ".format_wallet($this->get("send_amount"))."<br>";
		$message .= "<b>Date:</b> ".convert_to_datetime(time())."<br>";
		$message .= $recipient;


		if(!empty($this->get_setting("email")))
			send_mail($message, "Recharge Pin(s)", $this->get_setting("email"));
	}



	public function show(){
		$trans = $this->process_transaction_fee($this->get("amount"));
		?>

		<input type="hidden" name="type" value="airtime"/>
		<div class="form-group">
			<label class="bmd-label-floating">Network</label>
			<select required name="network" class="form-control">
				<?php
				foreach($this->airtime_network() as $netwk) {
					?>
					<option><?=$netwk;?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Recharge PINs</label>
			<textarea required name="pins" class="form-control"></textarea>
			<label class="bmd-help">Multiple Recharge PINs Separated by comma</label>
		</div>
		<div class="form-group">
			<span style="color: black"><?=$this->get_setting("detail");?></span>
		</div>




<?php
	}

	public function process_transaction_fee($amount = 0){
		$amount = empty($amount)?round(parse_amount($this->get("amount")), 2, PHP_ROUND_HALF_UP):$amount;
		$tf = $this->get_setting("transaction_fee");
		$transaction_fee = 0;
		$total = $amount;
		if(!empty($tf)){
			$transaction_fee = parse_amount($tf);
			if(strpos($tf, "%") !== false){
				$transaction_fee = round($amount/(1+($transaction_fee/100)), 2, PHP_ROUND_HALF_UP);
				$transaction_fee = $amount - $transaction_fee;
			}
			$total = $transaction_fee + $amount;
		}
		return array("amount"=>$amount, "transaction_fee"=>$transaction_fee, "total"=>$total);
	}



}