<div class="">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item">
			<a data-target="#role" class="nav-link active" data-toggle="tab"><i class="entypo-menu"></i>
				Roles
			</a>
		</li>
		<li class="nav-item">
			<a data-target="#member" class="nav-link" data-toggle="tab"><i class="fa fa-plus"></i>
				Member's Permission
			</a>
		</li>
		<li class="nav-item">
			<a data-target="#addrole" id="send_addrole" class="nav-link" data-toggle="tab"><i class="fa fa-plus"></i>
				Add Role
			</a>
		</li>


	</ul>
	<!------CONTROL TABS END------>

	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
		<div class="tab-pane box active row " id="role">
			<div class="row">
				<div class="col-md-12 ">

					<table class="table table-bordered table_export">
						<thead>
						<tr>
							<th>
								<div><?php echo get_phrase('S/N'); ?></div>
							</th>
							<th>
								<div><?php echo get_phrase('name'); ?></div>
							</th>
							<th>
								<div><?php echo get_phrase('permissions'); ?></div>
							</th>

							<th>
								<div><?php echo get_phrase('options'); ?></div>
							</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$menu_ = new MenuBuilder();
						$acc = $menu_->get_menu(true);
						$permissions = c()->get("role")->result_array();
						$count = 1;
						$acc_ = get_arrange_id($acc, "access");
						foreach ($permissions as $row):?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php $y = explode(",", $row['access']);
									$z = array();
									foreach ($y as $v)
										$z[] = getIndex($acc_, $v.",title");

									if (!empty($z))
										print implode(", ", $z);

									?></td>

								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-warning btn-sm dropdown-toggle"
										        data-toggle="dropdown">
											Action <span class="caret"></span>
										</button>

										<ul class="dropdown-menu dropdown-default pull-right" role="menu">


											<!-- EDITING LINK -->
											<li>
												<a class="dropdown-item"
												   href="javascript:void(0)"
												   onclick="loadPage('<?= url("users/role/edit" . construct_url($row['id'])); ?>')">
													<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit'); ?>
												</a>
											</li>
											<li class="divider"></li>

											<!-- DELETION LINK -->
											<li>
												<a class="dropdown-item" href="javascript:void(0)"
												   onclick="confirm_delete('<?php echo url("users/role/delete" . construct_url($row['id'])); ?>')">
													<i class="entypo-trash"></i>
													<?php echo get_phrase('delete'); ?>
												</a>
											</li>


										</ul>

									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!----TABLE LISTING ENDS--->

		<!----TABLE LISTING STARTS-->
		<div class="tab-pane box row " id="member">
			<div class="row">
				<div class="col-md-12 ">
					<?php echo form_open(url('users/role/member_permission'), array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data'));
					?>
					<table class="table table-bordered table_export">
						<thead>
						<tr>
							<td>
								<div><?php echo get_phrase('S/N'); ?></div>
							</td>
							<td>
								<div><?php echo get_phrase('name'); ?></div>
							</td>
							<td>
								<div>
									<div class="checkbox inline-block checkbox-secondary pos-rel"><label>
											<input type="checkbox"
											       onclick="select_all_checkbox(this, 'member_permission')"/>
										</label>
									</div>
									Member's
								</div>
							</td>


						</tr>
						</thead>
						<tbody>
						<?php

						$member = explode(",", get_setting("member_permission"));

//						d()->where("for_student", 1);

						$acc = $menu_->get_menu(true);
						$permissions = c()->get("role")->result_array();
						$count = 1;
						foreach ($acc as $row):
							if($row['for_members'] != "1" || $menu_->has_children($acc, $row['id']))
								continue;
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row['title']; ?></td>
								<td>
									<div class="checkbox inline-block checkbox-secondary pos-rel"><label>
											<input <?= in_array($row['access'], $member) ? "checked" : ""; ?>
												type="checkbox" value="<?=$row['access'];?>" class="member_permission"
												name="member_<?= $row['id']; ?>"/>
										</label>
									</div>
								</td>

							</tr>
						<?php endforeach; ?>


						</tbody>
					</table>
					<div align="center">
						<button class="btn btn-info btn-raised"><i class="fa fa-refresh fa-spin inactive"
						                                           aria-hidden="true"></i> <i class="fa fa-save"
						                                                                      aria-hidden="true"></i>
							Save
						</button><br>
					</div>
					</form>
				</div>
			</div>
		</div>
		<!----TABLE LISTING ENDS--->


		<div class="tab-pane box" id="addrole">
			<?php echo form_open(url('users/role/update'), array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data'));
			$edit = new process_array(c()->get_row("role", "id", $id));

			$access = array();
			if (!empty($edit->get("access"))) {
				$access = explode(",", $edit->get("access"));
			}

			?>
			<div class="row ">
				<div class="col-md-12">
				<input type="hidden" name="id" value="<?= $id; ?>"/>


				<div class="col-md-6">
				<div class="form-group" >
					<label class="bmd-label-floating">Role</label>
					<input type="text" name="name" value="<?= $edit->get("name"); ?>" class="form-control"/>
				</div>
				</div>
				<div class="blockquote blockquote-danger col-md-12">
					Permissions
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="checkbox inline-block checkbox-secondary pos-rel"><label>
								<input type="checkbox" value="1" onchange="select_all_checkbox(this, 'all_permission')"
								       name=""/> Select/Unselect All
							</label>
						</div>
					</div>
					<?php
					$per = new MenuBuilder();
					$per->second_access = true;
					print $per->generate_permission($access);
					?>
				</div>
				<div align="center" class="col-md-12">
					<button name="submit" class="btn btn-raised btn-info">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-save"
						                                                                     aria-hidden="true"></i>
						Save
					</button>

				</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
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