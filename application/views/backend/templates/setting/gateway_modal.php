<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_gateway"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {

    d()->group_start();
    c()->where("owner", 0);
    d()->or_where("owner", owner);
    d()->group_end();

    d()->where("id", $param1);

    $edit_data = d()->get('gateway')->result_array();
    $update = "update";
}


foreach ( $edit_data as $row):
    $array = new process_array($row);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?=ucwords($update);?> SMS Gateway
                    </div>
                </div>
            </div>
            <div class="panel-body gateway-modal">

                <?php echo form_open(url('setting/gateway/'.construct_url("update",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>


                 <div class="form-group">
                        <label class="bmd-label-floating">Name</label>
                        <input type="text" required name="name" value="<?=$array->get('name');?>" class="form-control"/>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Send SMS Api</label>
                        <input type="text" name="send_api" value="<?=$array->get('send_api');?>" class="form-control" required/>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Success Word</label>
                        <input type="text" name="success_word" value="<?=$array->get('success_word');?>" class="form-control" required/>
                     <label class="bmd-help">API Success Word e.g OK, Success, etc</label>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">HTTP Request Method</label>
                        <select name="method" class="form-control">
                            <option <?=p_selected($array->get("method"),"GET");?> >GET</option>
                            <option <?=p_selected($array->get("method"),"POST");?> >POST</option>
                         </select>
                 </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Balance API</label>
                    <input type="text" name="balance_api" value="<?=$array->get('balance_api');?>" class="form-control"/>
                    <label class="bmd-help">Enter the full api to get the balance</label>
                </div>

                <div class="checkbox checkbox-secondary form-group">
                    <label>
                        <input type="checkbox" <?=empty($array->get("unicode_api"))?"":"checked";?> onchange="on_select_show(this, '#unicode')" /> Activate Unicode SMS
                    </label>
                </div>

                <div class="form-group inactive" id="unicode">
                    <label class="bmd-label-floating">Unicode SMS API</label>
                    <input type="text" name="unicode_api" value="<?=$array->get('unicode_api');?>" class="form-control"/>
                    <label class="bmd-help">API to send sms if its a unicode SMS</label>
                </div>

                <div class="checkbox checkbox-secondary form-group">
                    <label>
                        <input type="checkbox"  <?=empty($array->get("flash_api"))?"":"checked";?> onchange="on_select_show(this, '#flash')"  /> Activate Flash SMS
                    </label>
                </div>

                <div class="form-group inactive" id="flash">
                    <label class="bmd-label-floating">Flash SMS API</label>
                    <input type="text" name="flash_api" value="<?=$array->get('flash_api');?>" class="form-control"/>
                    <label class="bmd-help">API to send sms if its a flash SMS</label>
                </div>


                <div class="checkbox form-group checkbox-secondary form-group">
                    <label>
                        <input type="checkbox"  <?=empty($array->get("delivery_api"))?"":"checked";?> onchange="on_select_show(this, '#delivery')"  /> Fetch Delivery Report
                    </label>
                </div>

                <div class="form-group inactive" id="delivery">
                    <label class="bmd-label-floating">Delivery API</label>
                    <input type="text" name="delivery_api" value="<?=$array->get('delivery_api');?>" class="form-control"/>
                    <label class="bmd-help">API to fetch delivery report </label>
                </div>

                <div class="checkbox checkbox-secondary form-group">
                    <label>
                        <input type="checkbox" name="special_price" value="1"  <?=empty($array->get("rate"))?"":"checked";?> onchange="on_select_show(this, '#gateway'); on_select_show(this, '#pricebox');"  /> Activate Special Gateway Price
                    </label>
                </div>

                <?php
                    $p = $array->get("rate");
                ?>
                <div class="form-group inactive fix-focused" id="gateway">
                    <label class="bmd-label-floating">Gateway Rate</label>

                    <select id="price" name="price"  class="form-control myselect" onchange="this.value == -1?$('#pricebox').show(100):$('#pricebox').hide(100)">
                        <option value="">Select Gateway Rate</option>
                        <?php
                            d()->where("active", 1);
                            $prices = c()->get("rate")->result_array();
                            foreach($prices as $x):
                        ?>
                            <option <?=p_selected($p == $x['id']);?>  value="<?=$x['id'];?>"><?=$x['name'];?></option>
                        <?php
                            endforeach;
 ?>
                        <option value="-1" <?=p_selected(!empty($p) && !is_numeric($p));?> >Custom Price</option>
                    </select>
                </div>

                <div class="form-group inactive" id="pricebox">
                    <label class="bmd-label-floating">Enter Customer Prices</label>
                    <textarea class="form-control" name="pricebox" rows="3"><?php

                        echo !empty($p) && is_numeric($p)?"":$p;
                        ?></textarea>
                    <label class="bmd-help">Custom Price e.g 234=1.5 separated by paragraph</label>
                </div>

                <div class="checkbox checkbox-secondary form-group">
                    <label>
                        <input type="checkbox"  <?=empty($array->get("route"))?"":"checked";?> onchange="on_select_show(this, '#myroute')"  /> Activate Routing
                     </label>

                    <i class="fa fa-question-circle" style="margin-left: 7px; margin-top: 3px;" data-toggle="popover" data-content="Allow you to configure phone numbers that will always pass through this gateway irrespective of the default gateway" aria-hidden="true"></i>
                </div>

                <div class="form-group inactive" id="myroute">
                    <label class="bmd-label-floating">Route Number's</label>
                    <textarea class="form-control" name="route" row="3"><?=$array->get("route");?></textarea>
                    <label class="bmd-help">Format numbers separated by comma, space or enter e.g 234807, 234903</label>
                </div>

                <?php
                    if(!is_reseller()) {
                        ?>
                        <div class="form-group " >
                            <label class="bmd-label-floating">Tag</label>
                            <input type="text" name="tag" value="<?=$array->get('tag',"quicksms1");?>" class="form-control"/>
                        </div>
                        <?php
                    }
                ?>






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
<style>
    .gateway-modal .checkbox{
        margin-top: 10px;;
    }
</style>
<script>
    addPageHook(function () {
        $("[type=checkbox]").trigger("change");
        $("select").trigger("change");
        return 'destroy';
    });
</script>



