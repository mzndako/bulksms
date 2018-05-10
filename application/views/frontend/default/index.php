<?php

include __DIR__.'/config.php';

$content = "";
$my404 = "my404.php";
if($param1 == ""){
	ob_start();
	include_once 'home.php';
	$content = ob_get_clean();
}elseif(file_exists($param1.".php")){
	ob_start();
		include_once $param1.".php";
	$content = ob_get_clean();
}elseif($param1 == "page" && !empty($param2)){
	d()->where("disabled", 0);
	d()->where("id", $param2);
	$page = c()->get("page")->row_array();
	if(!empty($page)){
		$content = $page['content'];
		$page_title = $page['title'];
	}else{
		$content = c()->get_template_settings($param2, getIndex($default, $param2));
	}

	if(!empty($content)) {
		$content = "<div style='padding: 50px 20px;'>$content</div>";
	}
}elseif($param1 == ""){

}

if(empty($content) || isset($is_my404)) {
	$this->output->set_status_header('404');
	ob_start();
	include_once $my404;
	$content = ob_get_clean();
}


?>
<!DOCTYPE html>
<html>
<?php
include_once 'header.php';
?>
<body>
<div class="ubea-loader"></div>
<div id="page" style="padding-top: 71px;">
<?php

include_once 'menu.php';


print $content;



include_once 'footer.php';
?>
	</div>
</body>
</html>

