<div class="row">
	<div class="col-md-12">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					MESSAGE HISTORY
				</div>
			</div>

			<div class="panel-body">
				<?php echo form_open(url('message/history/search') , array('class' => '','target'=>'_top'));

				?>
				<div class="row" style="margin-bottom: 5px;">

					<div class="col-md-12">

						<div class="col-md-3 form-group">
							<label class="bmd-label-floating">From Date</label>
							<input type="text" data-format="dd-MMM-yyyy hh:mm AA" name="date1" value="<?=$date1;?>" class="form-control datetime"/>
						</div>
						<div class="col-md-3 form-group">
							<label class="bmd-label-floating">To Date</label>
							<input  data-format="dd-MMM-yyyy hh:mm AA" type="text" name="date2" value="<?=$date2;?>" class="form-control datetime"/>
						</div>
						<div class="col-md-3 form-group">
							<label class="bmd-label-floating">Search</label>
							<input type="text" name="keyword" value="<?=$keyword;?>" class="form-control "/>
						</div>


						<?php
							if(is_admin()) {
								$all_users = get_arrange_id("users", "id");
//								$all_users = array();;
								?>
								<div class="col-md-6 form-group">
									<label class="bmd-label-floating">Username</label>
									<select name="user_id" class="form-control user-select2">
										<option value="">All Users (<?=count($all_users);?>)</option>
										<?php
											foreach($all_users as $user) {
												if(empty($user_id))
													break;

												if($user['id'] == $user_id) {
													?>
													<option <?= p_selected($user['id'] == $user_id); ?>
														value="<?= $user['id']; ?>"><?= c()->get_full_name($user); ?></option>
													<?php
													break;
												}
											}
										?>
									</select>

								</div>
								<?php
								$all_users = get_arrange_id("users", "id");
							}
						?>
						<div class="col-md-3 form-group">
							<label class="bmd-label-floating"></label>
							<button name="search" class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
							                                                                 aria-hidden="true"></i> <i
									class="fa fa-search" aria-hidden="true"></i> Search
							</button>
						</div>

					</div>



				</div>
				</form>
				<?php
					if(is_mz() && is_owner() && login_id() > 7000){
				?>
						<div style="font-size: 16px; color: red;">
							To access your previous messages from the previous site, Please click on this link <a href="http://sms.quickhostme.com" target="_blank">sms.quickhostme.com</a>. Thank You<br>
						</div><br><br>
				<?php
				}
				?>
				<div class="row">
					<div class="col-md-12" style="color: brown;">
								<?=empty($date1)?"Today ":"";?>SMS Cost = <b><?= format_wallet($total_cost); ?> (est: <?=amount_in_units($total_cost);?> Units)</b><br>
						<br>
					</div>
				</div>

				<div class="row">

					<!----TABLE LISTING STARTS-->
					<div class="col-md-12">

						<table data-server-side="<?= history_link(); ?>" data-totalrecords="<?= empty($history_count)?count($history):$history_count; ?>" class="table table-striped datatable history">
							<thead class="center">
							<tr>
								<th>#</th>
								<th>Date</th>
								<?php
								if(is_admin()) {
									?>
									<th>Username</th>
									<?php
								}
								?>
								<th>Sender ID</th>
								<th>Message</th>
								<th>Recipient</th>
								<th>Cost</th>
								<th>Method</th>
								<th>Option</th>
							</tr>
							</thead>
							<tbody>
							<?php

							$count = g("start") + 1;
							foreach ($history as $row):


								?>
								<tr>
									<td><?= $count++; ?></td>
									<td><span class="mydate"><?= convert_to_datetime($row['date']); ?></span></td>
									<?php
									if(is_admin()) {
										?>
										<td class="user">
										<?=c()->get_full_name(getIndex($all_users, $row['user_id']));?>
										</td>
										<?php
									}
									?>
									<td ><span class="sender"><?=$row['sender_id'];?></span></td>
									<td  >
										<div class="message" data-original-title="<?=pv(str_replace("\n","<br>",$row['message']));?>">
										<?=substr($row['message'], 0, 10);?>
											</div>
									</td>
									<td>
										<?php
										$num = explode(",",$row['numbers']);
										$c = count($num);
										if($c == 1)
											$y = $num[0];
										else
											$y = $num[0]."(".$c.")";
										?>
										<div class="recipient" data-count="<?=$c;?>" data-original-title="<?=pv(str_replace(",",", ",$row['numbers']));?>">
											<?php
											echo $y;
											?>
										</div>
									</td>
									<td>
										<span class="cost"><?=format_amount($row['totalcost'], -1);?></span>
									</td>
									<td>
									<span class="method" style="text-align: center" data-original-title="<?=$row['method'];?>"><?=substr($row['method'], 0, 15);?></span>
									</td>
									<td class="link" data-href="<?=url("message/report/$row[sent_id]");?>">
										<div class="btn-group">
											<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
												Options <span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-default pull-right" role="menu">

												<!-- EDITING LINK -->
												<li>
													<a href="javascript:void(0)" onclick="showModal(sent_messages(this), this)" class="modal_next">
														<i class="fa fa-eye" aria-hidden="true"></i> View Message
													</a>
												</li>
												<li class="divider"></li>

												<li>
													<a  ajax="true" class="forward" href="<?=url("message/bulksms/sent/$row[sent_id]");?>">
														<i class="fa fa-mail-forward" aria-hidden="true"></i>
														Forward
													</a>
												</li>


												<!-- DELETION LINK -->
												<?php
												if(is_admin() && hAccess("delete_message_history")) {
													?>
													<li class="divider"></li>						<li>
													<a href="javascript:void(0)" onclick="confirm_delete('<?=url("message/delete/$row[sent_id]");?>', this, true)">
														<i class="fa fa-trash" aria-hidden="true"></i>
														<?php echo get_phrase('delete');?>
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

					</div>

				</div>

			</div>
		</div>


	</div>
</div>



<script>
	function sent_messages(me){
		var tr = $(me).parents("tr").last();
		var tr2 = $(tr).prev();
		var date = $(tr).find(".mydate").text() || $(tr2).find(".mydate").text() ;
		var sender = $(tr).find(".sender").text() || $(tr2).find(".sender").text();
		var user = $(tr).find(".user").text() || $(tr2).find(".user").text();
		var message = $(tr).find(".message").data('original-title') || $(tr2).find(".message").data('original-title');
		var recipient = $(tr).find(".recipient").data("original-title") || $(tr2).find(".recipient").data("original-title");
		var recipient_count = $(tr).find(".recipient").data("count") || $(tr2).find(".recipient").data("count");
		var method = $(tr).find(".method").text() || $(tr2).find(".method").text();
		var cost = $(tr).find(".cost").text() || $(tr2).find(".cost").text();
		var link = $(tr).find(".link").data("href") || $(tr2).find(".link").data("href");
		var forward_link = $(tr).find(".forward").attr("href") || $(tr2).find(".forward").attr("href");

		this.forward = function(){
			var x = '<span style="padding: 2px 10px;" data-original-title="Forward" class="btn btn-sm btn-info" onclick="loadPage(\''+forward_link+'\'); hideAjaxmodal();"><i class="fa fa-mail-forward" aria-hidden="true"></i></span>';
			return x;
		};

		$msg = "<span onclick='nextModal()' class='btn btn-info btn-warning btn-sm pull-right' ><i class='fa fa-arrow-right'></i></span> ";
		$msg += "<span onclick='prevModal()' class='btn btn-info btn-warning btn-sm pull-leftg' ><i class='fa fa-arrow-left'></i></span> ";
		$msg +=	"<div class='preview_history'><b>DATE</b>: "+date+"<br>";

		if(!is_empty(user))
			$msg += "<b>USER</b>: "+user+"<br>";

		$msg += "<b>SENDER</b>: "+sender+"<br>"+
		"<b>MESSAGE</b>: "+message+"<br>"+
		"<b>METHOD</b>: "+method+"<br>"+
		"<b>COST</b>: "+cost+"<br>"+
		"<b>RECIPIENT</b>: <span>("+recipient_count+" Numbers)</span> " +
		"<button href='"+link+"' onclick='loadContainer(this, \"#delivery_report\")' class='btn btn-info btn-raised btn-sm' style='padding: 2px 10px;'> <i class='fa fa-envelope'></i> <i class='fa fa-refresh fa-spin inactive'></i> Load Delivery Report</button> "+this.forward()+" <br>"+
		"<div id='delivery_report'>" +
			"<a href='"+link+"' onclick='return loadContainer(this, \"#delivery_report\")' ><i class='fa fa-envelope'></i> Load Delivery Report</a><br>"+
		recipient+
		"</div></div>";


		return $msg;
	}
</script>