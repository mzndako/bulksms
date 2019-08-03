<?php
$version = 3340;

$CI =& get_instance();
$s_ = $this->session;
$d_ = $this->db;

$CI->load->library('user_agent');

$is_mobile = this()->agent->is_mobile();



$param1 = isset($param1) ? $param1 : "";
$param2 = isset($param2) ? $param2 : "";
$param3 = isset($param3) ? $param3 : "";

//$system_name = c()->get_setting('system_name');
$system_name = $system_title = c()->get_setting('cname');
$text_align = c()->get_setting('text_align');
$division = (int)c()->get_setting('division_id');
$account_type = $this->session->userdata('login_type');
$skin_color = c()->get_setting('skin_color');
$active_sms_service = c()->get_setting('active_sms_service');
$login_as = $this->session->userdata("login_as");
$login_id = $this->session->userdata("login_user_id");
$page_title = isset($page_title) ? $page_title : "";

$skin_color = empty($skin_color)?"red":$skin_color;

$response_result = array(
	'system_name' => $system_title,
	'title' => $page_title,
	'container' => "#my_content",
	'content' => "",
	'current_url' => updated_current_url(empty($parameters) ? "" : $parameters),
	'notification' => array("error" => $this->session->flashdata("flash_message"), "errorType" => "success")

);

$notify_alert = c()->show_notification($page_name);
if(!empty($notify_alert)){
	$notify_alert['message'] = format_notification($notify_alert['message']);
	c()->mark_notification($notify_alert['id'], "viewed");
}

$notify_dialog = c()->show_notification($page_name, 2);
if(!empty($notify_dialog)){
	$notify_dialog['message'] = format_notification($notify_dialog['message']);
	c()->mark_notification($notify_dialog['id'], "viewed");
}

if(!empty(login_id())) {
    record_last_activity(login_id(), 'Desktop/Mobile');
}

if (is_ajax()) {

	if (post_set("current_url")) {
		$response_result['current_url'] = p("current_url");
	}

	ob_start();
	include dirname(__DIR__).'/templates/' . $page_name . '.php';
	$content = ob_get_clean();

    $response_result['start_time'] = my_start_time();
    $response_result['end_time'] = time()."-".Date("H:i:s");

	$response_result['notification_alert'] = $notify_alert;
	$response_result['notification_dialog'] = $notify_dialog;

	$response_result['content'] = $content;

	if (post_set("container")) {
		$response_result['container'] = p("container");
	}

	$b = format_amount(!empty(login_id())?user_balance():0, -1);
	$bal = $b. "<span style='font-size: 10px;'> (est: ".@number_format(@floor(parse_amount($b)/per_sms()))." units)</span>";
	$response_result['balance'] = $bal;
	$response_result['version'] = $version;

	$this->session->set_flashdata("flash_message", "");

	if (!empty($just_print)) {
		print $content;
		print "<script>runPageHook()</script>";
	} else {
		print json_encode($response_result);
	}

	exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl'; ?>">
<head>

	<title><?php echo $page_title; ?> | <?php echo $system_title; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="Quicktel Solution"/>
	<meta name="author" content="mzndako"/>


	<?php include 'includes_top.php'; ?>

</head>
<body data-general-error="Error loading Page" class="<?php if ($skin_color != '') echo 'skin-' . $skin_color; ?>">
<!--	<div class="page-container --><?php //if ($text_align == 'right-to-left') echo 'right-sidebar';?><!--" >-->
<div class="wrapper">
	<?php include 'header.php'; ?>

	<script>
		window.pageLoadHooks = [];
		function addPageHook(hook) {
			window.pageLoadHooks.push(hook);
		}
		$is_mobile = <?=$is_mobile?"true":"false";?>;
		<?php
		if(!empty($notify_dialog)){
			?>
				addPageHook(function(){
					showDialogNotification("<?=$notify_dialog['title'];?>","<?=str_replace("\"", "\\\"", $notify_dialog['message']);?>", <?=$notify_dialog['id'];?>);
					return "destroy";
				});
			<?php
		}
 ?>
	</script>

	<?php include 'navigation.php'; ?>

	<div class="content-wrapper" style="min-height: 620px; background: white; padding-left: 10px;">

		<section class="content-header">
			<h1>
				<i class="entypo-right-circled"></i>
				<span class="my_title"><?php echo $page_title; ?></span>

			</h1>
			<!--				<ol class="breadcrumb">-->
			<!--					<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>-->
			<!--					<li class="active">Here</li>-->
			<!--				</ol>-->
		</section>
		<div class="row" >
			<div class="col-md-12">
				<?php

				?>
		<div class="alert alert-danger alert-dismissable <?=empty($notify_alert)?'inactive':'';?>" id="my_notification">
			<span href="javascript:void(0)" data-id="<?=getIndex($notify_alert, "id");?>" class="close" onclick="closeAlertNotification()" aria-label="close" style="color: white; opacity: 1">&times;</span>
			<span class="alert_content"><h4 class="title"  ><?=getIndex($notify_alert, 'title');?></h4>
				<span class="message"><?=getIndex($notify_alert, 'message');?></span>
			</span>
		</div>
			</div>
		</div>
		<div id="my_content" class="row" style="margin-left: 15px; margin-right: 15px;">

			<?php include dirname(__DIR__).'/templates/' . $page_name . '.php'; ?>
		</div>
		<?php
			if(is_hillary()) {
				?>
				<?php include dirname(__DIR__) . '/templates/quicklink.php';
			}
		?>
		<?php include 'footer.php'; ?>
		<!--			--><?php //include 'control_sidebar.php';?>
		<div id="dtBox"></div>

	</div>
	<?php //include 'chat.php';?>

</div>
<?php include 'modal.php'; ?>
<?php include 'includes_bottom.php'; ?>

</body>
</html>