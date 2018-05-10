<?php
this()->load->library("PaymentMethods");
$pg = new PaymentMethods();
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Fund Wallet
				</div>
			</div>

			<div class="panel-body">

				<?php echo form_open(url('wallet/fund/proceed'.construct_url($param2, $param3)), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>


				<?php
					if(!empty($method)) echo "<input type=hidden name=method value='$method'/>";
				?>
				<div class="form-group">
					<label class="bmd-label-floating">Payment Method</label>
					<select name="method" id="method" onchange="method_changed()" required class="form-control" <?=!empty($method)?"disabled":"";?>>
						<?php
						//                $users =
						$payment = pay()->get_enabled_methods();
						foreach ($payment as $key => $value):
							if($key == "wallet")
								continue;
							?>
							<option <?=p_selected($key == $method);?> value="<?php echo $key; ?>">
								<?= $value; ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>

				<?php
					if(empty($amount) && !empty($method))
						ajaxFormDie("Amount can not be empty");
				?>
				<div class="form-group">
					<label class="bmd-label-floating">Amount</label>
					<input type="text" id="amount" onblur="calculate_fee()" onkeyup="calculate_fee()" class="form-control number" name="amount" <?=!empty($amount)?"readonly":"";?> value="<?=$amount;?>" />
				</div>




				<div class="form-group inactive" id="send_amount">
					<label class="bmd-label-floating">Amount you will be credited with</label>
					<input type="text" class="form-control number" id="send_amount_input" readonly name="send_amount" value="" />
				</div>



				<?php

				$pg->load_classes();
				$airtime_fee = $pg->get_setting("airtime_transaction_fee");
				if($method == "atm" || $method == "bitcoin"){
					?>
					<div class="form-group">
					<?php
					$func = "{$method}_methods";
					$checked = true;
					$enabled = $method == "atm"?"atm_reseller":"bitcoin_reseller";
					foreach($pg->$func() as $key1 => $config){
						if($pg->is_enabled("atm_{$key1}_enabled", $enabled)) {
                            $y = "payment_$key1";
                            $x = new $y();
                            $x->show($checked);
                            $checked = false;
                        }
					}
					?>
					</div>

					<?php
					}else if(!empty($method)){
						$y = "payment_$method";
						if(class_exists($y)) {
							$x = new $y();
							$x->show();
						}
					}
				?>
<br>
				<?php
					if(!empty($x) && $x->show_proceed || empty($method)) {
						?>
						<div class="col-md-12" align="center">
							<button type="submit" class="btn btn-success btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>	<i class="fa fa-bolt" aria-hidden="true"></i>	Proceed
							</button>
						</div>
						<?php
					}


				if(!empty($x) && !empty($x->show_back)) {
					?>
					<div class="col-md-12" align="center">
						<div class="btn btn-success btn-raised" onclick="history.back();">
							<i class="fa fa-backward" aria-hidden="true"></i>	Back
						</button>
					</div>
					<?php
				}
				?>
				</form>
			</div>
		</div>


	</div>
</div>

<script>
	var airtime_tf = '<?=$airtime_fee?>';
	function method_changed(){
		var method = $("#method").val();
		if(method == "airtime"){
			$("#send_amount").show(100);
		}else
			$("#send_amount").hide(100);
		calculate_fee();
	}


	function calculate_fee(){
		var amount = $('#amount').val();
		var method = $('#method').val();
		var fee = calculate_airtime_fee(airtime_tf, amount, method);
		$("#send_amount_input").val(fee);
	}


	addPageHook(function(){
		method_changed();
		calculate_fee();
	});
</script>