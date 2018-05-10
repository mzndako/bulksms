<?php
class payment_paystack extends my_payment_methods
{
	public $options = array();
	public $name = "paystack";
	public $setting_name = "atm_paystack";
	public $payment_method = "atm";
	public $payment_gateway = "paystack";
	function __construct($options = array()){
		$this->options = $options;
	}

	function connect()
	{

	    $data_ = array("payment_method"=>"atm");
	    $founder = founder();
        if($this->use_reseller_gateway()){
            $data_['order_id'] = $founder['owner'];
        }
		$trans = $this->process_transaction_fee();
		$name = $this->get_user_name();
		$phone = user_data("phone");

		$inline = empty($this->get_setting("method"))?true:false;

		$id = $this->save_transaction($data_);

		?>
		<?php
			if($inline) {

				?>
				<script src="https://js.paystack.co/v1/inline.js"></script>
				<?php
			}else{
				?>
				<form method="post" class="attached" action="<?=url('wallet/call_payment_method/proceed/atm/paystack');?>">
				<?php
			}
				?>

		<div class="form-group">
			<label class="bmd-label-floating">Name</label>
			<input type="text" value="<?=$name;?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Email</label>
			<input type="text" id="paystack_email" value="<?=user_data("email");?>" class="form-control"/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Transaction ID</label>
			<input type="text" name="transaction_id" value="<?=$id;?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Amount</label>
			<input type="text" name="amount" value="<?=format_amount($this->get("amount"));?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Transaction Fee</label>
			<input type="text" value="<?=format_amount($trans['transaction_fee']);?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Total</label>
			<input type="text" name="total" style="color: red;" value="<?=format_amount($trans['total']);?>" class="form-control" readonly/>
		</div>


		<?php
		if(!$inline) {
				?>
					<div class="col-md-12" align="center">
						<button  class="btn btn-raised btn-primary" ><i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-plus" aria-hidden="true"></i>  Pay</button>
					</div>
				</form>
				<?php
			}else {
		?>
		<div class="col-md-12" align="center">
			<button type="button" id="paystack_button" class="btn btn-raised btn-primary" onclick="payWithPaystack()"> <i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-plus" aria-hidden="true"></i>  Pay</button>
		</div>
					<script>
						function payWithPaystack() {
							if (is_empty($("#paystack_email").val()) || $("#paystack_email").val().indexOf("@") == -1) {
								my_alert("Please enter a valid email address to proceed");
								return;
							}
							buttonLoadingStart("#paystack_button");
							var handler = PaystackPop.setup({
								key: '<?=$this->get_setting("public_key");?>',
								email: $("#paystack_email").val(),
								amount: <?=$trans['total'] * 100;?>,
								ref: '<?=$id;?>',
								callback: function (response) {
									loadPage('<?=url("wallet/process_transaction/$id/1");?>');
			//						alert('success. transaction ref is ' + response.reference);
								},
								onClose: function () {
									buttonLoadingStop("#paystack_button");
			//						reloadPage();
									loadPage('<?=url("wallet/process_transaction/$id/1");?>');
									handler.closeIframe();
									this.closeIframe();
								}
							});

							handler.openIframe();
						}

					</script>
			<?php
			}
	}

	public function proceed(){
		$this->set_transaction_id($this->get("transaction_id"));
		$curl = curl_init();

		$id = $this->save_transaction(array("payment_method"=>"atm"));

		$options = array(
			CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode([
				'amount'=>parse_amount($this->get("total")) * 100,
				'email'=>user_data("email"),
				'callback_url'=>url("wallet/process_transaction/$id/1"),
//				"channels"=>array("bank","card"),
//				"ref"=>$id,
//				"reference"=>$id
			]),
			CURLOPT_HTTPHEADER => [
				"authorization: Bearer ".$this->get_setting("secret_key"),
				"content-type: application/json",
				"cache-control: no-cache"
			],
			CURLOPT_SSL_VERIFYHOST=> 0,
			CURLOPT_SSL_VERIFYPEER=> 0
		);
		curl_setopt_array($curl, $options);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
			// there was an error contacting the Paystack API

			ajaxFormDie('Curl returned error: ' . $err);
		}

		$tranx = json_decode($response);

		if(!$tranx->status){
			// there was an error from the API
			ajaxFormDie('API returned error: ' . $tranx->message);
		}

// store transaction reference so we can query in case user never comes back
// perhaps due to network issue
//		save_last_transaction_reference($tranx->data->reference);
		$id = $this->update_transaction(array("recipient"=>$tranx->data->reference));

// redirect to page so User can pay
		header('Location: ' . $tranx->data->authorization_url);
	}

	public function show($checked=false){
		?>
		<div class="col-md-6">
			<div class="radio radio-secondary">
				<label>
				<input type="radio" <?=$checked?"checked":"";?> name="type" value="paystack"/>
					Pay through Paystack Gateway
				</label>
			</div>
		</div>
<?php
	}

	public function response($requery_now = false){
	    $requery_now = empty($requery_now)?false:true;
		?>
		<div class="form-group">
			<label class="bmd-label-floating">Name</label>
			<input type="text" value="<?=user_data("fname", $this->get("user_id"))." ".user_data("surname", $this->get("user_id"));?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Email</label>
			<input type="text" id="paystack_email" value="<?=user_data("email", $this->get("user_id"));?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Transaction ID</label>
			<input type="text" value="<?=$this->get("transaction_id");?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Amount</label>
			<input type="text" value="<?=format_amount($this->get("amount"));?>" class="form-control" readonly/>
		</div>

		<div class="form-group">
			<label class="bmd-label-floating">Transaction Fee</label>
			<input type="text" value="<?=format_amount($this->get("transaction_fee"));?>" class="form-control" readonly/>
		</div>


		<div class="form-group">
			<label class="bmd-label-floating">Total Amount</label>
			<input type="text" value="<?=format_amount(parse_amount($this->get("amount")) + parse_amount($this->get("transaction_fee")));?>" class="form-control" readonly/>
		</div>

		<?php
			$my_status = $this->get("status");
			$my_remark = $this->get("remark");
			$my_amount = parse_amount($this->get("amount"));

			if($requery_now && compareString($this->get("status"), "Pending Payment")){
				$iid = empty($this->get("recipient"))?$this->get("transaction_id"):$this->get("recipient");
				$link = 'https://api.paystack.co/transaction/verify/'.$iid;

				$result = $this->send_data($link, null, array(CURLOPT_HTTPHEADER=>array("Authorization: Bearer ".$this->get_setting("secret_key"),"content-type: application/json",
					"cache-control: no-cache")));

				d()->where("id", $this->get("id"));
				$x = c()->get("bill_history")->row_array();
				if(!empty($result) && getIndex($x, "status") == "Pending Payment"){

					$server_amount = parse_amount(getIndex($result,"data,amount"));
					$status = getIndex($result, "data,status","Failed");
					$my_remark = getIndex($result,"data,gateway_response", "Error Processing");

					if(compareString($status, "success")){
						$my_status = "Completed";
						$local_amount = ($my_amount * 100) + (parse_amount($this->get("transaction_fee")) * 100);
						if($local_amount == $server_amount){
							update_user_balance($my_amount,true,true, $this->get("user_id"));
							$data['amount_credited'] = $my_amount;
						}else{
							$my_status = "Failed";
							$my_remark = $this->status_code("amount_different")." (".format_wallet($server_amount).")";
						}
					}else{
						$my_status = "Failed";
					}

					$data['status'] = $my_status;

					$data['balance'] = user_balance($this->get("user_id"));
					$data['remark'] = $my_remark;
					d()->where("id", $this->get("id"));
					c()->update("bill_history", $data);


                    $this->update_resellers($this->get("id"));
                }
			}
		?>

		<div class="form-group">
			<label class="bmd-label-floating">Status</label>
			<input type="text" value="<?=$my_status;?>" class="form-control" readonly />
		</div>

		<center><h3><?=$my_remark;?> (PayStack)</h3></center>
<?php
	}



}