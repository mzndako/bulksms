<div class="row">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item active">
			<a data-target="#bulksms" class="nav-link active" data-toggle="tab"> <i class="fa fa-envelope-o"
			                                                                        aria-hidden="true"></i>
				Notifications
			</a>
		</li>


	</ul>
	<!------CONTROL TABS END------>

	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
		<div class="tab-pane active" id="bulksms">
			<b>Manage Notification that will be displayed or popup to users when accessing specific pages.</b>
			<br>
			<br>
			<button class="btn btn-raised btn-warning pull-right"
					onclick="showAjaxModal('<?=url("modal/popup/admin.notification_hp_modal"); ?>')">
				HomePage Notification
			</button>
			<button class="btn btn-raised btn-warning pull-left"
			        onclick="showAjaxModal('<?=url("modal/popup/admin.notification_modal"); ?>')">
				Create Notification
			</button>
			<br>
			<br>

			<table class="table table-bordered table-striped partial-datatable ">
				<thead class="center">
				<tr>
					<th >#</th>
					<th >Date</th>
					<th >Title</th>
					<th >Content Summary</th>
					<th >Status</th>
					<th >Read</th>
					<th >Expires</th>
					<th class="no-print">Option</th>
				</tr>
				</thead>
				<tbody>
				<?php

				$gateway = c()->get("notification")->result_array();
				$count = 1;
				foreach ($gateway as $row):
					?>
					<tr>
						<td><?= $count++; ?></td>
						<td>
							<?= convert_to_datetime($row['date']); ?>
						</td>
						<td><?= $row['title']; ?></td>
						<td><?= substr(strip_tags($row['message']), 0, 20); ?></td>

						<td class="center">
							<i onclick="loadContainer(this)" data-toggle="tooltip" title="Enable/Disable this Notification?"
							   href="<?= url('admin/notifications/disabled/'.$row['id']); ?>"
							   class="fa fa-toggle-<?=$row['active']==1?"on":"off";?> fa-2x cursor"></i>

						</td>
						<td>
							<?php
								c()->where("notification_id", $row['id']);
								c()->where("view_date >", 0);
								print c()->count_all("notification_read");
							;?>
						</td>
						<td>
							<?= convert_to_datetime($row['date']); ?>
						</td>

						<td class="center" align="center">
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									Options <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-default pull-right" role="menu">

									<!-- EDITING LINK -->
									<li>
										<a href="javascript:void(0)" onclick="showAjaxModal('<?=url("modal/popup/admin.notification_modal/$row[id]"); ?>')" >
											<i class="fa fa-edit" aria-hidden="true"></i> Edit Notification
										</a>
									</li>
									<li class="divider"></li>

									<li>
										<a  href="javascript:void(0)"  onclick="showAjaxModal('<?=url("modal/popup/admin.notification_read_modal/$row[id]"); ?>')">
											<i class="fa fa-eye" aria-hidden="true"></i>
											View Read Users
										</a>
									</li>


									<!-- DELETION LINK -->

										<li class="divider"></li>						<li>
											<a href="javascript:void(0)" onclick="confirm_delete('<?=url("admin/notifications/delete/$row[id]");?>', this, true)">
												<i class="fa fa-trash" aria-hidden="true"></i>
												<?php echo get_phrase('delete');?>
											</a>
										</li>


								</ul>
							</div>
						</td>
					</tr>
					<?php
				endforeach;
				?>
				</tbody>
			</table>

		</div>
		<!----TABLE LISTING ENDS--->


		<div class="tab-pane box" id="billpayment">

			<div class="panel panel-primary">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-desktop" aria-hidden="true"></i>
						Template
					</div>
				</div>

				<div class="panel-body">
					<div class="row">


						<div class="col-sm-6">

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>


<script type="text/javascript">





</script>