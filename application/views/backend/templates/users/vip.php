<div class="">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item active">
			<a data-target="#settings" class="nav-link active" data-toggle="tab"><i class="entypo-menu"></i>
				VIP Settings
			</a>
		</li>
		<li class="nav-item">
			<a data-target="#members" class="nav-link" data-toggle="tab"><i class="fa fa-plus"></i>
				Member's On VIP
			</a>
		</li>


	</ul>
	<!------CONTROL TABS END------>

    <?php
        $rate = c()->get("bill_rate")->result_array();
        $gateway = c()->get("rate")->result_array();
    ?>
	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
        <div class="tab-pane box active row " id="settings">
            <div class="row">
                   <div class="col-md-8 col-md-offset-2">
                       <div class="panel panel-primary">
                           <div class="panel-heading"><div class="panel-title">
                                   <i class="fa fa-edit"
                                      aria-hidden="true"></i> VIP SETTINGS
                               </div></div>
                           <div class="panel-body">
                               <?php echo form_open(url('users/vip/update'),
                                   array('class' => 'form-horizontal  validate', 'target' => '_top')); ?>
                               <div class="row">
                                    <div class="col-md-6">
                                        <h2>Phase 1 Settings</h2>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Phase 1 Amount</label>

                                            <input type="text" class="form-control number amount" name="phase1_amount"
                                                   value="<?php echo c()->get_setting('phase1_amount', 3); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Phase 1 Period (In Months)</label>

                                            <input type="text" class="form-control" name="phase1_period"
                                                   value="<?php echo c()->get_setting('phase1_period', 3); ?>">
                                        </div>
<br>
                                        <b>Select Price/Rate for this package/phase</b>

                                                <?php echo form_open(url('setting/rate/'.construct_url("update_cost")) , array('class' => ' validate','target'=>'_top'));?>

                                                <?php
                                                $array = array("phase1_cost_sms_rate", "phase1_cost_dnd_rate");
                                                foreach ($array as $name) {
                                                    ?>

                                                    <div class="form-group fixed-focused">
                                                        <label class="bmd-label-floating "><?=ucwords(str_replace("_"," ", $name));?></label>
                                                        <select class="form-control"  name="<?=$name;?>">
                                                            <option value="">Select Rate</option>
                                                            <?php
                                                            foreach ($gateway as $gt) {
                                                                ?>
                                                                <option value="<?=$gt['id'];?>" <?=p_selected(get_setting($name), $gt['id']);?>><?=$gt['name'];?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <div class="form-group fixed-focused">
                                                    <label class="bmd-label-floating">Bill Rate Cost</label>
                                                    <select class="form-control" name="phase1_cost_bill_rate">
                                                        <option value="">Select Rate</option>
                                                        <?php
                                                        foreach ($rate as $rt) {
                                                            ?>
                                                            <option value="<?=$rt['id'];?>" <?=p_selected(get_setting("phase1_cost_bill_rate"), $rt['id']);?>><?=$rt['name'];?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>



                                    </div>

                                    <div class="col-md-6">
                                        <H2>Phase 2 Settings</H2>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Phase 1 Amount</label>

                                            <input type="text" class="form-control number amount" name="phase2_amount"
                                                   value="<?php echo c()->get_setting('phase2_amount', "N1,000"); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Phase 1 Period (In Months)</label>

                                            <input type="text" class="form-control" name="phase2_period"
                                                   value="<?php echo c()->get_setting('phase2_period', 3); ?>">
                                        </div>

                                        <br>
                                        <b>Select Price/Rate for this package/phase</b>

                                        <?php echo form_open(url('setting/rate/'.construct_url("update_cost")) , array('class' => ' validate','target'=>'_top'));?>

                                        <?php
                                        $array = array("phase2_cost_sms_rate", "phase2_cost_dnd_rate");
                                        foreach ($array as $name) {
                                            ?>

                                            <div class="form-group fixed-focused">
                                                <label class="bmd-label-floating "><?=ucwords(str_replace("_"," ", $name));?></label>
                                                <select class="form-control"  name="<?=$name;?>">
                                                    <option value="">Select Rate</option>
                                                    <?php
                                                    foreach ($gateway as $gt) {
                                                        ?>
                                                        <option value="<?=$gt['id'];?>" <?=p_selected(get_setting($name), $gt['id']);?>><?=$gt['name'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="form-group fixed-focused">
                                            <label class="bmd-label-floating">Bill Rate Cost</label>
                                            <select class="form-control" name="phase2_cost_bill_rate">
                                                <option value="">Select Rate</option>
                                                <?php
                                                foreach ($rate as $rt) {
                                                    ?>
                                                    <option value="<?=$rt['id'];?>" <?=p_selected(get_setting("phase2_cost_bill_rate"), $rt['id']);?>><?=$rt['name'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Advantages</label>

                                            <textarea class="form-control" name="phase_advantages"><?php echo c()->get_setting('phase_advantages'); ?></textarea>
                                        </div>
                                    </div>
                                    <br>
                                   <div class="col-md-12" align="center">
                                       <button class="btn btn-success btn-raise">Save</button>
                                   </div>
                               </div>
                                </div>
                           </div>
                       </div>
                   </div>
            </div>

		<div class="tab-pane box " id="members">
			<div class="row">
				<div class="col-md-12 ">
                    <h5>List of members currently subscribe to a phase/package</h5>
<br>
					<table class="table table-bordered table_export">
						<thead>
						<tr>
							<th>
								<div><?php echo get_phrase('S/N'); ?></div>
							</th>
							<th>
								<div><?php echo get_phrase('username'); ?></div>
							</th>

                            <th>
                                <div><?php echo get_phrase('commission'); ?></div>
                            </th>
							<th>
								<div><?php echo get_phrase('phase'); ?></div>
							</th>
							<th>
								<div><?php echo get_phrase('Expiring Date'); ?></div>
							</th>

							<th>
								<div><?php echo get_phrase('options'); ?></div>
							</th>
						</tr>
						</thead>
						<tbody>
						<?php
                        $users = c()->get_where("users", "vip_package >", "0")->result_array();
						foreach ($users as $row):?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo c()->get_full_name($row); ?></td>
								<td><?php echo format_wallet($row['commission']); ?></td>
								<td>Phase <?php echo $row['vip_package']; ?></td>
								<td><?php echo convert_to_date($row['vip_expires']); ?></td>
								<td>

												<a class="btn btn-danger" href="javascript:void(0)"
												   onclick="confirm_delete('<?php echo url("users/vip/remove" . construct_url($row['id'])); ?>')">
													<i class="entypo-trash"></i> Remove From VIP List
												</a>

								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!----TABLE LISTING ENDS--->
	</div>

</div>


<script type="text/javascript">

	<?php if(!empty($id)){;?>
	addPageHook(function () {
		$("#send_addrole").trigger("click");
		return "destroy";
	});
	<?php } ?>

</script>