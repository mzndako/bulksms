<div class="row">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item active">
			<a data-target="#config" class="nav-link active" data-toggle="tab"><i class="entypo-menu"></i>
				System Setting
			</a>
		</li>
<!--		<li class="nav-item">-->
<!--			<a data-target="#templateBox" class="nav-link" data-toggle="tab"><i class="entypo-menu"></i>-->
<!--				System Configuration-->
<!--			</a>-->
<!--		</li>-->


	</ul>
	<!------CONTROL TABS END------>

	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
		<div class="tab-pane box active" id="config">
			<div class="row">
				<div class="col-md-6">
					<?php echo form_open(url('setting/general/update/company'),
						array('class' => 'form-horizontal  validate', 'target' => '_top')); ?>
					<div class="panel panel-primary">

						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-plus-circle"
								   aria-hidden="true"></i> <?php echo get_phrase('system_settings'); ?>
							</div>
						</div>

						<div class="panel-body">


							<div class="form-group">
								<label class="bmd-label-floating">Site Name</label>

								<input type="text" class="form-control" name="site_name"
								       value="<?php echo c()->get_setting('site_name'); ?>">

							</div>

							<div class="form-group tag">COMPANY'S INFORMATION:</div>
							<?php
							$company = general_settings("company");
							foreach ($company as $k => $v):
								$opt['name'] = $k;
								$opt['value'] = get_setting($k);
								?>
								<div class="form-group">
									<label class="bmd-label-floating"><?= $v; ?></label>
									<?= c()->create_input($opt); ?>
								</div>
								<?php
							endforeach;
							?>
							<br>

							<div class="form-group">
								<label class="bmd-label-floating">Currency (Amount Prefix)</label>

								<?php
								$op['name'] = "currency";
								$op['type'] = "select";
								$op['value'] = get_setting("currency");
								$op['options'] = array("N" => "Naira", "$" => "US Dollar", "#" => "Euro", "R" => "Rupee", ""=>"No Prefix");
								echo c()->create_input($op);
								?>

							</div>

							<div class="form-group">
								<label class="bmd-label-floating">Currency Suffix</label>

								<?php
								$op['name'] = "currency_suffix";
								$op['type'] = "text";
								$op['value'] = get_setting("currency_suffix");
								echo c()->create_input($op);
								?>

							</div>

<div class="form-group">
								<label class="checkbox">
                                    <input type="checkbox" name="force_https" value="1" <?=get_setting("force_https") == 1?"checked='checked'":"";?> /> Force HTTPS
                                </label>



							</div>
                            <br><br>


							<br>
							<div class="col-md-12" align="center">

								<button type="submit"
								        class="btn btn-danger btn-raised"><?php echo get_phrase('update'); ?></button>

							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>

<div class="col-md-6">
					<?php echo form_open(url('setting/general/update/login'),
						array('class' => 'form-horizontal  validate', 'target' => '_top')); ?>
					<div class="panel panel-primary">

						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-plus-circle"
								   aria-hidden="true"></i> LOGIN OPTIONS
							</div>
						</div>

						<div class="panel-body">


							<div class="form-group tag" style="margin-bottom: 5px">ALLOW LOGIN METHODs:</div>
							<div class="">
								<div class="checkbox">
									<label>
									<input value="1" type="checkbox" <?=default_login_column("username")?"checked":"";?> name="login_using_username" /> Login Using Username
									</label>
								</div>
								<div class="checkbox">
									<label>
									<input value="1" type="checkbox" <?=default_login_column("email")?"checked":"";?> name="login_using_email" /> Login Using Email
									</label>
								</div>
								<div class="checkbox">
									<label>
									<input value="1" <?=default_login_column("phone")?"checked":"";?> type="checkbox" name="login_using_phone" /> Login Using Phone Number
									</label>
								</div>
							</div>

							<div class="form-group tag" style="margin-bottom: 5px">COMPULSORY REGISTRATION FIELDs:</div>
							<div class="">
								<div class="checkbox">
									<label>
									<input value="1" type="checkbox" <?=default_register_column("username")?"checked":"";?> name="register_using_username" /> Register Using Username
									</label>
								</div>
								<div class="checkbox">
									<label>
									<input value="1" type="checkbox" <?=default_register_column("email")?"checked":"";?> name="register_using_email" /> Register Using Email
									</label>
								</div>
								<div class="checkbox">
									<label>
									<input value="1" <?=default_register_column("phone")?"checked":"";?> type="checkbox" name="register_using_phone" /> Register Using Phone Number
									</label>
								</div>
							</div>




<br>
							<div class="col-md-12" align="center">

								<button type="submit"
								        class="btn btn-danger btn-raised"><?php echo get_phrase('update'); ?></button>

							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>



				<div class="col-md-6">


					<?php echo form_open(url('setting/general/upload_logo'), array(
						'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>

					<div class="panel panel-primary">

						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-upload" aria-hidden="true"></i> <?php echo get_phrase('upload_logo'); ?>
							</div>
						</div>

						<div class="panel-body">


							<div class="col-md-12 center">
								<b>Website Logo</b>


								<?php
								$options = array("type" => "logo", "id" => "logo", "default" => c()->defaultDocument("logo"), "name"=>"logo");
								echo "<center>" . c()->construct_image($options) . "</center>"; ?>

							</div>

							<div class="col-md-12 center">
								<b>Website Favicon: (Header Image) </b><br>
								Convert Image to Ico here <a href="http://icoconvert.com/" target="_blank">icoconvert.com/</a>


								<?php
								$options = array("type" => "favicon", "id" => "favicon", "default" => c()->defaultDocument("favicon"), "name"=>"favicon");
								echo "<center>" . c()->construct_image($options) . "</center>"; ?>

							</div>


							<br>
							<div class="col-md-12" align="center">

								<button type="submit"
								        class="btn btn-danger"><?php echo get_phrase('upload'); ?></button>


							</div>

						</div>

					</div>

					<?php echo form_close(); ?>

				</div>
			</div>
		</div>
		<!----TABLE LISTING ENDS--->


		<div class="tab-pane box" id="templateBox">

			<div class="panel panel-primary">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-desktop" aria-hidden="true"></i>
						System Configuration
					</div>
				</div>

				<div class="panel-body">
					<div class="row">
						<hr>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="bmd-label-floating">Login Using</label>
								<input type="text" name="login_using" class="form-control" value="<?=implode(",",default_login_column());?>"/>
								<div class="checkbox checkbox-secondary">
									<label>
										<input type="checkbox" name=""
									</label>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="bmd-label-floating">Register Using</label>
								<input type="text" name="login_using" class="form-control" value="<?=implode(",",default_register_column());?>"/>
							</div>
						</div>
					</div>
					<hr>
					<div clas="row">

						<div class="col-sm-6">
							<div class="form-group">
								<label class="bmd-label-floating">Register Using</label>
								<input type="text" name="login_using" value="" class="form-control"/>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>

</div>


<script type="text/javascript">


</script>