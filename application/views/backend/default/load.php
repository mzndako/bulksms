<?php
$version = 3340;

$CI =& get_instance();

$CI->load->library('user_agent');

$is_mobile = this()->agent->is_mobile();
$s_ = s();
$d_ = d();
$c_ = c();
	$system_name        =	c()->get_setting('cname');
	$system_title       =	c()->get_setting('cname');
	$text_align         =	c()->get_setting('text_align');
	$division         	=	(int) c()->get_setting('division_id');
	$account_type       =	$this->session->userdata('login_type');
	$skin_color        =   c()->get_setting('skin_color');
	$active_sms_service =   c()->get_setting('active_sms_service');
	$login_as = s()->userdata("login_as");
	$login_id = login_id();

$param1 = isset($param1) ? $param1 : "";
$param2 = isset($param2) ? $param2 : "";
$param3 = isset($param3) ? $param3 : "";

$page_title = isset($page_title) ? $page_title : "";

$theme = get_setting("current_backend_theme");
$theme = empty($theme)?"default":$theme;
$theme_path = "backend/$theme";

	?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
	
	<title><?php echo $page_title;?> | <?php echo $system_title;?></title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Quicktel Solution" />
	<meta name="author" content="mzndako" />
	
	

	<?php include 'includes_top.php';?>
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
</head>
<body class="<?php if ($skin_color != '') echo 'skin-' . $skin_color;?>" >
<!--	<div class="page-container --><?php //if ($text_align == 'right-to-left') echo 'right-sidebar';?><!--" >-->




<?php include dirname(__DIR__).'/templates/' . $page_name . '.php'; ?>

<!--    --><?php //include 'includes_bottom.php';?>

</body>
</html>