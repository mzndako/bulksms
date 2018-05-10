<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("debit_user") && !hAccess("credit_user"))
    die("Access Denied");



    d()->where("id", $param1);
    $edit_data = c()->get('users')->result_array();
    $update = "update";


if(empty($pg)){
    this()->load->library("PaymentMethods");
    $pg = new PaymentMethods();
    $pg->load_classes();
}
$airtime_fee = $pg->get_setting("airtime_transaction_fee");



foreach ( $edit_data as $row):
    $array = new process_array($row);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        Update User Account
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <?php echo form_open(url('users/options/update_balance'.construct_url($param1)) , array('class' => ' validate','target'=>'_top'));?>

                <input type="hidden" name="container" value="<?=showAjaxModalTag();?>" />
                <input type="hidden" name="current_url" value="" />
                <input type="hidden" name="dont_hide_ajax_modal" value="true" />

                <div class="row">
                    <div class="col-sm-6">
                        Total Amount Credited: <b><?=format_amount($array->get('total_units'));?></b><br>
                        <b>Current Balance: <b style="color: blue;"><?=format_amount($array->get('balance'));?></b></b><br><br>
                        <b>Debt: <b style="color: red;"><?=format_amount($array->get('debt'));?></b></b><br><br>
                        Last Amount Credited: <span style="color: black;"><?php
                            d()->where("user_id", $row['id']);
                            d()->where("bill_type", "fund_wallet");
                            d()->where("status", "Completed");
                            d()->order_by("date", "DESC");
                            $res = c()->get("bill_history")->row_array();
                            if(!empty($res)){
                                echo format_wallet($res['amount_credited']);
                            }else{
                                echo "--";
                            }
                            ;?></span><br>
                        Date: <span style="color: black;"><?php
                            if(!empty($res)){
                                echo "".convert_to_datetime($res['date']);
                            }else{
                                echo "--";
                            }
                            ?></span>
                        <hr>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        print "Name: <b>$row[fname] $row[surname]</b><br>";
                        if(!empty($row['username'])){
                            print "Username: <b>$row[username]</b><br> ";
                        }
                        if(!empty($row['email'])){
                            print "Email: <b>$row[email]</b><br> ";
                        }
                        if(!empty($row['phone'])){
                            print "Phone: <b>$row[phone]</b><br>";
                        }


                        ?></div>
                </div>



<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="bmd-label-floating">Action</label>
            <select class="form-control" onchange="this.value == 'credit'?$('.myaction').show(100):$('.myaction').hide(100)" name="action">
                <?php
                if(hAccess("credit_user"))
                    print "<option value='credit'>Credit User</option>";
                if(hAccess("debit_user"))
                    print "<option value='debit'>Debit Member</option>";
                ?>
            </select>
        </div>
    </div>

    <?php
        if(!is_admin($param1)) {
            ?>
            <div class="col-sm-6 myaction">
                <div class="form-group">
                    <label class="bmd-label-floating">Payment Method</label>
                    <select name="method" id="method" onchange="method_changed()" required
                            class="form-control" <?= !empty($method) ? "disabled" : ""; ?> >
                        <?php
                        //                $users =
                        $payment = pay()->get_enabled_methods();
                        $default = empty($method) ? "bank" : $method;
                        foreach ($payment as $key => $value):
                            if ($key == "wallet" || $key == "atm")
                                continue;
                            $s = $key == "bank" ? "selected" : "";
                            ?>
                            <option <?= $s; ?> value="<?php echo $key; ?>">
                                <?= $value; ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                        <option value="debt">Debt</option>
                    </select>
                </div>
            </div>
            <?php
        }
 ?>
</div>


                <div>
                    <div class="checkbox checkbox-secondary">
                    <label><input type="checkbox" checked name="send_mail" value="1" /> Send Email Notification</label>
                    </div>
                    <div class="checkbox checkbox-secondary">
                    <label><input type="checkbox" checked name="send_sms" value="1" /> Send SMS Notification</label><br>
                    </div>
                </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Amount</label>
                        <input type="text" id="amount" onblur="calculate_fee()" onkeyup="calculate_fee()" required name="amount" maxlength="50" value="" class="form-control number"/>
                 </div>




                <div class="row myaction <?=is_admin($param1)?"inactive":"";?>">
                        <div class="col-sm-6" >
                            <div class="form-group">
                                <label class="bmd-label-floating">Transaction Fee</label>
                                <input type="text" name="tf" class="form-control number" id="tf" value="" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Total Amount</label>
                                <input type="text" class="form-control number" id="send_amount_input" readonly name="send_amount" value="" />
                            </div>
                        </div>

                </div>

                <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" onclick="return confirm_dialog(this , 'Update User Account')" class="btn btn-success btn-raised">Update Account</button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <?php
endforeach;
?>
<script>
//    addPageHook(function () {
//        $("[type=checkbox]").trigger("change");
//        return 'destroy';
//    });

    var airtime_tf = '<?=$airtime_fee;?>';

    function method_changed(){
        calculate_fee();
    }

    function calculate_fee(){
        var method = $("#method").val();
        var amount = parse_number($('#amount').val());

        if(method == "airtime") {
            var fee = parse_number(calculate_airtime_fee(airtime_tf, amount, method));
            $("#tf").attr("readonly", true);
            $("#tf").val(format_numbers(amount - fee));
            $("#tf").blur();
            $("#send_amount_input").val(fee);
        }else{
            $("#tf").removeAttrs("readonly");
            var tf = parse_number($("#tf").val());
            $("#send_amount_input").val(format_numbers(amount - tf));
        }
    }



</script>



