<?php
	$row = new process_array($message);

$sms = new sms();
$rate = $sms->get_display_rate();

$dnd_rate = $sms->get_display_rate(true);
?>

<div class="row">

	<div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">
		<div class="panel panel-primary b-w-0" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="entypo-plus-circled"></i>
						Send Bulk SMS
					</div>
				</div>


			<div class="panel-body">

				<?php echo form_open(url('message/bulksms/sendnow'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>




					<input type="hidden" name="id" value="<?=$row->get("id");?>" id="draft_id"/>
					<input type="hidden" name="session_token" value="<?=generate_session_token("sms");?>" id="session_token"/>

					<input type="hidden" name="function_all" value="process_sent"/>

				<div class="alert alert-success alert-dismissable inactive" id="alert_success">
					<span href="javascript:void(0)" class="close" onclick="$(this).parent().hide(100)" aria-label="close">&times;</span>
					<span class="alert_content"></span>
				</div>

				<div class="alert alert-danger alert-dismissable inactive" id="alert_error">
					<span href="javascript:void(0)" class="close" onclick="$(this).parent().hide(100)" aria-label="close">&times;</span>
					<span class="alert_content"></span>
				</div>


				<?php
				$prev = user_balance(login_id(), "previous_balance");
				$bal = user_balance();
				?>
<?php
$per_sms = per_sms();
$myrate = "";
$str = "";
				foreach($rate['national'] as $network => $price) {
				if($network == 'all'){
					$network = (count($rate['national'])==1?"All":"Other"). " Network";
					$myrate = format_wallet($price);
				}else{
				$network = strtoupper($network);
				}

				$str = "<li>".format_wallet($price)."</li>";
				}

				?>
						<div class="row">
								<div data-intro="Shows your current account balance and price per sms" class="col-sm-7 " style="color: black; margin-bottom: 10px; ">
									<span style="color: purple; font-size: 15px; text-decoration: undderline"><b>Balance:</b> <b id="bulksms_balance"><?=format_wallet($bal, -1);?> (est: <?=@number_format(@floor(parse_amount($bal)/$per_sms));?> Units)</b></span><br>
									<b>Charge Per SMS:-</b>
									<ul style="list-style: none; color: grey;  padding-left: 0px;">

										<?php
									echo $str;
										?>
									</ul>
									<b>DND Charge Per SMS:-</b>
									<ul style="list-style: none; color: grey;  padding-left: 0px;">

										<?php
										$mydndrate = "";

										foreach($dnd_rate['national'] as $network => $price) {
											if($network == 'all'){
												$network = (count($dnd_rate['national'])==1?"All":"Other"). " Network";
												$mydndrate = format_wallet($price);
											}else{
												$network = strtoupper($network);
											}
											?>
											<li><?=$network." ".format_wallet($price);?></li>
											<?php
										}

										?>
									</ul>
								</div>


							<?php
							if(!empty($prev)) {
								?>
								<div data-intro="Show your quicksms1 previous account balance before the migration." class="col-sm-5" style="color: black;">

								<span style="color: #2a0f03; font-size: 15px;" ><b style="text-decoration: underline">Previous Balance:</b> <b id="bulksms_previous_balance"><?=format_amount($prev,-1,"","");?> Units</b><br>
</span>									<b>Charge Per SMS:-</b>
									<ul style="list-style: none; color: dimgrey;  padding-left: 0px;">
										<li>1 unit to all Network</li>
</ul>
								</div>
								<?php
							}
							?>


						</div>


				<div class="row">

				</div>


				<div data-intro="Enter the Title of the Message" class="form-group">
						<label class="bmd-label-floating">Sender ID</label>
						<input name="sender_id" maxlength="11" id="sender_id" type="text"  value="<?=$row->get("sender");?>" class="form-control"/>
						<label class="bmd-help">Title of the message</label>
					</div>

				<div data-intro="Enter or Import the recipient contacts. Multiple Recipient can be separated with comma or enter" class="form-group" >
					<label class="bmd-label-floating">Recipient Number(s)</label>
					<textarea  rows="3" class="form-control mycontactimports" id="recipient" name="recipient"
					      onchange="count_recipient()"    onblur="count_recipient()"><?=$row->get("recipient");?></textarea>
					<label class="bmd-help">Multiple Numbers should be separated by comma, space or enter</label>
					<label id="recipient_count" class="bmd-help inverse-bmd-help" >0 Number(s)</label>
				</div>
				<div data-intro="Manage Recipient Number: You can save contacts for future use and also import when needed" class="form-group">
					<div onclick="save_contact()" style="padding: 0px 4px;" class="btn btn-sm btn-raised btn-info">
						Save Contact
					</div>
					<div data-catch="phonebook" onclick="showAjaxModal('<?=url("modal/popup/phonebook.contact_modal/");?>', null, this)" style="padding: 0px 4px; margin: 0px 5px;" class="btn btn-sm btn-raised btn-info">
						Import Contacts
					</div>
				</div>

				<div class="form-group" data-intro="Compose the message to be sent">
					<label class="bmd-label-floating">Message</label>
					<textarea rows="4" class="form-control" id="message" name="message"
					          onblur="count_message()" onkeyup="count_message()" onkeypress="count_message()" ><?=$row->get("message");?></textarea>
					<label  class="inverse-bmd-help bmd-help" id="message_count" style="width: 100%; opacity: 9; visibility: visible">0/160 1 SMS</label>
				</div>

				<div data-intro="Activate to send sms as a flash message." class="form-group" style="padding-top: 0px;">
					<label class="checkbox" data-original-title="Select to send SMS as <b>Flash SMS</b>">
						<input  type="checkbox"						       name="flash_sms" value="1"/>

						Flash Message
					</label>
					<i data-intro="Click to know what is a flash sms/message" class="fa fa-question-circle" style="margin-left: 7px; margin-top: 10px;" data-toggle="popover" data-content="A flash SMS message is an SMS message that, instead of being stored in the SIM or memory of the receiving phone, pops-up on the receiving phone's screen, without the user taking any action" aria-hidden="true"></i>

				</div>

				<div data-intro="Schedule your messages to deliver later" class="form-group" style="padding-top: 0px;">
					<label class="checkbox">
						<input name="scheduled" type="checkbox"
		onclick="show_schedule(this)"
						       value="1"/>

						Schedule Message to deliver Later
					</label>
				</div>

				<div class="inactive form-group" style="margin-top: -10px" id="schedule_date">
					<label class="bmd-label-floating">Delivery Date</label>
						<input  data-format="dd-MMM-yyyy hh:mm AA" name="schedule_date" data-field="datetime" type="text" class="form-control"   value=""/>

				</div>
				<div class="form-group" style="padding-top:15px; margin-bottom: -10px;">
				<b style="text-decoration: underline; color: green;">GATEWAY ROUTE/OPTION: <i class="fa fa-question-circle" style="margin-left: 7px;" data-toggle="popover" data-content="Gateway Option allow you to deliver message to DND numbers as well. Click on what is DND below to know more!" aria-hidden="true"></i></b>
</div>

					<div data-intro="<b>DND</b>:<BR>Select the first option <b>(Do Not Deliver to DND Numbers)</b> if you dont want to send sms to DND numbers.<br>To send sms to DND numbers as well, select the second option <b>(Deliver Also to DND Numbers)</b>" class="form-group">
						<label class="bmd-label-floating">DND (DO-NOT-DISTURB) NUMBERS</label>
						<select onchange="show_dnd()" name="route" class="form-control">
							<?php
								$array = array("Do Not Deliver to DND Number(s)", "Deliver Also to DND Numbers", "Send All Message through the DND route (Banking Route)");
								$default = user_data("route");
								foreach($array as $key => $value) {
									?>
								<option <?=p_selected($default, $key);?> value="<?=$key;?>" ><?=$value;?></option>
									<?php
								}
							?>
						</select>
					</div>

<div class="form-group" style="padding-top: 0px;">
					<a href="javascript:void(0)" data-intro="<b>Confused on What is DND? </b> click <a onclick='whatisdnd()'>here</a>" onclick="whatisdnd()">Click here to know What is DND?</a>
</div>
				<div data-intro="Show the estimated amount in Naira and Unit that you will be charged" class="col-md-12" style="color: red;">
					Estimated Total Cost: <b id="total_cost"></b><br><br>
				</div>
					<div class="col-md-12" align="center">

						<button name="save" class="btn btn-warning btn-raised">
							<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>
							<i class="fa fa-save" aria-hidden="true"></i> <span id="draft_name"><?=empty($message['id'])?"Save":"Re-Save";?></span>
						</button>
					<button type="submit" onclick="return sms_send(this)" ajax="true" name="send" class="btn btn-success btn-raised">
						<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-plane" aria-hidden="true"></i> Send Now
					</button>

				</div>

				</form>
			</div>
		</div>
	</div>

	</div>
<BR>
<BR>
<BR>
<BR>
<BR>

<script>

	$rate = <?=json_encode($sms->rate_array());?>;

	$number_network = <?=json_encode(network());?>;

	$per_sms = <?=empty($per_sms)?0:$per_sms;?>;


	function save_contact(){
		showAjaxModal("<?=url("modal/popup/phonebook.view_modal/0/save");?>", null, null, null, function(){
			$('#modal_ajax .modal-body [name=numbers]').val($("#recipient").val());
			$('#modal_ajax .modal-body [name=numbers]').blur()
		});
	}


	function filter_numbers() {
		$x = $("#recipient").val();
		$("#recipient").val(filter_local_numbers($x));
		calculate_airtime();
	}

	function show_schedule(me){
		if($(me).is(":checked")){
			$("#schedule_date").show(100);
		}else
			$("#schedule_date").hide(100);
	}

	var cost = 0;

	function count_recipient(){
		var num = $("#recipient").val();
		if(is_empty(num))
		return;
		var filter = filter_local_numbers(num, true);
//		debugger;
		var result = calculate_cost(filter, $rate);

		cost = result.cost;

		if(result.not_valid > 0 || result.duplicate > 0){
			var x = "Total No. = "+result.total_count;

			if(result.not_valid > 0)
					x += "<br>Invalid No. = "+result.not_valid;
			if(result.duplicate > 0)
					x += "<br>Duplicate No. = "+result.duplicate;
			if(result.national > 0)
					x += "<br>Valid No. = "+result.national;
			if(result.international > 0)
					x+= "<br>International No. = "+result.international;

			x = "<div align=center><div style='display: inline-block; width: auto;' align=left>"+x+"</div></div>";
			notifySuccess(x);
//			$("#recipient_count").attr("data-original-title", x);
//			others();
		};

		$("#recipient").val(result.numbers);

		var y = result.national + result.international + " Number(s)";
		$("#recipient_count").html(y);
		calculate_total_cost();
	}
	var sms_count = 0;
	function count_message(){
		var msg = $("#message").val();
		bulk_message.message = msg;
		$("#message_count").html(bulk_message.count());
		sms_count = bulk_message.sms_number();
		calculate_total_cost();
	}

	function calculate_total_cost(){
		var total = sms_count * cost;
		var str = format_numbers(total);
		if($per_sms > 0){
			var est = 0;
			try{
				est = total/$per_sms;
			}catch(e){}
			str += " (Est"+format_numbers(est," ")+" units)";
		}
		$("#total_cost").html(str);
	}

	function sms_send(me){
		if(is_empty($("#sender_id").val())){
			notifyError("Sender ID can not be empty");
			return false;
		}
		if(is_empty($("#recipient").val())){
			notifyError("Please provide at least one recipient number");
			return false;
		}
		if(is_empty($("#message").val())){
			notifyError("Cant send an empty message");
			return false;
		}
		confirm_dialog(me, 'Send Message Now!');
		return false;
	}

	function process_sent(response){
		$(".alert").hide();
		if(response.notification.errorType == "success"){
			$("#alert_success").show();
			$("#alert_success .alert_content").html(response.msg_response == undefined?response.notification.error_:response.msg_response);

		}else{
			$("#alert_error").show();
			$("#alert_error .alert_content").html(response.msg_response == undefined?response.notification.error_:response.msg_response);
		}
		if(!is_empty(response.session_token))
			$("#session_token").val(response.session_token);

		if(!is_empty(response.draft_id)) {
			$("#draft_id").val(response.draft_id);
			$("#draft_name").html("Re-Save");
		}

		if(!is_empty(response.balance)) {
			$("#bulksms_balance").html(response.balance);
		}

		if(!is_empty(response.previous_balance)) {
			$("#bulksms_previous_balance").html(response.previous_balance);
		}


	}

	function whatisthis(){
		var x = "We separated your previous balance because we have change the way we store our sms purchase. <br>Previously when you make payment, we convert it to units. You then use such units to send sms but now we leave your balance for you exactly the amount you paid.<br>The new format is to ease understanding and payment for other services like bill payment, airtime and data plan";
		my_alert(x);
		return false;
	}
	var x = $("[name=route]").click(function(){
		show_dnd();
	});
	function show_dnd(){
		var part_dnd = "You will be charged <?=$myrate;?> per sms to numbers not on DND and <?=$mydndrate;?> per sms to numbers that are on " +
			"DND";
		var full_dnd = "<?=$mydndrate;?> per sms to all numbers whether on DND or not";

		var route = $("[name=route]").val();
		if(route == 1){
			my_alert(part_dnd);
		}else if(route == 2){
			my_alert(full_dnd);
		}
	}



</script>