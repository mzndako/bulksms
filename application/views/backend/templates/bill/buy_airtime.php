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
					Buy Airtime
				</div>
			</div>

			<div class="panel-body">

				<?php echo form_open(url('bill/buy_airtime/process'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>


				<div class="form-group">
					<label class="bmd-label-floating">Enter Phone Number</label>
					<textarea rows="2" required class="form-control" id="recipient" name="recipients"
					          onchange="filter_numbers()"></textarea>
					<label class="bmd-help">Multiple Numbers should be separated by comma</label>
				</div>

				<div class="form-group">
					<label class="bmd-label-floating">Airtime Value</label>
					<input onchange="calculate_airtime()" onblur="calculate_airtime()" type="text" required
					       name="amount" value="" id="amount" class="form-control number"/>
					<label class="bmd-help">The amount of airtime you want to buy</label>
				</div>
				<div class="form-group">
					<label class="checkbox">
						<input checked onchange="show_network(this)" id="autodetect" type="checkbox"
						       data-toggle="tooltip"
						       data-original-title="Deactivate Auto Detect to choose numbers yourself "
						       name="autodetect" value="1"/>

						Automatic Detect Phone Number Network
					</label>
				</div>

				<div class="form-group inactive" id="mynetwork">
					<label class="bmd-label-floating">Mobile Network:</label>
					<select name="network" onchange="calculate_airtime()" class="form-control" id="network">
						<?php
						//                $users =
						$bills = $rate['airtime'];
						foreach ($bills as $key => $value):
							if($value == -1)
								continue;
							$amount = strpos($value, "%") === false ? format_amount($value, -1) : $value;
							?>
							<option value="<?php echo $key; ?>">
								<?= strtoupper($key) . " ($amount)"; ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>


				<div class="form-group fixed-focused">
					<label class="bmd-label-floating">Amount to Pay</label>
					<input type="text" disabled id="total" name="amount_pay" value="0" class="form-control"/>
					<label id="rate" class="bmd-help" style="color: green; opacity: 9 !important; visibility: visible">
						<?php
						$bills = empty($rate['airtime'])?array():$rate['airtime'];
						$a = array();
						foreach ($bills as $key => $value) {
							$amount = strpos($value, "%") === false ? format_amount($value, -1) : $value;
							$a[] = ucwords($key) . " ($amount)";
						}
						print implode(", ", $a);
						?>
					</label>
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
</div>
<center><h4 style="font-weight: bold; text-decoration: underline;">AIRTIME TRANSACTION HISTORY</h4></center>
<div id="mybill_history">
	<?php
	$history_bill_type = "airtime";
	d()->where("bill_type", $history_bill_type);
	d()->where("user_id", login_id());
	d()->order_by("date", "DESC");
	d()->limit(10);
	$bill_history = c()->get("bill_history")->result_array();
	include_once "history_tab.php";
	?>
</div>
<script>

	$rate = <?=json_encode(getIndex($rate, "airtime"));?>;

	$airtime = <?=json_encode(bill()->bill_payment_rate()['airtime']);?>;
	$number_network = <?=json_encode(network());?>;
	function show_network(me) {
		if ($(me).is(":checked")) {
			$("#mynetwork").hide(200);
		} else {
			$("#mynetwork").show(200);
		}
		calculate_airtime();
	}

	function filter_numbers() {
		$x = $("#recipient").val();
		$("#recipient").val(filter_local_numbers($x));
		calculate_airtime();
	}

	function calculate_airtime() {
		$recipients = $("#recipient").val().split(",");
		$amount = parse_number($("#amount").val());

		$total = 0;

		$.each($recipients, function ($k, $num) {
			$num = $num.toString().trim();
			$ntw = $("#autodetect").is(":checked") ? network($num) : $("#network").val();
			$price = getIndex($rate, $ntw);
			$x = airtime_percentage($amount, $price);
			$total = $total + $x;

		});
		$("#total").val(format_numbers($total));
	}

	function airtime_percentage($amount, $rate) {
		$rate = $rate + "";
		if ($rate == -1)
			return 0;

		$r = parse_number($rate);

		if (is_empty($r))
			return 0;

		if ($rate.indexOf("%") != -1) {
			$price = $amount * ($r / 100);
			if ($rate.indexOf("-") != -1) {
				$price += $amount;
			} else {
				$price = $amount - $price;
			}

		} else {
			if ($rate.indexOf("-") !== -1) {
				$price = $amount + $r;
			} else {
				$price = $amount - $r;
			}
		}

		return $price;
	}

	function network($number) {
		$no = $number.substring(0, 4);
		$found = false;
		;
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

</script>