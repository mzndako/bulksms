<?php
class payment_voguepay extends my_payment_methods
{
	public $options = array();
	public $name = "voguepay";
	public $setting_name = "atm_voguepay";
	public $payment_method = "atm";
	public $payment_gateway = "voguepay";
	function __construct($options = array()){
		$this->options = $options;
	}


	function connect()
	{
        $founder = founder();
        $data_ = array();
        if($this->use_reseller_gateway()){
            $data_['order_id'] = $founder['owner'];
        }
		$id = $this->save_transaction($data_);
		$trans = $this->process_transaction_fee();
		$name = $this->get_user_name();
		$phone = user_data("phone");
		$memo = $name." Wallet Recharging";
		$url = url("wallet/process_transaction/$id/success");
		$furl = url("wallet/process_transaction/$id/failed");
		$nurl = url("wallet/transaction_notify/$id");
		?>
<form class="attached" method="post" id="voguepay_form" action="https://voguepay.com/pay/">

		<div class="form-group">
			<label class="bmd-label-floating">Name</label>
			<input type="text" value="<?=$name;?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Email</label>
			<input type="text" id="voguepay_email" name="ce_customerid" value="<?=user_data("email");?>" class="form-control"/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Transaction ID</label>
			<input type="text" value="<?=$id;?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Amount</label>
			<input type="text" value="<?=format_amount($this->get("amount"));?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Transaction Fee</label>
			<input type="text" value="<?=format_amount($trans['transaction_fee']);?>" class="form-control" readonly/>
		</div>
		<div class="form-group">
			<label class="bmd-label-floating">Total</label>
			<input type="text"  style="color: red;" value="<?=format_amount($trans['total']);?>" class="form-control" readonly/>
		</div>
		<div class="col-md-12" align="center">
			<button type="button" id="paystack_button" class="btn btn-raised btn-primary" onclick="payWithVoguePay()"> <i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-plus" aria-hidden="true"></i>  Pay</button>
		</div>


<input type="hidden" name="v_merchant_id" value="<?php print $this->get_setting("merchant_id"); ?>"/>

<input type="hidden" name="merchant_ref" value="<?php print $id; ?>"/>
<input type="hidden" name="total" value="<?php print $trans['total']; ?>"/>


<input type="hidden" name="memo" value="<?php print $memo; ?>"/>

<input type="hidden" name="success_url" value="<?php print $url; ?>"/>

<input type="hidden" name="failed_url" value="<?php print $furl; ?>"/>

<input type="hidden" name="notify_url" value="<?php print $nurl; ?>"/>

<input type="hidden" name="ce_window" value="parent"/><!-- self or parent -->

</form>

		<script>
			function payWithVoguePay() {
				if(is_empty($("#voguepay_email").val()) || $("#voguepay_email").val().indexOf("@") == -1){
					my_alert("Please enter a valid email address to proceed");
					return;
				}
				$("#voguepay_form").submit();
			}

		</script>
		<?php
	}

	public function show($checked = false){
		?>
		<div class="col-md-6">
			<div class="radio radio-secondary">
				<label>
					<input type="radio" <?=$checked?"checked":"";?> name="type" value="voguepay"/>
					Pay through VoguePay Gateway
				</label>
			</div>
		</div>
		<?php
	}

	public function response($status = ""){

		if($status == "success" || $this->get("status") == "Completed"){
			$my_status = "Approved";
			$my_remark = $this->get("remark", "Successful");
		}else{
			$my_status = empty($status)?$this->get("status"):$status;
			$my_remark = $this->get("remark", "Payment Failed");;
		}
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
			<label class="bmd-label-floating">Amounta</label>
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


		<div class="form-group">
			<label class="bmd-label-floating">Status</label>
			<input type="text" value="<?=$my_status;?>" class="form-control" readonly/>
		</div>



		<center><h3><?=$my_remark;?> (VoguePay)</h3></center>
		<?php
	}

	function notify(){
		$my_amount = parse_amount($this->get("amount"));

		if(compareString($this->get("status"), "Pending Payment")){
			$link = 'https://voguepay.com/';
			$link = $link."?v_transaction_id=".this()->input->post_get("transaction_id")."&type=json&demo=true";
			$result = file_get_contents($link);
			$array = json_decode($result,true);

			if(empty($array) || empty($array['merchant_ref'])){
				return;
			}

			if($this->get("transaction_id") != $array['merchant_ref'])
				return;

			d()->where("id", $this->get("id"));
			$x = c()->get("bill_history")->row_array();
			if(!empty($array) && getIndex($x, "status") == "Pending Payment"){

				$result = $array;
				$server_amount = parse_amount(getIndex($result,"total"));
				$status = getIndex($result, "status","Failed");
				$my_remark = "Error Processing Request";

				if(compareString($status, "approved")){
					$my_status = "Completed";
					$my_remark = "Account Credited Successfully";

					$local_amount = $my_amount + parse_amount($this->get("transaction_fee"));

					if(compareString($local_amount, $server_amount)){
						update_user_balance($my_amount,true,true, $this->get("user_id"));

						$data['amount_credited'] = $my_amount;
					}else{
						$my_status = "Failed";
						$my_remark = $this->status_code("amount_different")." ($server_amount)";
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
	}





}