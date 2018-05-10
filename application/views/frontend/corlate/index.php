<?php

include_once 'config.php';
include_once 'default.config.php';

foreach($default as $key => $value){
    if(empty(c()->get_template_settings($key))){
        c()->set_template_settings($key, $value);
    }
}

$content = "";
$my404 = "my404.php";
//if(file_exists($param1.".php")){
//    $ok = 34;
//}else
if($param1 == ""){
    ob_start();
    include_once 'home.php';
    $content = ob_get_clean();
}else
    if(file_exists(__DIR__."/".$param1.".php")){
    ob_start();
    include_once __DIR__."/".$param1.".php";
    $content = ob_get_clean();
}elseif($param1 == "page" && !empty($param2)){
    d()->where("disabled", 0);
    d()->where("id", $param2);
    $page = c()->get("page")->row_array();
    if(!empty($page)){
        $content = "<section id='error' class='container'>".$page['content']."</section>";
        $page_title = $page['title'];
    }
}

if(empty($content) || isset($is_my404)) {
    $this->output->set_status_header('404');
    ob_start();
    include_once __DIR__."/".$my404;
    $content = ob_get_clean();
}


?>
<!DOCTYPE HTML>
<html>
<?php
include_once 'header.php';
?>
<body class="homepage">
<script>
        window.pageLoadHooks = [];
        function addPageHook(hook) {
            window.pageLoadHooks.push(hook);
        }
</script>

    <?php

    include_once 'menu.php';


    print $content;



    include_once 'footer.php';
    ?>

</body>
</html>

