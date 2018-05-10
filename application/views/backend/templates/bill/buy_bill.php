<?php
$bill = new mybill();
$rate = $bill->rate(true);
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Pay DsTv, GoTv and Startimes - Instant Activation
					</div>
			</div>

			<div class="panel-body">

				<?php echo form_open(url('bill/pay/'.$param1), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

				<div class="form-group" >
					<label class="bmd-label-floating">Mobile Network:</label>
					<select name="bill" onchange="show_mybill(); calculate_mybill()" class="form-control" id="bill">
						<?php
						//                $users =
						$bills = $rate['bill'];
						foreach ($bills as $key => $array):

							?>
							<option <?=p_selected($key, $param1);?> value="<?php echo $key; ?>">
								<?= strtoupper($key) ; ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>

				<div class="form-group" >
					<label class="bmd-label-floating">Data Bundle Plan</label>
					<select name="bill_type" onchange="calculate_mybill()" class="form-control" id="bill_type">

					</select>
				</div>

				<div class="form-group">
					<label class="bmd-label-floating">Decoder</label>
					<textarea rows="2" required class="form-control" id="recipient" name="recipients"></textarea>
					<label class="bmd-help">Multiple Numbers should be separated by comma</label>
				</div>


				<div class="form-group fixed-focused">
					<label class="bmd-label-floating">Amount to Pay</label>
					<input type="text" disabled id="total" name="amount_pay" value="0" class="form-control"/>

				</div>


				<div class="form-group">
					<label class="bmd-label-floating">Payment Method</label>
					<select name="method" class="form-control">
						<option value=""><?php echo get_phrase('Select'); ?></option>
						<?php
						//                $users =
						$payment = pay()->get_enabled_methods();
						foreach ($payment as $key => $value):
							?>
							<option value="<?php echo $key; ?>">
								<?= $value; ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>


				<div class="col-md-12" align="center">
					<button type="submit" class="btn btn-success btn-raised">
						Proceed
					</button>
				</div>
				</form>
			</div>
		</div>


	</div>
</div>
<center><h4 style="font-weight: bold; text-decoration: underline;">BILL PAYMENT TRANSACTION HISTORY</h4></center>
<div id="mybill_history">
	<?php
	$history_bill_type = "bill";
	d()->where("bill_type", $history_bill_type);
	d()->where("user_id", login_id());
	d()->order_by("date", "DESC");
	d()->limit(10);
	$bill_history = c()->get("bill_history")->result_array();
	include_once "history_tab.php";
	?>
</div>
<script>

	$bill = <?=json_encode(getIndex($rate, "bill"));?>;

	$bill_type = <?=json_encode(bill()->bill_payment_rate()['bill']);?>;

	function filter_numbers() {
		$x = $("#recipient").val();
		x = $x.replace(/[^\d]/g, ",");
		y = x.split(",");
		var array = [];
		$.each(y, function(k, v){
			if(v.length > 4 && v.length < 20){
				array.push(v);
			}

		});
		$("#recipient").val(array.join(", "));
		calculate_mybill();
	}

	function show_mybill(){
		$ntw = $("#bill").val();
		try{
			$("#bill_type").html("");
			$.each($bill_type[$ntw], function(code, array){
				if(is_empty(getIndex($bill, $ntw+","+code)) || getIndex($bill, $ntw+","+code) == "0")
					return;
				$xx = $("<option></option>");
				$xx.val(code);
				$xx.html(getIndex(array, "name")+" ("+format_numbers(getIndex($bill, $ntw+","+code))+")");
				$("#bill_type").append($xx);
			});
		}catch(e){
			console.log(e);
		}
		$("#bill_type").select2();
	}

	function calculate_mybill() {
		$recipients = $("#recipient").val().split(",");

		$total = 0;

		$.each($recipients, function ($k, $num) {
			$ntw = $("#bill").val();
			var bill_id = $("#bill_type").val();
			$price = getIndex($bill, $ntw+","+bill_id);
			$total = $total + parse_number($price);

		});
		$("#total").val(format_numbers($total));
	}

	addPageHook(function(){
		$("#bill").trigger("change");
	});

</script>