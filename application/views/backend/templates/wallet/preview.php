<?php
this()->load->library("PaymentMethods");
$pg = new PaymentMethods();

$method = p("method");

$pg->load_classes();
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Fund Wallet (Preview)
				</div>
			</div>

			<div class="panel-body">
				<?php
				if($method == "atm" || $method == "bitcoin") {
					$func = "payment_".p("type");
				}else{
					$func = "payment_".p("method");
				}
					if(class_exists($func)) {
						$x = new $func(this()->input->post());
						if (method_exists($x, "connect")) {
							$x->connect();
						}
					}


				?>
			</div>

		</div>


	</div>
</div>
