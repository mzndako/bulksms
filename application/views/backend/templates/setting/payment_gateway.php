<?php
	$pg = new PaymentMethods();
?>
<div class="row">
	<div class="col-md-12">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Payment Gateway
				</div>
			</div>

			<div class="panel-body">

				<?php echo form_open(url('setting/payment_gateway/save'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

				<div class="responsive-table">
				<table class="table table-striped">
					<thead>
						<tr>
							<td>S/N</td>
							<td>Name</td>
							<td>Enabled</td>
							<td>Options</td>
						</tr>
					</thead>
					<tr>
						<td>1</td>
						<td><?=pay()->methods("atm");?></td>
						<td>
							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/atm'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("atm")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td>
								<div class="col-md-12" style="text-align: center">
                                    <i onclick="loadContainer(this)" data-toggle="tooltip"
                                       title="Enable to use reseller gateway?"
                                       href="<?= url('setting/payment_gateway/enabled/atm/reseller'); ?>"
                                       class="fa fa-toggle-<?= pay()->payment_enabled("atm_reseller") ? "on" : "off"; ?> fa-2x cursor"> Use Reseller Gateway Instead</i><br><br>
							<?php
								foreach($pg->atm_methods() as $key1 => $config){
									?>
									<b><u><?=$config['name'];?></u></b>
									<?php
										foreach($config['options'] as $key2 => $options) {
											$data = array();
											if(is_array($options)){
												$data = $options;
											}else{
												$data['label'] = str_replace("_", " ",ucwords($options));
												$key2 = $options;
											}
											$data['name'] = "atm_{$key1}_$key2";
											$data['value'] = $pg->get_setting("atm_{$key1}_$key2");
											?>
											<div class="form-group">
												<label class="bmd-label-floating"><?=getIndex($data, "label");?></label>
												<?=c()->create_input($data);?>
											</div>

											<?php
										}
									?>
<hr>
								<?php
								}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><?=pay()->methods("bank");?></td>
						<td>

							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/bank'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("bank")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td>
							<div class="form-group">
								<label class="bmd-label-floating">Format (Bank Name=Account Number=Account Name)</label>
								<textarea class="form-control" name="bank_accounts"><?=$pg->get_setting("bank_accounts");?></textarea>
								<label class="bmd-help">Bank Account Information</label>
							</div>
							<div class="form-group">
								<label class="bmd-label-floating">Bank Additional Detail</label>
								<textarea class="form-control" name="bank_detail"><?=$pg->get_setting("bank_detail");?></textarea>
								<label class="bmd-help">Additional Details to be prepended</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><?=pay()->methods("internet");?></td>
						<td>

							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/internet'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("internet")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td><div class="form-group">
								<label class="bmd-label-floating">Internet Additional Detail</label>
								<textarea class="form-control" name="internet_detail"><?=$pg->get_setting("internet_detail");?></textarea>
								<label class="bmd-help">Additional Details to be prepended</label>
							</div>
						</td>
					</tr>

					<tr>
						<td>2</td>
						<td><?=pay()->methods("mobile");?></td>
						<td>

							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/mobile'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("mobile")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td><div class="form-group">
								<label class="bmd-label-floating">Mobile Additional Detail</label>
								<textarea class="form-control" name="mobile_detail"><?=$pg->get_setting("mobile_detail");?></textarea>
								<label class="bmd-help">Additional Details to be appended</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><?=pay()->methods("airtime");?></td>
						<td>

							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/airtime'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("airtime")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td>

							<div class="form-group">
								<label class="bmd-label-floating">Accepted Network (e.g MTN, GLO)</label>
								<input class="form-control" name="airtime_network" value="<?=$pg->get_setting("airtime_network");?>">
								<label class="bmd-help">Multiple network separated by comma</label>
							</div>

							<div class="form-group">
								<label class="bmd-label-floating">Receiver Email</label>
								<input class="form-control" name="airtime_email" value="<?=$pg->get_setting("airtime_email");?>">
								<label class="bmd-help"></label>
							</div>
							<div class="form-group">
								<label class="bmd-label-floating">Airtime Additional Detail</label>
								<textarea class="form-control" name="airtime_detail"><?=$pg->get_setting("airtime_detail");?></textarea>
								<label class="bmd-help">Additional Details to be appended</label>
							</div>
							<div class="form-group">
								<label class="bmd-label-floating">Transaction Fee (%)</label>
								<input type="text" class="form-control" name="airtime_transaction_fee" value="<?=$pg->get_setting("airtime_transaction_fee");?>"/>
								<label class="bmd-help">Can also not be in percentage</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><?=pay()->methods("bitcoin");?></td>
						<td>

							<i onclick="loadContainer(this)"  data-toggle="tooltip" title="Activate/De-activate this Method?"
							   href="<?= url('setting/payment_gateway/enabled/bitcoin'); ?>"
							   class="fa fa-toggle-<?=pay()->payment_enabled("bitcoin")?"on":"off";?> fa-2x cursor"></i>
						</td>
						<td>
							<table class="tdable table-borddered" width="100%">
								<?php
								foreach($pg->bitcoin_methods() as $key1 => $config){
									?>
									<tr><td>
									<h4><u><?=$config['name'];?></u></h4>
									</td></tr>
									<?php
									foreach($config['options'] as $key2 => $options) {
										if(!is_array($options)){
											$options = array("label"=> str_replace("_", " ",ucwords($options)));
											$key2 = $options;
										}
										?>
								<tr><td><div class="col-md-12">

										<div class="form-group">
											<label class="bmd-label-floating"><?=getIndex($options, "label");?></label>
											<input type="text" class="form-control" name="bitcoin_<?=$key1."_".$key2;?>" value="<?=$pg->get_setting("bitcoin_{$key1}_$key2");?>"/>
										</div>
										</div>
									</td></tr>
										<?php
									}
									?>

									<?php
								}
								?>
							</table>
						</td>
					</tr>
				</table>
					</div>


				<div class="col-md-12" align="center">
					<button type="submit" class="btn btn-success btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>
						<i class="fa fa-save" aria-hidden="true"></i>
						Save
					</button>
				</div>
				</form>
			</div>
		</div>


	</div>
</div>
