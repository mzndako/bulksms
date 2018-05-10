<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_notifications"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {

    d()->where("id", $param1);
    $edit_data = c()->get('notification')->result_array();
    $update = "update";
}


foreach ( $edit_data as $row):
    $array = new process_array($row);
    ?>
    <?php echo form_open(url('admin/notifications/'.construct_url("update",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>



            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?=ucwords($update);?> Notification
                    </div>
                </div>

            <div class="panel-body">
<div class="row">
                <div class="col-md-12">

                 <div class="form-group">
                        <label class="bmd-label-floating">Title</label>
                        <input type="text" required name="title" value="<?=$array->get('title');?>" class="form-control"/>
                 </div>


                <div class="form-group focused">
                    <label class="bmd-label-floating">Notification</label>
                    <textarea data-height="150px" data-width="100%" class="form-control summernote" name="message" rows="8"><?=$array->get('message');?></textarea>

                </div>

<div class="form-group" >

                        <label class="bmd-label-floating">Type of Notification</label>
                        <select name="type" class="form-control">
                            <option <?=p_selected($array->get("type") == 1);?> value="1">Alert (Non Blocking)</option>
                            <option <?=p_selected($array->get("type") == 2);?> value="2">Dialog Box (Blocking)</option>

                        </select>
                 </div>




            <b>Choose location where the notification will appear</b>
            <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input onchange="show_target_pages(this)" <?=$array->get('location') == "all" || empty($array->get('location'))?"checked":"";?> type="checkbox" name="target_all" value="1" class="">
                        Appear on all Pages except Home page</label>
            </div>
                <div class="form-group inactive" id="target_pages">
                <?php
                $pos = $array->get('location');
 ?>
                        <label class="bmd-label-floating">Target Pages</label>
                        <select name="target[]" multiple="true" class="form-control">
                            <option <?=p_selected(strpos($pos,"[hp]") !== false);?> value="hp">Home Page (Login or Not)</option>
                            <option <?=p_selected(strpos($pos,"[db]") !== false);?> value="db">Dashboard</option>
                            <option <?=p_selected(strpos($pos,"[sbs]") !== false);?> value="sbs">Send Bulk SMS</option>
                            <option <?=p_selected(strpos($pos,"[sbsa]")!== false);?> value="sbsa">Send Bulk SMS (After Message Sent)</option>
                            <option <?=p_selected(strpos($pos,"[ra]")!== false);?> value="ra">Recharge Account</option>
                            <option <?=p_selected(strpos($pos,"[ba]")!== false);?> value="ba">Buy Airtime</option>
                            <option <?=p_selected(strpos($pos,"[bd]")!== false);?> value="bd">Buy Databundle</option>
                            <option <?=p_selected(strpos($pos,"[pb]")!== false);?> value="pb">Pay Bills</option>
                        </select>
                 </div>

                  <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input <?=empty($array->get('title'))?"":"checked";?> type="checkbox" onchange="nf_enable_advance_options(this)" value="1">
                        Enable Advance Options</label>
                 </div>



        </div>
        <div class="col-md-12 inactive" id="advance_option">

<hr>

<b>ADVANCE OPTIONS</b>

                 <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input <?=$array->get('store') == 1 || $array->get("store")== ""?"checked":"";?> type="checkbox" name="store" value="1">
                        Select this option if you want Users to see it on their notification page</label>
                 </div>

                 <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input <?=$array->get('new_user_can_see') == 1 || $array->get("new_user_can_see") == ""?"checked":"";?> type="checkbox" name="new_user_can_see" value="1">
                        Select this option if you want users that just register to see this notification as well</label>
                 </div>

                 <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input <?=$array->get('show_once') == 1 || $array->get("show_once") == ""?"checked":"";?> type="checkbox" name="show_once" value="1">
                        <b>Select</b> this option to Show notification once to the user OR <br><b>UnSelect</b> if you want this notification to keep on showing anytime the user access the targeted page </label>
                 </div>


                <div class="form-group checkbox checkbox-secondary">
                                        <label>
                                            <input <?=$array->get('disappear_on_read') == "" || $array->get('disappear_on_read') == 1?"checked":"";?> type="checkbox" name="disappear_on_read" value="1" class="">
                                        Select this option, not to show notification to the user again after it has been closed or read</label>
                </div>


                 <div class="form-group">
                        <label class="bmd-label-floating">Expiring Date</label>
                           <input  data-format="dd-MMM-yyyy hh:mm AA" type="text" name="expires" value="<?=empty($array->get("expires"))?"":date("d-M-Y h:m A", $array->get("expires"));?>" class="form-control datetime"/>
                       </label>
                       <label class="bmd-help">Leave empty if you don't want it to expire</label>
                 </div>

        </div>
         <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised"> <i class="fa fa-refresh inactive fa-spin" aria-hidden="true"></i>
                            <i class="fa fa-save" aria-hidden="true"></i> Save
                        </button>
         </div>
         </div>
    </div>
    </div>
  </form>
    <?php
endforeach;
?>



<script>
    function nf_enable_advance_options(me){
        if($(me).is(":checked")){
            $("#advance_option").show(100);
        }else{
            $("#advance_option").hide(100);
        }
    }

    function show_target_pages(me){
        if(!$(me).is(":checked")){
            $("#target_pages").show(100);
        }else{
            $("#target_pages").hide(100);
        }
    }

    addPageHook(function(){
        $("[type=checkbox]").trigger("change");
        return "destroy";
    });
</script>