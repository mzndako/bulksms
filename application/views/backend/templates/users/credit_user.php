<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					Credit User Account
				</div>
			</div>



			<div class="panel-body">

				<?php echo form_open(url('users/credit_user/proceed'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
<input type="hidden" name="function_success" value="credit_success"/>


				<?php
					if(!is_administrator()) {
						?>
						<div class="form-group">
							<label class="bmd-label-floating">Current Account Balance</label>
							<input type="text" value="<?= format_wallet(user_balance()); ?>" class="form-control"
							       readonly/>
						</div>
						<?php
					}
				?>



				<div class="form-group">
					<label class="bmd-label-floating">Receiver's <?=ucwords(implode(" OR ",default_login_column()));?></label>
					<input type="text" class="form-control"  name="receiver" value="" />
				</div>



	<div class="col-md-12" align="center">
		<br>
							<button class="btn btn-success btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>	<i class="fa fa-bolt" aria-hidden="true"></i>	Proceed
							</button>
						</div>
				</form>
			</div>
		</div>


	</div>
</div>

<script>

	function credit_success(response){
		showAjaxModal("<?=url("modal/popup/users.update_balance_modal/");?>"+response.user_id);
	}
</script>