<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
d()->where("id", $param1);
if(!is_admin()){
	d()->where("user_id", login_id());
}
$array = c()->get("bill_history")->row_array();

if(empty($array))
	ajaxFormDie("You are not allowed to view this form");

extract($array);
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary b-w-0" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title" >
						<i class="entypo-plus-circled"></i>
						<?php
						if($bill_type == "fund_wallet"){
							print get_setting("site_name")." Payment Receipt";
						}else
							print "Transaction Details";
						?>
					</div>
				</div>
			</div>
			<div class="panel-body">

				<?php echo form_open(url('phonebook/update/'.construct_url($param1,$param2)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

				<div class="history_modal">
				<?php
					if(is_admin()) {
						?>
						<div>
							<span class="mf">Username:</span> <span class="ms"><?= c()->get_full_name($array['user_id']); ?></span>
						</div>
						<div>
							<span class="mf">Email:</span> <span class="ms"><?= user_data("email",$array['user_id']); ?></span>
						</div>
						<div>
							<span class="mf">Phone:</span> <span class="ms"><?=user_data("phone",$array['user_id']); ?></span>
						</div>
						<div>
							<span class="mf">Name:</span> <span class="ms"><?= user_data("fname",$array['user_id'])." ".user_data("surname",$array['user_id']); ?></span>
						</div>
						<hr>
						<?php
					}
				?>
					<div>
						<span class="mf">Transaction Type:</span> <span class="ms"><?= $type; ?></span>
					</div>

					<?php
						if(in_array($bill_type, array("airtime","dataplan"))) {
							?>
							<div>
								<span class="mf">Network:</span> <span class="ms"><?= $network; ?></span>
							</div>
							<?php
						}
					?>

					<div>
						<span class="mf">Date:</span> <span class="ms"><?= convert_to_datetime($array['date']); ?></span>
					</div>


					<?php
						if($bill_type == "sms"){
							?>
							<div>
								<span class="mf">Amount:</span> <span class="ms"><?= format_wallet($amount); ?></span>
							</div>


							<div>
								<span class="mf">Recipient:</span> <span class="ms"><?= $recipient; ?></span>
							</div>
					<?php
						}

						if(in_array($bill_type, array("airtime","dataplan"))){
							?>
							<div>
								<span class="mf">Amount:</span> <span class="ms"><?= format_wallet($amount); ?></span>
							</div>

							<div>
								<span class="mf">Number:</span> <span class="ms"><?= $recipient; ?></span>
							</div>
					<?php
						}

						if($bill_type == "bill"){
							?>
							<div>
								<span class="mf">Device No.:</span> <span class="ms"><?= $recipient; ?></span>
							</div>
					<?php
						}

						if($bill_type == "fund_wallet"){
							?>
							<div>
								<span class="mf">Amount:</span> <span class="ms"><?= format_wallet($array['amount']); ?></span>
							</div>
							<div>
								<span class="mf">Transaction Fees:</span> <span class="ms"><?= format_wallet($transaction_fee); ?></span>
							</div>
							<div>
								<span class="mf">Total Paid:</span> <span class="ms"><?= format_wallet($array['amount'] + $transaction_fee); ?></span>
							</div>
                            <br>
							<div>
								<b><span class="mf">STATUS:</span></b> <span class="ms"><?= $array['status']; ?></span>
							</div>
					<?php
						}
					?>

					<div>
						<span class="mf">Balance:</span> <span class="ms"><?= format_wallet($balance); ?></span>
					</div>





				<div class="col-md-12" align="center">
<!--					<button type="submit" onclick="printThis" class="btn btn-primary btn-raised">--><?php //echo "Print";
//						?><!--</button>-->
				</div>
				</div>
				</form>
			</div>

		</div>
	</div>



