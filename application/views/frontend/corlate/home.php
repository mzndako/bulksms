<?php
    if(!$is_mobile) {
        ?>
        <section id="main-slider" class="no-margin">
            <div class="carousel slide">
                <ol class="carousel-indicators">
                    <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#main-slider" data-slide-to="1"></li>
                    <li data-target="#main-slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">

                    <div class="item active" style="background-image: url(<?php
                    $x = c()->get_template_image_url("image1");
                    echo $x;
                    ?>)">
                        <div class="container">
                            <div class="row slide-margin">
                                <div class="col-sm-6">
                                    <div class="carousel-content">
                                        <?= c()->get_template_settings("slide1"); ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 hidden-xs animation animated-item-4">
                                    <div class="slider-img">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/.item-->

                    <div class="item" style="background-image: url(<?= c()->get_template_image_url("image2");; ?>)">
                        <div class="container">
                            <div class="row slide-margin">
                                <div class="col-sm-6">
                                    <div class="carousel-content">
                                        <?= c()->get_template_settings("slide2"); ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!--/.item-->

                    <div class="item" style="background-image: url(<?= c()->get_template_image_url("image3");; ?>)">
                        <div class="container">
                            <div class="row slide-margin">
                                <div class="col-sm-6">
                                    <div class="carousel-content">
                                        <?= c()->get_template_settings("slide3"); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/.item-->
                </div>
                <!--/.carousel-inner-->
            </div>
            <!--/.carousel-->
            <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
                <i class="fa fa-chevron-left"></i>
            </a>
            <a class="next hidden-xs" href="#main-slider" data-slide="next">
                <i class="fa fa-chevron-right"></i>
            </a>
        </section><!--/#main-slider-->
        <?php
    }else{

        if(!is_login()){
?>
        <?php echo form_open(url('login/login'), array('class' => ' form-groups-bordered attached','target'=>'_top'));
            ?>
            <div class="rdow">
                <div class="col-md-12">

                        <a href="<?=url('login/login');?>" style="display:block; font-size: 18px; font-weight: bold; margin-top: 20px; margin-bottom: -10px;">LOGIN DETAILS:</a>

                    <div class="form-group" >
                        <label class="bmd-label-floating">Phone or Email</label>
                        <input type="text" name="username" required value="" class="form-control"/>
                    </div>

                    <div class="form-group" >
                        <label class="bmd-label-floating">Password</label>
                        <input type="password" name="password" value="" required class="form-control"/>
                    </div>

                    <div class="col-md-12">
                      <div class="checkbox">
                        <label data-original-title="Check to always keep you login">
                            <input type="checkbox" name="remember" checked value="1"/> Remember Me
                        </label>
                    </div>
                    <div>

                        <a href="<?=url('login/register');?>">Create Account</a>
</div>
                        <a href="<?=url('login/recover');?>">Password Recovery</a>
                    </div>
                    <div align="center" class="col-md-12">
                        <input type="submit" value="Login" class="btn btn-success" />

                    </div>
                    <br>
                </div>
            </div>
            </form>
<?php
    }else{
?>

        <div class="row">
        <div class="col-sm-12" align="center"><h2 STYLE="text-decoration: underline; color: purple;"><?=get_setting("site_name");?> SERVICES</h2></div>

<div class="col-xs-12" align="left" style="color: brown; padding: 5px 30px;;">
    BALANCE: <b><?=format_wallet(user_balance(), -1);?></b>
    (Estimated: <b><?=format_number(balance_in_units(), 0);?> Units</b>)<br>
    <?php
        if(user_balance(null, "previous_balance") > 0){
    ?>
    PREVIOUS BALANCE: <b><?=user_balance(null, "previous_balance");?> Units</b><BR>
    <?php
    }
 ?>
</div>
            <div class="col-xs-6" align="center">
            <a href="<?=url("message/bulksms");?>" >
                <i class="fa fa-envelope fa-3x" aria-hidden="true"></i><br>
                Send Bulk SMS
                </a>
            </div>

            <div class="col-xs-6" align="center">
            <a href="<?=url("bill/buy_airtime");?>" >
                <i class="fa fa-credit-card fa-3x" aria-hidden="true"></i><br>
                Buy Airtime
                </a>
            </div>


            <div class="col-xs-6" align="center" style="margin-top: 10px;">
            <a href="<?=url("bill/buy_dataplan");?>" >
                <i class="fa fa-bars fa-3x" aria-hidden="true"></i><br>
                Buy DataPlan
                </a>
            </div>

            <div class="col-xs-6" align="center" style="margin-top: 10px;">
            <a href="<?=url("bill/pay");?>" >
                <i class="fa fa-home fa-3x" aria-hidden="true"></i><br>
                Pay Bills
                </a>
            </div>

            <div class="col-xs-6" align="center" style="margin-top: 10px;">
            <a href="<?=url("bill/history");?>" >
                <i class="fa fa-share fa-3x" aria-hidden="true"></i><br>
                Transaction History
                </a>
            </div>
            <div class="col-xs-6" align="center" style="margin-top: 10px;">
            <a href="<?=url("wallet/fund");?>" >
                <i class="fa fa-archive fa-3x" aria-hidden="true"></i><br>
                Recharge Account
                </a>
            </div>



        </div>
<?php
    }
    }
?>

<section id="feature" style="padding-top: 50px;" >
        <div class="container">
           <div class="center wow fadeInDown">
               <h2 style="font-size: 23px;"><?=c()->get_template_settings("welcome_title");?></h2>


               <p class="lead"><?=c()->get_template_settings("welcome_content");?></p>
           </div>


        </div><!--/.container-->
    </section><!--/#feature-->



    <section id="services" class="service-item">
	   <div class="container">
            <div class="center wow fadeInDown">
                <h2>Our Service</h2>
                <p class="lead">We provide the following services</p>
            </div>

           <div class="row">
               <div class="features">
                   <div class="col-md-4 col-sm-6 wow fadeInDown" style="cursor: pointer;" onclick="window.location = '<?=url('message/bulksms');?>'" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-envelope-o"></i>
                           <h2>Bulk SMS</h2>
                           <h3>Send Bulk SMS easily at very low price</h3>
                       </div>
                   </div><!--/.col-md-4-->

                   <div class="col-md-4 col-sm-6 wow fadeInDown"  style="cursor: pointer;" onclick="window.location = '<?=url('bill/buy_airtime');?>'" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-credit-card"></i>
                           <h2>Buy Airtime</h2>
                           <h3>Buy MTN, Glo, Etisalat and 9mobile airtime</h3>
                       </div>
                   </div><!--/.col-md-4-->

                   <div class="col-md-4 col-sm-6 wow fadeInDown"  style="cursor: pointer;" onclick="window.location = '<?=url('bill/buy_dataplan');?>'" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-cloud-download"></i>
                           <h2>Buy DataPlan</h2>
                           <h3>Buy Dataplan for MTN, Glo, Etisalat and 9mobile</h3>
                       </div>
                   </div><!--/.col-md-4-->

                   <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-leaf"></i>
                           <h2>Pay Bill</h2>
                           <h3>Pay for DSTV, GoTV and Startimes Subscription</h3>
                       </div>
                   </div><!--/.col-md-4-->

                   <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-cogs"></i>
                           <h2>Developer/API</h2>
                           <h3>Use our robost api to use our services</h3>
                       </div>
                   </div><!--/.col-md-4-->

                   <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                       <div class="feature-wrap">
                           <i class="fa fa-heart"></i>
                           <h2>Reseller</h2>
                           <h3>Set up your own website to reseller our service FREE</h3>
                       </div>
                   </div><!--/.col-md-4-->
               </div><!--/.services-->
           </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->


<style>
    .features h3{
        color: white;
    }
</style>



    <section id="conatcat-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="media contact-info wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="pull-left">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <h2>Have a question or need a custom quote?</h2>
                            <p>You can contact us  <?=c()->get_template_settings("phone");?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section><!--/#conatcat-info-->