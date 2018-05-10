<?php
$bill = new mybill();
$rate = $bill->rate(true, true);
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Buy DataPlan
					</div>
			</div>

			<div class="panel-body">

				<?php echo form_open(url('bill/buy_dataplan'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

				<div class="form-group" >
					<label class="bmd-label-floating">Mobile Network:</label>
					<select name="network" onchange="show_dataplan(); calculate_dataplan()" class="form-control" id="network">
						<?php
						//                $users =
						$bills = $rate['airtime'];
						foreach ($bills as $key => $value):
							if($value == -1)
								continue;

							?>
							<option value="<?php echo $key; ?>">
								<?= strtoupper($key) . ""; ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>

				<div class="form-group" >
					<label class="bmd-label-floating">Data Bundle Plan</label>
					<select name="dataplan" onchange="calculate_dataplan()" class="form-control" id="dataplan">

					</select>
				</div>

				<div class="form-group">
					<label class="bmd-label-floating">Enter Phone Number(s)</label>
					<textarea rows="2" required class="form-control" id="recipient" name="recipients"
					          onchange="filter_numbers()"></textarea>
					<label class="bmd-help">Multiple Numbers should be separated by comma</label>
				</div>


				<div class="form-group fixed-focused">
					<label class="bmd-label-floating">Amount to Pay</label>
					<input type="text" disabled id="total" name="amount_pay" value="0" class="form-control"/>

				</div>


				<div class="form-group">
					<label class="bmd-label-floating">Payment Method</label>
					<select name="method" required class="form-control">
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
	<div class="col-md-2 col-lg-3" style="padding: 10px; font-size: 14px; color: brown;">
		This databundle works on all devices e.g Andriod, Iphone, Computers, Modems, etc. <br>
		Data rollover is also available.
<br>
<br>
		<b>To check your data balance</b><br>
		MTN => *461*6#<br>
		GLO => *127*0#<br>
		Etisalat => *229*9#<br>
		AirTel => *140#

	</div>
</div>
<center><h4 style="font-weight: bold; text-decoration: underline;">DATA BUNDLE TRANSACTION HISTORY</h4></center>
<div id="mybill_history">
	<?php
	$history_bill_type = "dataplan";
	d()->where("bill_type", $history_bill_type);
	d()->where("user_id", login_id());
	d()->order_by("date", "DESC");
	d()->limit(10);
	$bill_history = c()->get("bill_history")->result_array();
	include_once "history_tab.php";
	?>
</div>
<script>

	$dataplan = <?=json_encode(getIndex($rate, "dataplan"));?>;

	$airtime = <?=json_encode(bill()->bill_payment_rate()['airtime']);?>;
	$number_network = <?=json_encode(network());?>;


	function filter_numbers() {
		$x = $("#recipient").val();
		$("#recipient").val(filter_local_numbers($x));
		calculate_dataplan();
	}

	function show_dataplan(){
		$ntw = $("#network").val();
		try{
			$("#dataplan").html("");
			$.each($dataplan[$ntw], function($unit, $amount){
				if(is_empty($amount) || $amount == "0")
					return;

				$xx = $("<option></option>");
				$xx.val($unit);
				$xx.html(convert_to_mb($unit)+" ("+format_numbers($amount)+")");
				$("#dataplan").append($xx);
			});
		}catch(e){
			console.log(e);
		}
		$("#dataplan").select2();
		if($is_mobile)
			$(".select2-search, .select2-focusser").remove();
	}

	function calculate_dataplan() {
		$recipients = $("#recipient").val().split(",");
		$amount = parse_number($("#amount").val());

		$total = 0;

		$.each($recipients, function ($k, $num) {
			$num = $num.toString().trim();
			$ntw = $("#network").val();
			$price = getIndex($dataplan, $ntw+","+$("#dataplan").val());
			$total = $total + parse_number($price);

		});
		$("#total").val(format_numbers($total));
	}


	function network($number) {
		$no = $number.substring(0, 4);
		$found = false;
		$.each($number_network, function ($net, $array) {
			$.each($array, function ($k, $num) {
				if ($num == $no) {
					$found = $net;
					return false;
				}
			});
			if ($found !== false)
				return false;
		});
		return $found || "";
	}

	function convert_to_mb($data){
		$x = parseInt($data);
		if($x < 1000)
			return $x+"MB";
		var y = parseFloat($x / 1000).toFixed(1);
		var z = y.indexOf(".");
		var a = y.substring(z);
		if(a == ".0")
			var b = parseFloat($x / 1000).toFixed(0)+"GB";
		else{
			var b =  y+"GB";
		}
		return b;
	}

	addPageHook(function(){
		$("#network").trigger("change");
	});

</script>