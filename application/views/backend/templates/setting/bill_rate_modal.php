<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_gateway"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {

    d()->where("id", $param1);
    $edit_data = c()->get('bill_rate')->result_array();
    $update = "update";
}
$reseller_id = reseller_id();
//$reseller_id = 1;
$rbill = new mybill($reseller_id);
$rbill->set_user(owner_user_id($reseller_id));

$rRate = $rbill->rate(true);



foreach ( $edit_data as $row):
    $array = new process_array($row);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?=ucwords($update);?> Bill Rate
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('setting/rate/'.construct_url("update_bill",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
<input type="hidden" name="function_success" value="activate_bill_tab"/>

                 <div class="form-group">
                        <label class="bmd-label-floating">Name</label>
                        <input type="text" required name="name" value="<?=$array->get('name');?>" class="form-control"/>
                 </div>


                <div class="row">
                    <br><br>
                  <div class="">  <small>For commission, you can use percentage to award commission on percentage of amount e.g 2%</small><br>
                     <b>To disable any airtime package, set the price to -1</b>
                  </div>
                    <div class="">
                    <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Commission</th>
                        </tr>
                        <?php
                        $count = 1;
                        $all = json_decode($array->get("bill"), true);
                        $myairtime = getIndex($all, "airtime");
                            foreach(bill()->bill_payment_rate()['airtime'] as $airtime){
                                $per = is_reseller()?"(".getIndex($rRate, "airtime,$airtime").")":"";
                                if($per == "(-1)")
                                    continue;

                                print "<tr>";
                                print "<td>".$count++."</td>";
                                print "<td>".ucwords($airtime)." Airtime $per</td>";
                                print "<td><input type='text'  class='form-control' name='airtime_$airtime' value=\"".pv(getIndex($myairtime, $airtime))."\" /> </td>";
                                print "</tr>";
                            }
?>
                        </table>
                        </div>
                  </div>
                <div class="row ">
                    <b>To disable a dataplan package, set the price to -1</b><br>
                    <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Dataplan</th>
                            <th>Selling Price</th>
                        </tr>
                        </thead>
                        <?php
                        $mydataplan = getIndex($all, "dataplan");
                        foreach(bill()->bill_payment_rate()['dataplan'] as $airtime=> $dataplan){
                            foreach($dataplan as $unit => $amount) {
                                $mine = getIndex($mydataplan, $airtime.",$unit") ;
                                $amt = format_amount($amount,0);
                                if(is_reseller()){
                                    $ramt = getIndex($rRate, "dataplan,$airtime,$unit");
                                    if($ramt == "-1"){
                                        continue;
                                    }
                                    $amt = format_amount($ramt,0);
                                }
                                $price = $mine == ""?$amt:$mine;
                                $u = bill()->convert_to_mb($unit);
                                print "<tr>";
                                print "<td>" . $count++ . "</td>";
                                print "<td>" . ucwords($airtime) . " $u ($amt) </td>";
                                print "<td><input type='text'  class='number form-control' name='$airtime".'_'."$unit' value=\"" . $price. "\" /> </td>";
                                print "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>

          <div class="row ">
              <b>To disable a package, set the price to -1</b>
                    <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Package</th>
                            <th>Selling Price</th>
                        </tr>
                        </thead>
                        <?php
                        $mybill = getIndex($all, "bill");
                        foreach(bill()->bill_payment_rate()['bill'] as $package=> $bill){
                            foreach($bill as $plan => $y) {
                                $name = $y['name'];
                                $amount = $y['amount'];
                                $mine = getIndex($mybill, $package.",$plan") ;
                                $amt = format_amount($amount,0);
                                if(is_reseller()){
                                    $ramt = getIndex($rRate, "bill,$package,$plan");
                                    if($ramt == "-1"){
                                        continue;
                                    }
                                    $amt = format_amount($ramt,0);
                                }
                                $price = $mine == ""?$amt:$mine;
                                print "<tr>";
                                print "<td>" . $count++ . "</td>";
                                print "<td>" . ucwords($name) . " ($amt) </td>";
                                print "<td><input type='text' class='number form-control' name='$package"."_".str_replace(".","_",$plan)."' value=\"" . $price. "\" /> </td>";
                                print "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>

                               <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised"><?php echo $update;
                            ?></button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <?php
endforeach;
?>



