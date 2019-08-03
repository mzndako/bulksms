<?php
this()->load->library("Billpayment");
    $bill = new mybill();
    $rate = $bill->rate(true);
    $col = "col-md-4 col-sm-6";
?>
<div class="col-md-12">


    <div  class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <?php
                if(false && is_mz() && is_owner()) {
                    ?>
                    <div class="alert alert-danger alert-dismissable" id="alert_error">
                        <span href="javascript:void(0)" class="close" onclick="$(this).parent().hide(100)"
                              aria-label="close">&times;</span>
                        <span class="alert_content">Site Upgrade is still on going as more features are being added. Please go ahead and start using our numerous features like buy 1GB MTN data for just N600. </span>
                    </div>
                    <?php
                }
            ?>
        </div>

        <?php
        if(is_mz() && is_owner()) {
            ?>
            <div class="<?=$col;?>">
                <div class="info-box" >
                    <span class="info-box-icon"><i class="template-color fa fa-question"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">NEED HELP??</span>
                    <span style="line-height: 1; font-size: 13px;" class="info-box-number">
                        Having any issues?? <br>
                        Call or Contact Us on Whatsapp Now


                    </span>
                        <a  href="whatsapp://send?phone=2349038781252&text=<?=urlencode("Need Help!\nMy username is ".c()->get_full_name(login_id())."");?>"
                           ><b><i class="fa fa-whatsapp"></i> 09038781252</b></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="<?=$col;?>">
            <div class="info-box"    onclick="loadPage('<?=url('wallet/fund');?>')">
                <span class="info-box-icon"><i class="template-color fa fa-money"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Account Balance</span>
                    <span style="line-height: 1" class="info-box-number"><?=format_amount(user_data("balance"), -1);?>
                        <br>
                       <span style="font-size: 12px;"> (Estimate: <?=format_number(balance_in_units(),0);?> Units)
</span>

                    </span>
                    <a ajax="true" data-intro="Click here to buy sms or recharge your account (Fund Wallet)" href="<?=url('wallet/fund');?>"><b>Recharge Account Now</b></a>
                </div>
            </div>
        </div>
        <?php
            if(is_hillary()) {
                ?>
                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Become a VIP Member</span>
                    <span style="line-height: 1.2; font-size: 13px;" class="info-box-number">
                        <?php
                            $active_phase = user_data("vip_package");
                            $phase_expires = floor((user_data("vip_expires") - time())/(3600*24));
                            $url = url('admin/dashboard/subscribe_phase');
                            $phase1_amount = get_setting("phase1_amount");
                            $phase1_period = get_setting("phase1_period");
                            $phase1 =  <<<eof
$phase1_amount for $phase1_period Months <a href="$url/1" onclick="return confirm_dialog(this,'Activate Phase 1 ($phase1_amount) for $phase1_period Months', '#my_content')">Subscribe</a>
eof;
                            if($active_phase == 1){
                                $phase1 = "Expires in $phase_expires Days";
                            }

                            $phase2_amount = get_setting("phase2_amount");
                            $phase2_period = get_setting("phase2_period");
                            $phase2 =  <<<eof
$phase2_amount for $phase2_period Months <a href="$url/2" onclick="return confirm_dialog(this,'Activate Phase 2 ($phase2_amount) for $phase2_period Months', '#my_content')">Subscribe</a>
eof;
                            if($active_phase == 2){
                                $phase2 = "Expires in $phase_expires Days";
                            }


                        ?>
                        Phase 1 = <?=$phase1;?><br>
                        Phase 2 = <?=$phase2;?><br>
                            <a href="javascript:void(0)" onclick='my_alert("<?= str_replace("\n","<br>",get_setting('phase_advantages')); ?>")'><b>Advantages</b></a>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <?php
            if(is_reseller() && is_admin()) {
                ?>
                <div class="<?=$col;?>">
                    <div class="info-box" onclick="loadPage('<?= url('wallet/fund'); ?>')">
                        <span class="info-box-icon "><i
                            class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Account Balance<br> with Provider</span>
                    <span  class="info-box-number">
                        <?php
                        d()->where("owner", owner);
                        $mine = d()->get("reseller")->row_array();
                        $id = getIndex($mine, "user_id");
                            d()->where("id", $id);
                        echo format_wallet(getIndex(d()->get("users")->row_array(), "balance"), -1);
 ?>

                    </span>

                        </div>
                    </div>
                </div>
                <?php
            }

            if(is_admin()) {
                ?>
                <div  class="<?=$col;?>">
                    <div class="info-box" onclick="loadPage('<?= url('wallet/fund'); ?>')">
                        <span class="info-box-icon "><i
                            class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">This Month Profit</span>
                    <span  class="info-box-number">
                        <?php
                        d()->where("date >=", strtotime(date("1-m-Y")));
                        d()->where("date <=", time());
//                        d()->where_in("bill_type", array("bill", "airtime", "dataplan"));
                        d()->where("status !=", "order_cancelled");
                        d()->select_sum("profit", "amount");
                        $row = c()->get("bill_history")->row_array();
                        echo format_wallet(getIndex($row, "amount")); ?>

                    </span>

                        </div>
                    </div>
                </div>
                <?php
            }
        $pv = (Float) user_data("previous_balance");
        if(!empty($pv) && $pv != -1) {
            ?>
            <div class="<?=$col;?>">
                <div class="info-box">
                    <span class="info-box-icon "><i class="template-color fa fa-university"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Previous Balance</span>
                        <span class="info-box-number"><?= $pv; ?> Units</span>
                        <a ajax="true" href="<?=url('wallet/fund');?>"><b>Recharge Account Now</b></a>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>



        <div class="<?=$col;?>">
            <div class="info-box" onclick="loadPage('<?=url('message/bulksms');?>')">
                <span class="info-box-icon "><i class="template-color fa fa-envelope-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Bulk SMS</span>
                    <span class="info-box-number" style="font-style: normal;">
                        Send Bulk SMS<br>

                    </span>
                    <a ajax="true" href="<?=url('message/bulksms');?>">Send Now</a>
                </div>
            </div>
        </div>

        <div class="<?=$col;?>">
            <div class="info-box" onclick="loadPage('<?=url('bill/buy_airtime');?>')">
                <span class="info-box-icon "template-color fa "><i class="template-color fa fa-credit-card"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">AIRTIME</span>
                    <span class="info-box-number" style="font-size: 12px; font-style: normal;">
                        Buy MTN, Glo, 9mobile and Airtel with discount<br>
                        <a ajax="true" href="<?=url('bill/buy_airtime');?>">Buy Now</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="<?=$col;?>">
            <div class="info-box" onclick="loadPage('<?=url('bill/buy_dataplan');?>')">
                <span class="info-box-icon"><i class="template-color fa fa-cloud-download"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Data Plan</span>
                    <span class="info-box-number" style="font-size: 12px; font-style: normal;">
                        Buy MTN, Glo, 9Mobile & Airtel Dataplan<br> <a ajax="true" href="<?=url('bill/buy_dataplan');?>">Buy Now</a><br>

                    </span>
                </div>
            </div>
        </div>

        <div class="<?=$col;?>">
            <div class="info-box" onclick="loadPage('<?=url('bill/pay');?>')">
                <span class="info-box-icon"><i class="template-color fa fa-paypal"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Bill Payment</span>
                    <span class="info-box-number" style="font-size: 12px; font-style: normal;">
                        Pay for DSTV, GoTv & Startime Subscription<br>
                        <a ajax="true" href="<?=url('bill/pay');?>">Pay Now</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="<?=$col;?>">
            <div class="info-box">
                <span class="info-box-icon "><i class="template-color fa fa-globe"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Last Login</span>
                    <span class="info-box-number" style="font-size: 12px; font-style: normal;"><?=user_data("last_ip2");?><br>
                        <?=convert_to_datetime(user_data("last_login2"));?>
                    </span>
                </div>
            </div>
        </div>

        <?php
            if(is_admin()) {
                ?>

                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon "><i class="template-color fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Members</span>
                    <span class="info-box-number"
                          style="font-style: normal;"><?= c()->count_all("users"); ?> Users
                    </span>
                        </div>
                    </div>
                </div>

                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon "><i class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Customers Balance</span>
                    <span class="info-box-number"
                          style="font-style: normal;"><?php
                        d()->select_sum("balance");
                        d()->where("is_admin", 0);
                        $row = c()->get("users")->row_array();
                        echo format_wallet(getIndex($row, "balance")); ?>
                    </span>
                        </div>
                    </div>
                </div>


                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon "><i class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">This Month Sales</span>
                    <span class="info-box-number"
                          style="font-style: normal;"><?php
                        d()->where("date >=", strtotime(date("1-m-Y")));
                        d()->where("date <=", time());

                        d()->where("bill_type", "fund_wallet");
                        d()->where("status", "completed");
                        d()->select_sum("amount_credited", "amount");
                        $row = c()->get("bill_history")->row_array();
                        echo format_wallet(getIndex($row, "amount")); ?>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon "><i class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">This Year Sales</span>
                    <span class="info-box-number"
                          style="font-style: normal;"><?php
                        d()->where("date >=", strtotime(date("1-1-Y")));
                        d()->where("date <=", time());
                        d()->where("bill_type", "fund_wallet");
                        d()->where("status", "completed");
                        d()->select_sum("amount_credited", "amount");
                        $row = c()->get("bill_history")->row_array();
                        echo format_wallet(getIndex($row, "amount")); ?>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="<?=$col;?>">
                    <div class="info-box">
                        <span class="info-box-icon "><i class="template-color fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number"
                          style="font-style: normal;"><?php
                        d()->where("bill_type", "fund_wallet");
                        d()->where("status", "completed");
                        d()->select_sum("amount_credited", "amount");
                        $row = c()->get("bill_history")->row_array();
                        echo format_wallet(getIndex($row, "amount")); ?>
                    </span>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>

    </div>
</div>
<br>

<center ><h4 style="font-weight: bold; text-decoration: underline;" >RECENT TRANSACTIONS</h4></center>
<div id="mybill_history" data-intro="Show Recent Transactions Below" >
    <?php
    d()->where("user_id", login_id());
    d()->order_by("date", "DESC");
    d()->limit(5);
    $bill_history = c()->get("bill_history")->result_array();
    include_once "bill/history_tab.php";
    ?>
</div>