<?php echo form_open(url('bill/history/search') , array('class' => '','target'=>'_top'));

$history_bill_type = empty($history_bill_type)?false:$history_bill_type;
$trans_type = empty($trans_type)?"":$trans_type;
$user_id = empty($user_id)?"":$user_id;
?>
<div class="row" STYLE="margin-bottom: 5px;">
	<div class="col-md-12">
	<span data-toggle="collapse" data-target="#bill_history" class="btn btn-raised btn-primary">
		Filter
	</span>
		<i  data-original-title="Refresh" class="fa fa-refresh pull-right" style="cursor: pointer; display: none;" onclick="loadContainer(this,'<?=isset($main_entry) && $main_entry?"":"#mybill_history";?>')" href="<?=url("bill/history".construct_url($user_id,$trans_type));?>" aria-hidden="true"></i>
	</div>


	<div class="col-md-12 collapse <?=!empty($is_search)?"in":"";?>" id="bill_history">

		<?php
			if(!empty($main_entry) && !$main_entry) {
				?>
				<input type="hidden" name="container" value="#mybill_history"/>
				<?php
			}
		?>
		<input type="hidden" name="bill_type" value="<?=!empty($history_bill_type)?$history_bill_type:'';?>"/>
		<input type="hidden" name="can_export" value="<?=!empty($bill_can_export)?"1":'';?>"/>
		<div class="col-md-3 form-group">
			<label class="bmd-label-floating">Start Date</label>
			<input type="text" name="date1" value="<?=!empty($is_search) && !empty($date1)?$date1:"";?>" class="form-control date"/>
		</div>
		<div class="col-md-3 form-group">
			<label class="bmd-label-floating">End Date</label>
			<input  type="text" name="date2" value="<?=!empty($is_search) && !empty($date2)?$date2:"";?>" class="form-control date"/>
		</div>
		<div class="col-md-4 form-group">
			<label class="bmd-label-floating">Search</label>
			<input type="text" name="search" value="<?=!empty($is_search) && !empty($search)?"$search":"";?>" class="form-control"/>
		</div>

		<div class="col-md-3 form-group">
			<label class="bmd-label-floating">Transaction Type</label>
			<select name="trans_type" class="form-control">
				<option value="">All Transaction Type</option>
				<?php
				$array = string2array("sms=Bulk SMS,fund_admin=Fund Admin Wallet,fund_wallet=Fund Wallet,airtime=Airtime,dataplan=Dataplan,bill=Bill Payment,epin=E-Pins,all_bill=Airtime or Dataplan or Bill Payment");

				foreach($array as $key => $value) {
					if(!is_admin() && $key == "fund_admin")
						continue;
					?>
					<option <?=p_selected($key == $trans_type);?> value="<?=$key;?>" ><?=$value;?></option>
					<?php
				}
				?>
			</select>

		</div>
		<?php
		if(is_admin() ) {

			$all_users = get_arrange_id("users", "id");
//			$all_users = array();
			?>
			<div class="col-md-3 form-group">
				<label class="bmd-label-floating">Username</label>
				<select name="user_id" class="form-control user-select2">
					<option value="">All Users (<?=count($all_users);?>)</option>
					<?php
					foreach($all_users as $user) {
						if(empty($user_id))
							break;
						if($user['id'] == $user_id) {
							?>
							<option selected
								value="<?= $user['id']; ?>"><?= c()->get_full_name($user); ?></option>
							<?php
							break;
						}
					}
					?>
				</select>

			</div>
			<?php
		}
		?>
		<div class="col-md-3 form-group">
			<label class="bmd-label-floating"></label>
			<button class="btn btn-raised btn-info btn-block" name="search_history"><i class="fa fa-refresh inactive fa-spin"
			                                                                 aria-hidden="true"></i> <i
					class="fa fa-search" aria-hidden="true"></i> Search
			</button>
		</div>

	</div>

</div>
</form>



<div class="row">

	<!----TABLE LISTING STARTS-->
	<?php
		if($bill_history !== null) {
	if (is_admin() && show_help()) {
		print "<b style='color: black; padding: 10px;'>Click on the Member's Username to View/Edit the user information.</b>";
	}
	?>


	<div class="col-md-12">
		<table data-server-side="<?= history_link(); ?>" data-totalrecords="<?= empty($bill_history_count)?count($bill_history):$bill_history_count; ?>"
		       class="table table-stripded no-searach <?= !empty($bill_can_export)? "datatable" : 'partial-datatable'; ?>">
			<thead class="center">
			<tr>
				<th width="10px">#</th>
				<th>Date</th>
				<?php
				if (is_admin()) {
					?>
					<th>Username</th>
					<?php
				}
				?>
				<th>Trans. ID</th>
				<th>Network</th>
				<th>Type</th>
				<th>Amount</th>
				<?php
				if ($history_bill_type != "airtime") {
					?>
					<th>Amount Credited</th>
					<?php
				}
				?>
				<th>Balance</th>
				<?php
					if(is_admin()) print "<th>Profit</th>";
				?>

				<th>Recipient</th>
				<th>Payment Method</th>
				<th>Status</th>
				<th>Options</th>
			</tr>
			</thead>
			<tbody>
			<?php

			$count = g("start") + 1;;
			$bb = new mybill();

			foreach ($bill_history as $row){
				$color = "";
//				if ($row['status'] == "ORDER_ONHOLD" || $row['status'] == "ORDER_RECEIVED" || $row['status'] == "ORDER_PROCESSING") {
//					$x = $bb->update_current_status($row['id'], $row['order_id']);
//					$row['status'] = empty($x['status']) ? $row['status'] : $x['status'];
//					$row['remark'] = empty($x['remark']) ? $row['remark'] : $x['remark'];
//				}

				if ($row['status'] == "ORDER_COMPLETED" || compareString($row['status'], "Completed"))
					$color = "style='background: #255725; color:white;'";
				else if ($row['status'] == "ORDER_RECEIVED") {
					$color = "style='background: purple; color:white;'";
				} else if (compareString($row['status'], "pending payment")) {
					$color = "style='background: yellow; color:black;'";
				} else if (compareString($row['status'], "failed")) {
					$color = "style='background: red; color:white;'";
				}
				$status = bill()->errors($row['status'], $row['status_code'], $row['remark']);

				?>
				<tr <?= $color; ?> >
					<td><?= $count++; ?></td>
					<td><?= convert_to_datetime($row['date']); ?></td>
					<?php
					if (is_admin()) {
						?>
						<td>
									<span class="cursor" href="javascript:void(0)"
									      onclick="return showAjaxModal('<?= url("modal/popup/users.view_modal/$row[user_id]"); ?>')">
									<?= c()->get_full_name(getIndex($all_users, $row['user_id'])); ?>
										</span>
						</td>
						<?php
					}
					?>
					<td>
						<?= $row['transaction_id']; ?>
					</td>
					<td><?= strtoupper($row['network']); ?></td>
					<td><?= $row['type']; ?></td>
					<td><?= format_amount($row['amount'], -1); ?></td>
					<?php
					if ($history_bill_type != "airtime") {
						?>
						<td><?= $row['amount_credited'] != "0.00" ? format_amount($row['amount_credited'], -1) : ""; ?></td>
						<?php
					}
					?>
					<td><?= format_amount($row['balance'], -1); ?></td>
					<?php
					if(is_admin()) print "<td>".(empty((Float)$row['profit'])?"--":format_wallet($row['profit']))."</td>";
					?>
					<td><?= $row['recipient']; ?></td>
					<td><?php

						if ($row['bill_type'] == "fund_wallet")
							echo Pay()->methods($row['payment_method'] || "");
						else
							echo $row['payment_method'];

						?></td>
					<td style="text-align: center"><?= $status; ?></td>
					<td>
						<div class="btn btn-raised btn-warning" onclick="showAjaxModal('<?=url('modal/popup/bill.history_tab_modal/'.$row['id']);?>')">
						<i class="fa fa-eye" aria-hidden="true"></i>	View
						</div>
					</td>

				</tr>
				<?php
				};
					?>
					</tbody>
				</table>

			</div>
			<?php
		}
	?>

</div>
