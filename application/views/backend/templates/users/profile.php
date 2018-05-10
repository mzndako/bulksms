<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
Update Profile
				</div>
			</div>



			<div class="panel-body">

				<?php echo form_open(url('users/profile/update'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

<b>PROFILE DETAILS</b>
						<div class="form-group">
							<label class="bmd-label-floating">First Name</label>
							<input type="text" value="<?= user_data("fname"); ?>" class="form-control"
							    name="fname"   />
						</div>

						<div class="form-group">
							<label class="bmd-label-floating">Last Name</label>
							<input type="text" value="<?= user_data("surname"); ?>" class="form-control"
							    name="surname"   />
						</div>

						<div class="form-group">
							<label class="bmd-label-floating">Phone</label>
							<input type="text"  value="<?= user_data("phone"); ?>" class="form-control"
							    name="phone"   />
						</div>

						<div class="form-group">
							<label class="bmd-label-floating">Email</label>
							<input type="text" value="<?= user_data("email"); ?>" class="form-control"
							    name="email"   />
						</div>

						<div class="form-group">
							<label class="bmd-label-floating">Default Sender ID</label>
							<input type="text" value="<?= user_data("sender_id"); ?>" class="form-control"
							    name="sender_id"   />
						</div>

	<div class="col-md-12" align="center">
		<br>
							<button name="update" class="btn btn-info btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>	<i class="fa fa-save" aria-hidden="true"></i>	Update
							</button>
						</div>

				<b>CHANGE PASSWORD</b>
						<div class="form-group">
							<label class="bmd-label-floating">Current Password</label>
							<input type="password"  class="form-control"
							    name="current_password"   />
						</div>
						<div class="form-group">
							<label class="bmd-label-floating">New Password</label>
							<input type="password"  class="form-control"
							    name="new_password1"   />
						</div>
						<div class="form-group">
							<label class="bmd-label-floating">Confirm New Password</label>
							<input type="password"  class="form-control"
							    name="new_password2"   />
						</div>

	<div class="col-md-12" align="center">
		<br>
							<button name="change" class="btn btn-info btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>	<i class="fa fa-briefcase" aria-hidden="true"></i>	Change Password
							</button>
						</div>


				</form>

				<div class="col-md-12">


					<?php echo form_open(url('users/profile/upload_profile'), array(
						'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
<br>
<br>
								<b>PROFILE PICTURE</b>


								<?php
								$options = array("type" => "profile", "id" => login_id(), "default" => c()->defaultDocument("logo"), "name"=>"profile");
								echo "<center>" . c()->construct_image($options) . "</center>"; ?>



							<br>
							<div class="col-md-12" align="center">

								<button type="submit"
										class="btn btn-warning"><i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <?php echo get_phrase('Upload Profile Picture'); ?></button>
							</div>
					</div>

					<?php echo form_close(); ?>

				</div>
			</div>
		</div>

	</div>
		</div>


	</div>
</div>
