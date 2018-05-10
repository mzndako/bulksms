<?php
$notifications = c()->get_notifications();
$x = 0;
?>
<div class="row">
	<div class="col-md-12">


		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
Notifications
				</div>
			</div>

			<div class="panel-body">
				<div style="color: black;font-size: 16px;">
					Use @@username@@ for username<br>@@phone@@ for member phone number<br>@@email@@ for member email<br><a href="javascript:void(0)" onclick="return view_more();">View More</a>

				</div><br>
				<?php echo form_open(url('admin/alerts/update'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>


				<table class="table table-striped">
					<thead>
						<tr>
							<th>S/N</th>
							<th>Name</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$count = 1;
					foreach($notifications as  $row) {
						?>
						<tr>
							<td><?=$count++;?></td>
							<td><?=$row['label'];?></td>
							<td>
							<?php
								foreach($row['options'] as $opt){
									$label = remove_underscore($opt['name']);
									$opt['value'] = setting()->get_notification($opt['name']);
									?>
									<div class="form-group">
										<label class="bmd-label-floating"><?=$label;?></label>
									<?=c()->create_input($opt);;?>
									</div>
								<?php
								}
							?>
							</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>


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
<script>
	function view_more(){
		var x = "Use the Following Variables in the notification field to replace with its corresponding values<br><br><table style='text-align: left;' class='table table-striped'>" +
			"<tr><td>@@username@@</td><td>Member Username</td></tr>" +
			"<tr><td>@@phone@@</td><td>Member Phone Number</td></tr>" +
			"<tr><td>@@email@@</td><td>Member Email Address</td></tr>" +
			"<tr><td>@@fname@@</td><td>Member First name</td></tr>" +
			"<tr><td>@@balance@@</td><td>Member Account Balance</td></tr>" +
			"<tr><td>@@amount_credited@@</td><td>Amount Credited (Fund Wallet)</td></tr>" +
			"<tr><td>@@total_units@@</td><td>Member Total Amount Bought</td></tr>" +
			"<tr><td>@@last_login@@</td><td>Member Last Login</td></tr>" +
			"<tr><td>@@registration_date@@</td><td>Member Registration Date</td></tr>" +
			"<tr><td>@@rate@@</td><td>Member Default Charging Rate</td></tr>" +
			"<tr><td>@@dnd_rate@@</td><td>Member Default DND Charging Rate</td></tr>" +
			"<tr><td>@@website@@</td><td>Website Domain Name (General Settings)</td></tr>" +
			"<tr><td>@@site_name@@</td><td>Website Site Name</td></tr>" +
			"<tr><td>@@cemail@@</td><td>Company Email</td></tr>" +
			"<tr><td>@@cphone@@</td><td>Company Phone Number</td></tr>" +
			"<tr><td>@@caddress@@</td><td>Company Address</td></tr>" +
			"</table>";
		my_alert(x);
		return false;
	}
</script>