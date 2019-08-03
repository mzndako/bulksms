<link rel="stylesheet" href="<?=assets_url("$theme_path/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/material_boostrap.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/font-icons/entypo/css/entypo.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/googlefont.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/bootstrap.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/neon-core.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/neon-theme.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/neon-forms.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/introjs.css");?>"/>
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/datetime/DateTimePicker.css");?>"/>
<!--<link rel="stylesheet" href="--><?php //assets_url("$theme_path/ckeditor/contents.css");?><!--"/>-->

<link rel="stylesheet" href="<?=assets_url("$theme_path/css/custom.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/mine.css?$version");?>?aaa">
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/mine_previous.css?$version");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/fullcalendar/fullcalendar.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/sweetalert2/dist/sweetalert2.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/summernote/dist/summernote.css");?>">

<link rel="stylesheet" href="<?=assets_url("$theme_path/adminlte/css/AdminLTE.min.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/adminlte/css/skins/_all-skins.css");?>">
<?php


    if ($skin_color != ''):?>
    <link rel="stylesheet" href="<?=assets_url("$theme_path/adminlte/css/skins/skin-$skin_color.css");?>">
    <?php endif;?>

<?php if ($text_align == 'right-to-left') : ?>
<!--    <link rel="stylesheet" href="<?=assets_url("$theme_path/css/neon-rtl.css");?>">-->
<?php endif; ?>

<script src="<?=assets_url("$theme_path/js/jquery-1.11.0.min.js");?>"></script>

        <!--[if lt IE 9]-->
        <script src='<?=assets_url("$theme_path/js/ie8-responsive-file-warning.js");?>'></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
<!--        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
<![endif]-->
<link rel="shortcut icon" href="<?=c()->get_image_url("favicon", "favicon");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/css/font-icons/font-awesome/css/font-awesome.min.css");?>">

<link rel="stylesheet" href="<?=assets_url("$theme_path/js/vertical-timeline/css/component.css");?>">
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/datatables/responsive/css/datatables.responsive.css");?>">
<!--<link rel="stylesheet" href="--><?//=assets_url("$theme_path/js/selectize/css/selectize.css");?><!--">-->
<!--<link rel="stylesheet" href="--><?//=assets_url("$theme_path/js/selectize/css/selectize.default.css");?><!--">-->
<link rel="stylesheet" href="<?=assets_url("$theme_path/js/selectize/css/selectize.bootstrap3.css");?>">


<!--Amcharts-->
<script src="<?php echo assets_url("$theme_path/js/amcharts/amcharts.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/pie.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/serial.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/gauge.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/funnel.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/radar.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/amexport.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/rgbcolor.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/canvg.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/jspdf.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/filesaver.js");?>" type="text/javascript"></script>
<script src="<?=assets_url("$theme_path/js/amcharts/exporting/jspdf.plugin.addimage.js");?>" type="text/javascript"></script>

<script>
    var currency = "<?=get_setting("currency", "N");?>";
</script>

<style>
    <?php $color = tcolor($skin_color); ?>

    .template-background, .panel-heading{
        /*background-color: */<?//=tcolor($skin_color);?>/* !important;*/
        background-color: #ebebeb !important;
        color: white !important;;
    }

    .panel-heading > .panel-title{
        color: black !important;;
    }

    .panel-heading .panel-title{
        /*border-color: */<?//=$color;?>/*;*/
        /*color: white !important;;*/
    }

    .panel{
        /*border-color: */<?//=$color;?>/* !important;*/
        /*border-radius: 2px;*/
        /*-webkit-box-shadow: 0 1px 25px 1px */<?//=$color;?>/*;*/
        /*box-shadow: 0 1px 15px 1px */<?//=$color;?>/*;*/
        /*box-shadow: 0 1px 15px 1px */<?//=$color;?>/*;*/
        /*margin-top: 10px;*/
    }

    .panel-body{
        padding: 5px 25px 20px 25px;
    }

    .template-color{
        /*color: */<?//=tcolor($skin_color);?>/* !important;*/
    }

    .template-hover:hover{
        /*opacity: 0.5 !important;*/
    }

    .table thead th{
        /*background: */<?//=$color;?>/* !important;*/
        background: #f5f5f6 !important;
        color: #6e6e70 !important;
    }

    .btn-template{
        /*background: */<?//=$color;?>/* !important;*/
        /*border-color: */<?//=$color;?>/* !important;*/
        /*color: white !important;*/
    }

    input[type="checkbox"]:checked:after, .checkbox input[type="checkbox"]:checked:after, .checkbox-inline input[type="checkbox"]:checked:after {
        /*background-color: */<?//=$color;?>/*;*/
        /*border-color: */<?//=$color;?>/*;*/
        /*border-color: */<?//=$color;?>/*;*/
    }

    .inactive{
        display: none;
    }

    <?php
        if(!$is_mobile || true){
 ?>
    .dataTables_wrapper {
        overflow-y: hidden !important;
        width: 100% !important;
        overflow-x: auto !important;
    }
    <?php
}

    if($is_mobile){
 ?>
    .mymenu:after {
        content: "MENU";
        position: absolute;
        top: 0px;
        left: 7px;
        font-size: 10px;
    }
    .myhelp:after {
        content: "HELP";
        position: absolute;
        top: 0px;
        left: 50px;
        font-size: 10px;
    }

    <?php
}

 ?>

    .introjs-tooltiptext{
        color: brown;
    }
    .sidebar-toggle:before{
        content: "" !important;;
    }
    .introDark{
        /*color: brown !important;;*/
    }
    .introjs-helperLayer{
        opacity: 0.7;
    }
</style>
