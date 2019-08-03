<?php
	$ms = new process_array(empty($mysearch)?array():$mysearch);
?>
<div class="row">
		<div class="col-sm-12">
			<br>
			<br>
			<button class="btn btn-raised btn-warning pull-right"
			        onclick="showAjaxModal('<?= url("modal/popup/users.view_modal"); ?>')">
				All New User
			</button>
			<span data-toggle="collapse" data-target=".myuserform" class="btn btn-raised btn-info btn-template">
	<i class="fa fa-search" aria-hidden="true"></i>	Advance Search
	</span>
			<?php echo form_open(url('users/view/search') , array('class' => ' '.(!empty($mysearch)?"in":""),'target'=>'_top'));

			?>
			<div class="row " style="margin-bottom: 5px;">

				<div class="col-md-12">
					<div class="row myuserform collapse <?=!empty($mysearch) && !empty($ms->get("reg_date1"))?"in":"";?>">
						<div class="col-md-3 form-group">
							<div class="checkbox">
								<label>
									<input onchange="show_div(this, '.reg_date')" type="checkbox" name="activate_reg" <?=p_checked(!empty($ms->get("reg_date1")));?>  value="1"/> Registration Date
								</label>
							</div>
						</div>

						<div class="col-md-3 form-group reg_date inactive">
							<label class="bmd-label-floating">From Date</label>
							<input type="text" data-format="dd-MMM-yyyy hh:mm AA" name="reg_date1" value="<?=$ms->get("reg_date1");?>" class="form-control datetime"/>
						</div>
						<div class="col-md-3 form-group reg_date inactive">
							<label class="bmd-label-floating">To Date</label>
							<input  data-format="dd-MMM-yyyy hh:mm AA" type="text" name="reg_date2" value="<?=$ms->get("reg_date2");?>" class="form-control datetime"/>
						</div>

					</div>
					<div class="row myuserform collapse <?=!empty($mysearch) && !empty($ms->get("lastlogin_date1"))?"in":"";?>">
						<div class="col-md-3 form-group">
							<div class="checkbox">
								<label>
									<input onchange="show_div(this, '.lastlogin')" type="checkbox" name="activate_lastlogin" <?=p_checked(!empty($ms->get("lastlogin_date1")));?>  value="1"/> Last Activity
								</label>
							</div>
						</div>

						<div class="col-md-3 form-group lastlogin inactive">
							<label class="bmd-label-floating">From Date</label>
							<input type="text" data-format="dd-MMM-yyyy hh:mm AA" name="lastlogin_date1" value="<?=$ms->get("lastlogin_date1");?>" class="form-control datetime"/>
						</div>
						<div class="col-md-3 form-group lastlogin inactive">
							<label class="bmd-label-floating">To Date</label>
							<input  data-format="dd-MMM-yyyy hh:mm AA" type="text" name="lastlogin_date2" value="<?=$ms->get("lastlogin_date2");?>" class="form-control datetime"/>
						</div>

					</div>


						<div class="col-md-4 form-group">
							<label class="bmd-label-floating">Type</label>
							<?php
							$count_all = c()->count_all("users");
							d()->where("is_admin", 1);
							$count_admin = c()->count_all("users");
							d()->where("is_admin", 0);
							$count_member = c()->count_all("users");
							d()->where("disabled !=", 0);
							$count_disabled = c()->count_all("users");
							?>
							<select name="type" class="form-control">
								<option value="">All Users (<?=$count_all;?>)</option>
								<option value="admin" <?=p_selected($ms->get("type") == "admin");?>>Staff (<?=$count_admin;?>)</option>
								<option value="member" <?=p_selected($ms->get("type") == "member");?>>Members (<?=$count_member;?>)</option>
								<option value="disabled" <?=p_selected($ms->get("type") == "disabled");?>>Disabled Users (<?=$count_disabled;?>)</option>

							</select>

						</div>

						<div class="col-md-4 form-group">
							<label class="bmd-label-floating">Search</label>
							<input type="text" name="search" value="<?=$ms->get("search");?>" class="form-control">
							<label class="bmd-help">Search for name, phone, email or username</label>
						</div>

					<div class="col-md-4 form-group">
						<label class="bmd-label-floating"></label>
						<button class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
						                                                                       aria-hidden="true"></i> <i
								class="fa fa-search" aria-hidden="true"></i> Search
						</button>
					</div>

				</div>



			</div>
			</form>

<br>
			<?php
				if(true || !empty($search) && count($all_users) <= 10) {
					?>
					<br>
					<table data-server-side="<?=history_link();?>" data-totalrecords="<?= $all_users_count;?>" class="table table-bordered table-striped datatable">
						<thead class="center">
						<tr>
							<th>#</th>
							<th>Names</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Type</th>
							<th>Balance</th>
							<?php
							if (is_mz()) {
								?>
								<th>P. Balance</th>
								<?php
							}
							?>
							<th>Total Credited</th>
							<th>Reg Date</th>
							<th>Last Activity</th>
							<th>Option</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$count = g("start") + 1;;
						foreach ($all_users as $row):
//					$title = "<div align='left'>Name: $row[fname] $row[surname]<br>Sex: $row[sex]<br>Balance: ".format_amount($row['balance'])."<br>Email: $row[email]</div>";
							?>
							<tr>
								<td>
                                <label class="radio radio-inline">
                                    <input type="checkbox" name="user_id[]" value="<?=$row['id'];?>" /> <?= $count++; ?>
                                </label>
                                </td>
								<td><?= $row['fname'] . " " . $row['surname']; ?></td>
								<td><?= c()->get_full_name($row); ?></td>
								<td><?= $row['phone']; ?></td>
								<td><?= $row['is_admin'] == 1 ? "Staff" : "Member"; ?></td>
								<td align="right"><?= format_amount($row['balance']); ?></td>
								<?php
								if (is_mz()) {
									?>
									<td align="right"><?= $row['previous_balance']; ?></td>
									<?php
								}
								?>
								<td align="right"><?= format_amount($row['total_units']); ?></td>

								<td align="center">
									<?php
									if(empty($row['registration_date'])){
										print "--";
									}else
										if(!$is_mobile) {
											?>
											<?= convert_to_datetime($row['registration_date']); ?>
											<?php
										}else {
											?>
											<time
												datetime="<?= convert_to_datetime($row['registration_date'], "g:i a j F, Y"); ?>"
												data-original-title="<?= convert_to_datetime($row['registration_date']); ?>">

											</time>
											<?php
										}
											?>
								</td>
								<td>
						<?php
						if(empty($row['last_activity'])){
							print "--";
						}else
						if(!$is_mobile) {
							?>
							<?= convert_to_datetime($row['last_activity']); ?>
							<?php
						}else {
							?>
							<time
								datetime="<?= empty($row['last_login']) ? "--" : convert_to_datetime($row['last_login'], "g:i a j F, Y"); ?>"
								data-original-title="<?= convert_to_datetime($row['last_login']); ?>">


							</time>
							<?php
						}
							?>
								</td>
								<td class="center" align="center">

									<div class="btn-group">
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
											Options <span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-default pull-right" role="menu">

											<!-- EDITING LINK -->


									<?php
									if (hAccess("credit_user")) {
										?>
										<li>
											<a href="javascript:void(0)" onclick="showAjaxModal('<?= url("modal/popup/users.update_balance_modal/$row[id]"); ?>')"
												   >
												<i class="fa fa-money" aria-hidden="true"></i> Update Account Balance
											</a>
										</li>
										<?php
									}
									?>
								<li>
									<a
									        onclick="showAjaxModal('<?= url("modal/popup/users.view_modal/$row[id]"); ?>')"
									     >
										<i class="fa fa-edit" aria-hidden="true"></i> Edit User
									</a>
								</li>
											<?php
											if (hAccess("change_staff_privilege")) {
												?>
												<li>
													<a
														onclick="showAjaxModal('<?= url("modal/popup/users.role_modal/$row[id]"); ?>')"
														>
														<i class="fa fa-shield" aria-hidden="true"></i> Change Staff Privilege
													</a>
												</li>
												<?php
											}
											?>

											<?php
									if (hAccess("delete_user")) {
										?>
										<li>
										<a
										        onclick="confirm_delete('<?= url("users/options/delete_user/$row[id]"); ?>', this, true)">
											<i class="fa fa-trash" aria-hidden="true"></i> Delete User
										</a>
											</li>
										<?php
									}
									?>
										</ul>
									</div>

								</td>
							</tr>
							<?php
						endforeach;
						?>
						</tbody>
					</table>
					<?php
				}
			?>
</div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-description">
                MESSAGE
            </div>
            <div class="form-group">
                 <label class="radio checkbox-inline">
                     <input type="radio" onchange="toggle_message()" name="type" value="sms" /> SMS
                 </label>
                 <label class="radio checkbox-inline">
                     <input type="radio" onchange="toggle_message()" name="type" value="email" /> EMAIL
                 </label>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="message"></textarea>
            </div>
            <div class="form-group" id="message_user">
                <textarea  class="form-control" name="message"></textarea>
            </div>

        </div>
    </div>
	</div>

<script>
	function show_div(me, myclass){
		if($(me).is(":checked")){
			$(myclass).show(100);
		}else{
			$(myclass).hide(100);

		}
	}

	addPageHook(function(){
		$("input[type=checkbox]").trigger("change");
		return "destroy";
	})
</script>