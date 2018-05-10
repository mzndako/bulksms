<?php
    $sms = new sms();
    $rate = $sms->get_display_rate();

    $bill = new mybill();
    $bill_rate = $bill->rate(true, true);
$x = 0;
?>
<section class="pricing-page">
    <div class="container">
        <div class="center">
            <h2>Pricing Table</h2>
            <p class="lead"></p>
        </div>
        <div class="pricing-area text-center">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-2 plan price-one wow fadeInDown">
                    <ul>
                        <li class="heading-one">
                            <h1>Bulk SMS</h1>
                        </li>
                        <?php
                            foreach($rate['national'] as $network => $price) {
                                if($network == 'all'){
                                    $network = (count($rate['national'])==1?"All":"Other"). " Network";
                                }else{
                                    $network = strtoupper($network);
                                }
                                ?>
                                <li><?=$network." ".format_wallet($price);?></li>
                                <?php
                            }
                        ?>

                        <li class="plan-action">
                            <a href="<?=url('login/register');?>" class="btn btn-primary">Sign up</a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-4 col-sm-offset-1 plan price-two wow fadeInDown">
                    <ul>
                        <li class="heading-two">
                            <h1>Airtime</h1>
                            <span>Percentage Commission</span>
                        </li>
                        <?php
                        if(is_array($bill_rate['airtime']))
                        foreach($bill_rate['airtime'] as $network => $price) {
                                $network = strtoupper($network);
                            ?>
                            <li><?=$network." ".$price;?></li>
                            <?php
                        }
                        ?>
                        <li class="plan-action">
                            <a href="<?=url('login/register');?>" class="btn btn-primary">Sign up</a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-4 plan price-three wow fadeInDown">
                    <img src="images/ribon_one.png">
                    <ul>
                        <li class="heading-three">
                            <h1>Dataplan</h1>
                            <span>Amount</span>
                        </li>
                        <li>Click to Expand</li>

                            <div class="accordion">
<?php
if(is_array($bill_rate['dataplan']))
                        foreach($bill_rate['dataplan'] as $airtime=> $dataplan){
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion_<?=$airtime;?>">
                                            <?=strtoupper($airtime);?> Network
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="accordion_<?=$airtime;?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>

                                <?php
                            foreach($dataplan as $unit => $amount) {
                                $unit = bill()->convert_to_mb($unit);

                                print "<li>";
                                print     strtoupper($airtime) . " ($unit) ".format_wallet($amount)." </li>";
                            }
                                ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                       <?PHP
                        }
?>

</div>


                        <li class="plan-action">
                            <a href="<?=url('login/register');?>" class="btn btn-primary">Sign up</a>
                        </li>
                    </ul>

</div>



                <div class="col-sm-4 plan price-four wow fadeInDown">

                    <ul>
                        <li class="heading-four">
                            <h1>Bill Payment</h1>
                            <span>Subscription</span>
                        </li>
                        <li>Click to Expand</li>

                        <div class="accordion">
                            <?php
                            if(is_array($bill_rate['bill']))
                                foreach($bill_rate['bill'] as $airtime=> $dataplan){
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion_<?=$airtime;?>">
                                                    <?=strtoupper($airtime);?> Subscription
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="accordion_<?=$airtime;?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul>

                                                    <?php
                                                    foreach($dataplan as $unit => $amount) {

                                                        print "<li>";
                                                        print     strtoupper($airtime) . " ($unit) ".format_wallet($amount)." </li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?PHP
                                }
                            ?>

                        </div>


                        <li class="plan-action">
                            <a href="<?=url('login/register');?>" class="btn btn-primary">Sign up</a>
                        </li>
                    </ul>

                </div>

                <div class="col-sm-6 col-sm-4 plan price-six wow fadeInDown">
                    <ul>
                        <li class="heading-six">
                            <h1>Reseller</h1>
                            <span>Free</span>
                        </li>
                        <li>Free Setup</li>
                        <li>Free Hosting</li>
                        <li>Domain Name N4,200 (Optional)</li>

                        <i style="color: black;">To begin create an account and contact us</i>
                        <li class="plan-action">
                            <a href="<?=url('login/register');?>" class="btn btn-primary">Sign up</a>
                        </li>
                    </ul>
                </div>


            </div>
        </div><!--/pricing-area-->
    </div><!--/container-->
</section><!--/pricing-page-->