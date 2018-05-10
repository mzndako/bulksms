<script src="<?=assets_url("$theme_path/js/jquery.js");?>"></script>
<section id="bottom">
    <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
        <div class="row">
            <?=c()->get_template_settings("footer");?>
        </div>
    </div>
</section><!--/#bottom-->

<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2017 <a target="_blank" href="http://<?=c()->get_template_settings("domain_name");?>/" title=""><?=c()->get_template_settings("site_name");?></a>. All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <li><a href="<?=url();?>">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Faq</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer><!--/#footer-->

<?php
$notify_dialog = array();
if(is_login()) {
    $notify_dialog = c()->show_notification("homepage", "homepage");
    if (!empty($notify_dialog)) {
        c()->mark_notification($notify_dialog['id'], "viewed");
    }
}
if(empty($notify_dialog) && get_setting("hp_notification_enabled") == 1){
    $notify_dialog['title'] = get_setting("hp_notification_title");
    $notify_dialog['message'] = get_setting("hp_notification_message");
    if((get_setting("hp_notification_show_once") == 1 && s()->userdata("frontpage_visited") == 1) || empty($notify_dialog['message'])){
        $notify_dialog = array();
    }

}
?>
<script>
    function show_register(){
        window.location = "<?=url('login/register');?>";
    }

    function show_login(){
        $("#modal_login").modal("show");
    }

    $(document).ready(function(){
        <?php
            if(!empty($notify_dialog)){
        ?>
        $("#modal_alert").modal("show");
        <?php
        }
        ;?>
    });
</script>

<?php
    $color = c()->get_template_settings("top_header1");
    $bg = empty($color)?"black":$color;

?>

<div class="modal fade" id="modal_login">
    <div class="modal-dialog" style="max-width: 400px; margin-top: 100px;">
        <div class="modal-content"  >

            <div class="modal-header" style="background-color: <?=$bg;?>">
                <button type="button" class="close" data-dismiss="modal" style="color: white;" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center; color: white;">Please Enter Login Details</h4>
            </div>
            <?php echo form_open(url('login/login'), array('class' => ' form-groups-bordered attached','target'=>'_top'));
            ?>
            <div class="row" style="padding: 10px;">
                <div class="col-md-12">
                    <div class="form-group" >
                        <label class="bmd-label-floating">Phone or Email</label>
                        <input type="text" name="username" required value="" class="form-control"/>
                    </div>

                    <div class="form-group" >
                        <label class="bmd-label-floating">Password</label>
                        <input type="password" name="password" value="" required class="form-control"/>
                    </div>
                    <div class="checkbox">
                        <label data-original-title="Check to always keep you login">
                            <input type="checkbox" name="remember" value="1"/> Don't Log me out automatically
                        </label>
                    </div>

                    <div>

                        <a href="<?=url('login/register');?>">Create Account</a>
                    </div>
                    <a href="<?=url('login/recover');?>">Password Recovery</a>
                </div>
                    <div align="center" class="col-md-12">
                        <input type="submit" class="btn btn-success" value="Login" />

                    </div>
                <br>
                </div>
            </div>
            </form>



            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">

            </div>

        </div>
    </div>


<div class="modal fade" id="modal_alert">
    <div class="modal-dialog" style="max-width: 400px; margin-top: 50px;">
        <div class="modal-content"  >

            <div class="modal-header" style="background-color: <?=$bg;?>">
                <button type="button" class="close" data-dismiss="modal" style="color: white;" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center; color: white;"><?=getIndex($notify_dialog, "title");?></h4>
            </div>
            <div class="modal-body">
                <?=getIndex($notify_dialog, "message");?>
            </div>
            <div class="modal-footer" style=" margin:0px; border-top:0px; text-align:center;">
                <button class="btn btn-info" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>



    </div>
</div>

</div>


<script src="<?=assets_url("$theme_path/js/bootstrap.min.js");?>"></script>
<script src="<?=assets_url("$theme_path/js/jquery.prettyPhoto.js");?>"></script>
<script src="<?=assets_url("$theme_path/js/jquery.isotope.min.js");?>"></script>
<script src="<?=assets_url("$theme_path/js/main.js");?>"></script>
<script src="<?=assets_url("$theme_path/js/wow.min.js");?>"></script>
<script src="<?=assets_url("backend/default/js/mine.js");?>"></script>
<?php
    s()->set_userdata("frontpage_visited", 1);
?>