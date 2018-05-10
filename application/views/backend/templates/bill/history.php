<?php
$bill = new mybill();
$rate = $bill->rate(true);
?>
<div class="row">
	<div class="col-md-12">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					TRANSACTION HISTORY
				</div>
			</div>

			<div class="panel-body">
				<div id="mybill_history">
					<?php
					$bill_can_export = true;
//					d()->order_by("date", "DESC");
//					if(!is_admin()){
//						d()->where("user_id", login_id());
//					}
//					d()->limit(50);
					$main_entry = true;
					include_once "history_tab.php";
					?>
				</div>
			</div>
		</div>


	</div>
</div>
