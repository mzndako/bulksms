<?php

d()->where("id", $bill_id);
if(!is_admin()){
    d()->where("user_id", login_id());
}
$bill_history = c()->get("bill_history")->result_array();
if(empty($bill_history)){
    die("Invalid transaction ID");
}

d()->where("bill_history_id", $bill_id);
$epins = c()->get("epins")->result_array();

$title = "";
$description = "";
$type = "";

if(!empty($epins)){
    $category_id = $epins[0]['category'];
    d()->where("id", $category_id);
    $category = c()->get("epins_category")->row_array();

    if(!empty($category)) {
        $type = $category['name'];
        $description = $category['description'];

        d()->where("id", $category['parent_id']);
        $category = c()->get("epins_category")->row_array();
        if(!empty($category))
            $title = $category['name'];
    }
}

?>

<div id="exclude" align="center">
    <br/>
    <button onclick="window.print()" class="btn btn-success btn-raised">
        Print
    </button>
</div>
<br>
<div class="row">
    <?php
        foreach($epins as $row) {
            ?>
        <div class="col-xs-4">
            <div class="pins">
                <h3 style="color: brown; text-overflow: ellipsis; white-space: nowrap; width: 100%; overflow: hidden"><?=get_setting("cname");?></h3>
                <h4><?=$title;?> - <?=$type;?></h4>
                <?php
                    if(!empty($description)){
                        print "<i>$description</i><br>";
                    }
                ?>
                <i style="font-size: 10px;"><?=get_setting("caddress");?></i>

            </div>
        </div>
            <?php
        }
    ?>
</div>
<style>
    .pins{
        /*width: 100%;*/
        border: 1px solid grey;
        border-radius: 3px;
        margin: 5px;
        padding: 0px 5px;
    }

    @media print{
        #exclude{
            display: none;
        }
    }
</style>