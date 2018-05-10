<div class="row">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item active">
			<a data-target="#bulksms" class="nav-link active" data-toggle="tab"> <i class="fa fa-envelope-o"
			                                                                        aria-hidden="true"></i>
				Bulk SMS
			</a>
		</li>
		<?php
			if(empty(reseller_id())) {
				?>
				<li class="nav-item">
					<a data-target="#billpayment" class="nav-link" data-toggle="tab"><i class="fa fa-credit-card"
					                                                                    aria-hidden="true"></i>
						Bill Payment
					</a>
				</li>
				<?php
			}
		?>


	</ul>
	<!------CONTROL TABS END------>

	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
		<div class="tab-pane box active" id="bulksms">
			<br>
			<br>
			<button class="btn btn-raised btn-warning pull-right"
			        onclick="showAjaxModal('<?= url("modal/popup/setting.gateway_modal"); ?>')">
		<i class="fa fa-plus" aria-hidden="true"></i>		Add New Gateway
			</button>
			<br>
			<br>
<div class="responsive-table">
			<table class="table table-bordered table-striped">
				<thead class="center">
				<tr>
					<th rowspan="2">#</th>
					<th rowspan="2">Name</th>
					<th colspan="2" class="center">Default</th>
					<th rowspan="2">Price</th>
					<th rowspan="2">Route</th>
					<th rowspan="2">Balance</th>
					<th rowspan="2">Status</th>
					<th rowspan="2">Date</th>
					<th rowspan="2">Option</th>
				</tr>
				<tr>
					<th class="center">SMS Route</th>
					<th class="center">DND Route</th>
				</tr>
				</thead>
				<tbody>
				<?php $count = 0;; ?>
				<?php
				if(!empty(reseller_id())){
					?>
				<tr>
					<td><?= $count++; ?></td>
					<td>Reseller Gateway</td>
					<td class="center">
						<?php
							if (get_setting("default_gateway") != "reseller"):

								?>
								<i onclick="show_dialog(this)" data-toggle="tooltip" title="Set as Default SMS Gateway"
								   data-text="Activate Reseller Gateway as the 'default SMS Route'"
								   href="<?= url('setting/gateway/default_gateway/reseller'); ?>"
								   class="fa fa-star-o fa-2x cursor"></i>
								<?php
							else:
								?>
								<i class="fa fa-star fa-2x" aria-hidden="true"></i>
								<?php
							endif;

						?>
					</td>
					<td class="center">
						<?php

							if (get_setting("default_dnd_gateway") != "reseller"):

								?>
								<i data-toggle="tooltip" title="Set as default DND gateway" onclick="show_dialog(this)"
								   data-text="Activate Reseller Gateway as the 'default DND Route'"
								   href="<?= url('setting/gateway/default_dnd_gateway/reseller'); ?>"
								   class="fa fa-star-o fa-2x cursor"></i>
								<?php
							else:
								?>
								<i class="fa fa-star fa-2x" data-toggle="tooltip" title="Default DND Gateway"
								   aria-hidden="true"></i>
								<?php
							endif;

						?>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				}
				?>
				<?php
				d()->where("owner", 0);
				d()->or_where("owner", owner);
				$gateway = d()->get("gateway")->result_array();
				$count = 2;
				foreach ($gateway as $row):
					?>
					<tr>
						<td><?= $count++; ?></td>
						<td><?= $row['name']; ?></td>
						<td class="center">
							<?php
							if (!empty($row['send_api'])) {
								if (get_setting("default_gateway") != $row['id']):

									?>
									<i onclick="show_dialog(this)" data-toggle="tooltip" title="Set as Default SMS Gateway" data-text="Activate this gateway as the 'default SMS Route'" href="<?= url('setting/gateway/default_gateway/'.$row['id']); ?>"
									   class="fa fa-star-o fa-2x cursor"></i>
									<?php
								else:
									?>
									<i class="fa fa-star fa-2x" aria-hidden="true"></i>
									<?php
								endif;
							}
							?>
						</td>
						<td class="center">
							<?php
							if (!empty($row['send_api'])) {
								if (get_setting("default_dnd_gateway") != $row['id']):

									?>
									<i data-toggle="tooltip" title="Set as default DND gateway"  onclick="show_dialog(this)" data-text="Activate this gateway as the 'default DND Route'"
									   href="<?= url('setting/gateway/default_dnd_gateway/'.$row['id']); ?>"
									   class="fa fa-star-o fa-2x cursor"></i>
									<?php
								else:
									?>
<i class="fa fa-star fa-2x" data-toggle="tooltip" title="Default DND Gateway"  aria-hidden="true"></i>
									<?php
								endif;
							}
							?>
						</td>
						<td>
<!--							PRICE-->
						</td>
						<td>
							<?=str_replace("\n", "<br>", $row['route']);?>
						</td>
						<td>
<!--							BALANCE-->
						</td>

						<td class="center">
							<i onclick="loadContainer(this)" data-toggle="tooltip" title="Activate/De-activate this Gateway?"
							   href="<?= url('setting/gateway/activate/'.$row['id']); ?>"
							   class="fa fa-toggle-<?=$row['active']==1?"on":"off";?> fa-2x cursor"></i>

						</td>
						<td>
							<?= convert_to_date($row['date']); ?>
						</td>
						<td class="center" align="center">
							<button data-toggle="tooltip" title="Edit Gateway" onclick="showAjaxModal('<?= url("modal/popup/setting.gateway_modal/$row[id]"); ?>')" class="btn btn-sm btn-raise btn-warning">
								<i class="fa fa-edit" aria-hidden="true"></i>
							</button>
							<button data-toggle="tooltip" title="Delete Gateway"  onclick="confirm_delete('<?= url("setting/gateway/delete/$row[id]"); ?>', this, true)" class="btn btn-sm btn-raise btn-danger">
								<i class="fa fa-trash" aria-hidden="true"></i>
							</button>
						</td>
					</tr>
					<?php
				endforeach;
				?>
				</tbody>
			</table>
</div>

		</div>
		<!----TABLE LISTING ENDS--->


		<div class="tab-pane box" id="billpayment">

			<div class="panel panel-primary">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-desktop" aria-hidden="true"></i>
						Bill Payment Gateway
					</div>
				</div>

				<div class="panel-body">
					<?php
							$b = new Billpayment();
							$bill_gateway = $b->bill_gateway();

						foreach($bill_gateway as $key => $value) {
							?>
						<span class="btn btn-info btn-raised" onclick="showAjaxModal('<?=url('modal/popup/setting.gateway_bill_modal/'.$key);?>')">
							<?=$value;?> Setting
						</span>
							<?php
						}
					?>
					<div class="row">


						<div class="col-sm-12">

							<div >
								<?php
								$array = new process_array(array());
								?>

								<?php echo form_open(url('setting/bill_gateway/save') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

								<div class="row">


									<div class="col-md-12">
										<BR>
										AIRTIME GATEWAY SETTING
										<div class="responsive-table">
										<table class="table table-striped table-bordered partial-datatafble">
											<tr>
												<th>#</th>
												<th>Name</th>
												<?php
													foreach($bill_gateway as $key => $value) {
														?>
														<th>
<div class="radio checkbox-success">
	<label><input type="radio" name="airtime_head" onchange="select_all(this, '.airtime_<?=$key;?>')" /> <?=$value;?></label>
</div>
															</th>
														<?php
													}
												?>
											</tr>


											<?php
											$count = 1;
											$all = json_decode(get_setting("bill_gateway"), true);
											$all = empty($all)?array():$all;
											$myairtime = getIndex($all, "airtime", array());
											foreach(bill()->bill_payment_rate()['airtime'] as $airtime){
												print "<tr>";
												print "<td>".$count++."</td>";
												print "<td>".ucwords($airtime)." Airtime</td>";
												foreach($bill_gateway as $k =>$v)
												print "<td><div class='radio radio-sucess'><label><input class='airtime_$k' type='radio' ".p_checked(getIndex($myairtime, $airtime) == $k)."  name='airtime_$airtime' value='$k' /></label></div> </td>";
												print "</tr>";
											}
											?>
										</table>
									</div>
								</div>
								<div class="col-md-12">
									<div class="responsive-table">
									<table class="table table-stripped">
										<tr>
											<th>#</th>
											<th>Dataplan</th>
											<?php
											foreach($bill_gateway as $key => $value) {
												?>
												<th>
													<div class="radio checkbox-success">
														<label><input type="radio" name="data_head" onchange="select_all(this, '.dataplan_<?=$key;?>')" /> <?=$value;?></label>
													</div>
												</th>
												<?php
											}
											?>
										</tr>
										<?php
										$mydataplan = getIndex($all, "dataplan");
										foreach(bill()->bill_payment_rate()['dataplan'] as $airtime=> $dataplan){
											foreach($dataplan as $unit => $amount) {
												$mine = getIndex($mydataplan, $airtime.",$unit") ;
												$amt = format_amount($amount,0);
												$u = bill()->convert_to_mb($unit);
												print "<tr>";
												print "<td>" . $count++ . "</td>";
												print "<td>" . ucwords($airtime) . " $u ($amt) </td>";

												foreach($bill_gateway as $k =>$v)
												print "<td><div class='radio radio-sucess'><label><input type='radio'  class='dataplan_$k' name='$airtime".'_'."$unit' ".p_checked($mine == $k)." value=\"" . $k. "\" /> </td>";
												print "</tr>";
											}
										}
										?>
									</table>
									</div>
								</div>

								<div class="col-md-12">
									<div class="responsive-table">
									<table class="table table-stripped">
										<tr>
											<th>#</th>
											<th>Package</th>
											<?php
											foreach($bill_gateway as $key => $value) {
												?>
												<th>
													<div class="radio checkbox-success">
														<label><input type="radio" name="data_head" onchange="select_all(this, '.bill_<?=$key;?>')" /> <?=$value;?></label>
													</div>
												</th>
												<?php
											}
											?>
										</tr>
										<?php
										$mybill = getIndex($all, "bill");
										foreach(bill()->bill_payment_rate()['bill'] as $package=> $bill){
											foreach($bill as $plan => $y) {
												$name = $y['name'];
												$amount = $y['amount'];
												$mine = getIndex($mybill, $package.",$plan") ;
												$amt = format_amount($amount,0);
												print "<tr>";
												print "<td>" . $count++ . "</td>";
												print "<td>" . ucwords($name) . " ($amt) </td>";
												foreach($bill_gateway as $k =>$v)
												print "<td><div class='radio radio-success'><label><input type='radio' class='bill_$k' name='$package"."_".str_replace(".","_",$plan)."' ".p_checked($mine == $k)." value=\"" . $k. "\" /></label></div> </td>";
												print "</tr>";
											}
										}
										?>
									</table>
									</div>
								</div>

								<div class="col-md-12" align="center">
									<br><br>
									<button type="submit" class="btn btn-success btn-raised">
									<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>
										<i class="fa fa-save" aria-hidden="true"></i>
										Save</button>
								</div>
								</form>
							</div>
							<?php
							if(false && empty(reseller_id())) {

							 echo form_open(url('setting/gateway/save_bill'),
								array('class' => 'form-horizontal  validate', 'target' => '_top')); ?>

							<div class="form-group">
								<label class="bmd-label-floating">Client ID</label>
								<input name="client_id" type="text" value="<?=get_setting("bill_client_id");?>" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="bmd-label-floating">Client Key/Token</label>
								<input name="token" type="text" value="<?=get_setting("bill_token");?>" class="form-control"/>
							</div>

							<div class="col-md-12">
								<button class="btn btn-raised btn-success">
									Save
								</button>
							</div>
								</form>
								<?php
							}
							?>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>


<script type="text/javascript">


	addPageHook(function () {
		if (get_hash()) {
			trigger_tab(get_hash());
		}
		$(".myselect").trigger("change");
		return 'destroy';
	});


</script>