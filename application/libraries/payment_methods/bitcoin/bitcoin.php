<?php
class payment_bitcoin extends my_payment_methods
{
	public $options = array();
	public $name = "paystack";
	public $payment_method = "bitcoin";
	public $payment_gateway = "bitcoin";
	public $show_proceed = false;
	public $user_id = "";

	function __construct($options = array()){
		$this->options = $options;
	}

	function connect()
	{
		$address = $this->generate_address();
		$trans = $this->process_transaction_fee();
		$name = $this->get_user_name();

		$conv = parse_amount($this->get_setting("conversion"));
		$amount_in_usd = round($trans['total'] / $conv, 2);
		$amount_in_btc = $this->get_price($amount_in_usd);



		?>


		<div class="form-group">
			<label class="bmd-label-floating">Name</label>
			<input type="text" value="<?=$name;?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Amount</label>
			<input type="text" value="<?=format_amount($this->get("amount"));?>" class="form-control" readonly/>
		</div>
		<?php
			if(!empty($trans['transaction_fee'])) {
				?>
				<div class="form-group">
					<label class="bmd-label-floating">Transaction Fee</label>
					<input type="text" value="<?= format_amount($trans['transaction_fee']); ?>" class="form-control"
					       readonly/>
				</div>
				<div class="form-group">
					<label class="bmd-label-floating">Total (Naira)</label>
					<input type="text" style="color: red;" value="<?=format_amount($trans['total']);?>" class="form-control" readonly/>
				</div>
				<?php
			}
				?>


		<div class="form-group">
			<label class="bmd-label-floating">Total (USD)</label>
			<input type="text" style="color: red;" value="<?=format_amount($amount_in_usd, 2, '$');?>" class="form-control" readonly/>
		</div>

		<div class="form-group">
			<label class="bmd-label-floating">Total (Bitcoin)</label>
			<input type="text" style="color: red; font-weight: bold;" value="<?=format_amount($amount_in_btc,8,""," BTC");?>" class="form-control" readonly/>
		</div>

		<b style="color: red;">Send Payment to the link below. Your account will automatically be credited after <?=$this->get_setting("confirmation");?> Confirmations</b>
		<br><br>
		<b>BITCOIN ADDRESS: <i style="font-weight: bold; font-size: 16px"><?=$address;?></i> <a href="https://blockchain.info/address/<?=$address;?>" style="font-weight: bold; " target="_blank" class="fa fa-angle-double-up fa-2x" aria-hidden="true"></a></b>

		<div class="form-group">
			<div class="col-sm-12" align="center">

			<img src="https://blockchain.info/qr?data=<?=$address;?>&size=200" />
			</div>
		</div>




		<?php
	}

	public function show(){
		?>
		<div class="col-md-6">
			<button style="background: none; border: none;" type="submit" value="bitcoin">
				<input type="hidden" name="type" value="bitcoin"/>
					Pay with Bitcoin <img src="<?=url("uploads/bitcoin.png");?>">
			</button>
		</div>
<?php
	}


	public function generate_address(){
		$address = $this->get_user_address();
		if(!empty($address)) {
			return $address;
		}
		$callback = (isSecure()?"https://":"http://").domain_name()."/wallet/transaction_notify/cryptocurrency/bitcoin?secret_key=".$this->get_secret_key();

//		$callback = (isSecure()?"https://":"http://")."quicksms1.com"."/wallet/transaction_notify/cryptocurrency/bitcoin?secret_key=".$this->get_secret_key();

		$link = "https://api.blockchain.info/v2/receive?key=".$this->get_setting("key")."&xpub=".$this->get_setting("xpub")."&callback=".urlencode($callback)."&gap_limit=11";
		$response = file_get_contents($link);
		$result = json_decode($response, true);

		$address = getIndex($result, "address");
		if(!empty($address))
			$this->save_address($address);
		return $address;
	}

	function get_price($value, $to="btc"){
		if($to == "btc"){
			$link = "https://blockchain.info/tobtc?value=$value&currency=USD";
		}else{
			$value = 100000000 * $value;
			$link = "https://blockchain.info/frombtc?value=$value&currency=USD";
		}
		$amount = $this->send_data($link, null, array(), false);
		return parse_amount($amount);
	}


	public function response(){
		return $this->connect();
	}

	public function notify(){
			$address = this()->input->post_get("address");
			$confirmations = this()->input->post_get("confirmations");
			$transaction_hash = this()->input->post_get("transaction_hash");
			$value_in_btc = parse_amount(this()->input->post_get("value"));
			$secret_key = parse_amount(this()->input->post_get("secret_key"));
			if(!empty($value_in_btc)){
				$value_in_btc = $value_in_btc/100000000;
			}

			$my_secret_key = $this->get_secret_key();

			if($my_secret_key != $secret_key)
				return;

			d()->where("address", $address);
			$array = c()->get("cryptocurrency")->row_array();

			if(empty($array) || empty($transaction_hash))
				return;



			$this->user_id = $array['user_id'];

			d()->where("user_id", $array['user_id']);
			d()->where("recipient", $transaction_hash);
			$history = c()->get("bill_history")->row_array();

			$value_in_usd = $this->get_price($value_in_btc,"usd");

			if(empty($history)){
				$data['recipient'] = $transaction_hash;
				$data['amount'] = parse_amount($value_in_usd);
				$data['remark'] = "Awaiting Confirmation";
				$this->save_transaction($data);

				d()->where("user_id", $array['user_id']);
				d()->where("recipient", $transaction_hash);
				$history = c()->get("bill_history")->row_array();
			}

			$my_status = $history['status'];

			if($confirmations >= $this->get_setting("confirmation")){
				if($my_status == "Pending Payment"){
					$conv = parse_amount($this->get_setting("conversion"));
					$amount = $value_in_usd * $conv;
					$m['amount_credited'] = $amount;
					$m['status'] = "Completed";
					$m['remark'] = "Payment Confirmed";
					d()->where("id", $history['id']);
					c()->update("bill_history", $m);
					update_user_balance($amount, true,true,$this->user_id);
				}
				echo "*ok*";

			}else{
				echo "Awaiting Confirmation";
			}
	}


	function get_secret_key(){
		$key = $this->get_setting("my_secret_key");
		if(empty($key)){
			$key = random_string("alnum", 10);
			$this->set_setting("my_secret_key", $key);
		}
		return $key;
	}

}