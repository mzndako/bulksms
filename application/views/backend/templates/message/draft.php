<div class="row">
	<div class="col-md-12">

		<div class="panel panel-primary b-w-0" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-plus-circled"></i>
					DRAFT
				</div>
			</div>

			<div class="panel-body">
				<?php echo form_open(url('message/draft') , array('class' => '','target'=>'_top'));

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
							<input type="text" name="keyword" value="<?=$keyword;?>" class="form-control"/>
						</div>

						<?php
							if(is_admin()) {
//								$all_users = get_arrange_id("users", "id");
								$all_users = array();
								?>
								<div class="col-md-6 form-group">
									<label class="bmd-label-floating">Username</label>
									<select name="user_id" class="form-control">
										<option value="">All Users</option>
										<?php
											foreach($all_users as $user) {
												?>
											<option <?=p_selected($user['id'] == $user_id);?> value="<?=$user['id'];?>"><?=c()->get_full_name($user);?></option>
												<?php
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

				<div class="row">

					<!----TABLE LISTING STARTS-->
					<div class="col-md-12">

						<table class="table table-striped datatable history">
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
								<th>Option</th>
							</tr>
							</thead>
							<tbody>
							<?php

							$count = 1;
							foreach ($history as $row):


								?>
								<tr>
									<td><?= $count++; ?></td>
									<td class="date"><?= convert_to_datetime($row['date']); ?></td>
									<?php
									if(is_admin()) {
										?>
										<td class="user">
										<?=c()->get_full_name(getIndex($all_users, $row['user_id']));?>
										</td>
										<?php
									}
									?>
									<td class="sender"><?=$row['sender'];?></td>
									<td  >
										<div class="message" data-original-title="<?=pv(str_replace("\n","<br>",$row['message']));?>">
										<?=substr($row['message'], 0, 10);?>
											</div>
									</td>
									<td>
										<?php
										$num = explode(",",$row['recipient']);
										$num = empty($row['recipient'])?array():$num;
										$c = count($num);
										$y = "";
										if($c == 1)
											$y = $num[0];
										else if($c > 1)
											$y = $num[0]." (".$c.")";
										?>
										<div class="recipient" data-count="<?=$c;?>" data-original-title="<?=pv(str_replace(",",", ",$row['recipient']));?>">
											<?php
											echo $y;
											?>
										</div>
									</td>

									<td class="link" >
										<span data-original-title="View Message" class="btn btn-sm btn-success modal_next" onclick="showModal(draft_messages(this), this)" >
											<i class="fa fa-eye" aria-hidden="true"></i>
										</span>
										<span data-original-title="Forward" class="btn btn-sm btn-warning forward" href="<?=url("message/bulksms/draft/$row[id]");?>" onclick="loadPage('<?=url("message/bulksms/draft/$row[id]");?>')" >
											<i class="fa fa-mail-forward" aria-hidden="true"></i>
										</span>

												<span data-original-title="Delete" class="btn btn-sm btn-danger"
												      onclick="confirm_delete('<?=url("message/delete/$row[id]/draft");?>', this, true)">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</span>

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
	function draft_messages(me){
		var tr = $(me).parents("tr").last();
		var date = $(tr).find(".date").text();
		var sender = $(tr).find(".sender").text();
		var user = $(tr).find(".user").text();
		var message = $(tr).find(".message").data('original-title');
		var recipient = $(tr).find(".recipient").data("original-title");
		var recipient_count = $(tr).find(".recipient").data("count");
		var forward_link = $(tr).find(".forward").attr("href");

		this.forward = function(){
			var x = '<span style="padding: 0px 10px;" data-original-title="Forward" class="btn btn-sm btn-info" onclick="loadPage(\''+forward_link+'\'); hideAjaxmodal();"><i class="fa fa-mail-forward" aria-hidden="true"></i></span>';
			return x;
		};

		$msg = "<span onclick='nextModal()' class='btn btn-info btn-warning btn-sm pull-right' ><i class='fa fa-arrow-right'></i></span> ";
		$msg += "<span onclick='prevModal()' class='btn btn-info btn-warning btn-sm pull-leftg' ><i class='fa fa-arrow-left'></i></span> ";
		$msg +=	"<div class='preview_history'><b>DATE</b>: "+date+"<br>";

		if(!is_empty(user))
			$msg += "<b>USER</b>: "+user+"<br>";

		$msg += "<b>SENDER</b>: "+sender+"<br>"+
		"<b>MESSAGE</b>: "+message+"<br>"+
		"<b>RECIPIENT</b>: <span>("+recipient_count+" Numbers)</span> " +
		" "+this.forward()+" <br>"+
		"<div>"+
		recipient+
		"</div></div>";


		return $msg;
	}
</script>