<?php
$bill = new mybill();
$rate = $bill->rate(true, true);
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary b-w-0" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    Buy E-Pins
                </div>
            </div>

            <div class="panel-body">

                <?php echo form_open(url('bill/buy_epins'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>

                <div class="form-group" >
                    <label class="bmd-label-floating">Epins:</label>
                    <select name="epin" onchange="show_epin_type(); calculate_epin()" class="form-control" id="epin">
                        <?php
                        d()->where("parent_id", 0);
                        $bills = c()->get("epins_category")->result_array();
                        foreach ($bills as $row):
                            ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?= strtoupper($row['name']) . ""; ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Pin Type</label>
                    <select name="epin_type" onchange="calculate_epin()" class="form-control" id="epin_type">

                    </select>
                </div>


                <div class="form-group">
                    <label class="bmd-label-floating">Quantity</label>
                    <input type="number" min="1" onchange="calculate_epin()" onkeypress="calculate_epin()" id="quantity" name="quantity" value="1" class="form-control"/>

                </div>

                <div class="form-group fixed-focused">
                    <label class="bmd-label-floating">Amount to Pay</label>
                    <input type="text" disabled id="total" name="amount_pay" value="0" class="form-control"/>

                </div>


                <div class="form-group">
                    <label class="bmd-label-floating">Payment Method</label>
                    <select name="method" required class="form-control">
                        <?php
                        //                $users =
                        $payment = pay()->get_enabled_methods();
                        foreach ($payment as $key => $value):
                            ?>
                            <option value="<?php echo $key; ?>">
                                <?= $value; ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>


                <div class="col-md-12" align="center">
                    <button type="submit" class="btn btn-success btn-raised">
                        Proceed
                    </button>
                </div>
                </form>
            </div>
        </div>


    </div>
    <div class="col-md-2 col-lg-3" style="padding: 10px; font-size: 14px; color: brown;">

    </div>
</div>
<center><h4 style="font-weight: bold; text-decoration: underline;">E-PIN TRANSACTION HISTORY</h4></center>
<div id="mybill_history">
    <?php
    $history_bill_type = "epin";
    d()->where("bill_type", $history_bill_type);
    d()->where("user_id", login_id());
    d()->order_by("date", "DESC");
    d()->limit(10);
    $bill_history = c()->get("bill_history")->result_array();
    include_once "history_tab.php";
    ?>
</div>
<script>

    $epins = <?php
            d()->where("active", 1);
            $all_epins = c()->get("epins_category")->result_array();
            $arranged = [];
            foreach ($all_epins as $row){
                $arranged[$row['parent_id']][] = $row;
            }

    echo json_encode($arranged);?>;



    function filter_numbers() {
        $("#recipient").val(filter_local_numbers($x));
        calculate_dataplan();
    }

    function show_epin_type(){
        var epin = $("#epin").val();
        try{
            $("#epin_type").html("");
            $.each($epins[epin], function($index, $row){
                $xx = $("<option></option>");
                $xx.val($row['id']);
                $xx.attr("amount", $row['amount']);
                $xx.html($row['name']);
                $("#epin_type").append($xx);
            });
        }catch(e){
            console.log(e);
        }
        $("#epin_type").select2();

        if($is_mobile)
            $(".select2-search, .select2-focusser").remove();
    }

    function calculate_epin() {
        $qty = parse_number($("#quantity").val());
        var selected = $("#epin_type").find(":selected").attr("amount");
        $total = parse_number(selected) * $qty;
        $("#total").val(format_numbers($total?$total:0));
    }


    function network($number) {
        $no = $number.substring(0, 4);
        $found = false;
        $.each($number_network, function ($net, $array) {
            $.each($array, function ($k, $num) {
                if ($num == $no) {
                    $found = $net;
                    return false;
                }
            });
            if ($found !== false)
                return false;
        });
        return $found || "";
    }

    function convert_to_mb($data){
        $x = parseInt($data);
        if($x < 1000)
            return $x+"MB";
        var y = parseFloat($x / 1000).toFixed(1);
        var z = y.indexOf(".");
        var a = y.substring(z);
        if(a == ".0")
            var b = parseFloat($x / 1000).toFixed(0)+"GB";
        else{
            var b =  y+"GB";
        }
        return b;
    }

    addPageHook(function(){
        $("#epin").trigger("change");
    });

</script>