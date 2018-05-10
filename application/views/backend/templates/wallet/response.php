<?php



this()->load->library("PaymentMethods");
$pg = new PaymentMethods();



$pg->load_classes();
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Fund Wallet (<?=$id;?>)
				</div>
			</div>

			<div class="panel-body">
				<?php
				d()->where("transaction_id", $id);
				d()->where("bill_type", "fund_wallet");
				d()->where("owner", owner);

				$array = c()->get("bill_history")->row_array();

				if(empty($array)){
					print "<h2>Invalid Transaction ID: $id</h2>";
				}else {
					$method = $array['payment_method'];
					$type = $array['gateway'];
					if ($method == "atm" || $method == "bitcoin") {
						$func = "payment_" . $type;
					} else {
						$func = "payment_" . $method;
					}
					$x = new $func($array);
					if(method_exists($x, "response")){
						$x->response($requery_now);
					}

				}
				?>
			</div>

		</div>


	</div>
</div>
