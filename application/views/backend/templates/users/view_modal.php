<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("view_user"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {


    d()->where("id", $param1);
    $edit_data = c()->get('users')->result_array();
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
                        <?=ucwords($update);?> User
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('users'.construct_url("update",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate myform','target'=>'_top'));?>
                <input type="hidden" id="id" name="function_success" value="update_id()" />
                <input type="hidden" name="id" value="<?=$array->get('id');?>"/>
<div align="center">
                <?php
                if (hAccess("credit_user") && !empty($row['id'])) {
                    ?>
                        <a href="javascript:void(0)" onclick="showAjaxModal('<?= url("modal/popup/users.update_balance_modal/$row[id]"); ?>')"
                            >
                        Update User Account Balance
                        </a>
                    <?php
                }
                ?>
</div>
                 <div class="form-group">
                        <label class="bmd-label-floating">First Name</label>
                        <input type="text" required name="fname" maxlength="50" value="<?=$array->get('fname');?>" class="form-control"/>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Last Name</label>
                        <input type="text" required name="surname" maxlength="50" value="<?=$array->get('surname');?>" class="form-control"/>
                 </div>

                <?php
                    if(default_register_column("username") || !empty($array->get("username"))) {
                        ?>
                        <div class="form-group">
                            <label class="bmd-label-floating">Username</label>
                            <input type="text" name="username" <?=default_register_column("username")?"":"readonly";?> maxlength="70" value="<?=$array->get('username');?>" class="form-control"/>
                        </div>
                        <?php
                    }
                ?>

                <?php
                    if(default_register_column("email")) {
                        ?>
                        <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="email" name="email" value="<?= $array->get('email'); ?>" class="form-control"
                                   maxlength="200"/>
                        </div>

                        <?php
                    }
                ?>

                 <div class="form-group">
                        <label class="bmd-label-floating">Phone</label>
                        <input type="number" name="phone" value="<?=$array->get('phone');?>" class="form-control" maxlength="13"/>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Password</label>
                        <input type="password" <?=empty($array->get('id'))?"required":"";?> name="password" value="" class="form-control"/>
                     <label class="bmd-help">Leave Blank to use default password</label>
                 </div>

                <?php
                    if(hAccess("change_user_price")) {
                        $p = $array->get("rate");
                        ?>
                        <div class="form-group" id="gateway">
                            <label class="bmd-label-floating">Special Price</label>

                            <select id="price" name="price" class="form-control myselect"
                                    onchange="this.value == -1?$('#pricebox').show(100):$('#pricebox').hide(100)">
                                <option value="">Use Default Rate</option>
                                <?php
                                d()->where("active", 1);
                                $prices = c()->get("rate")->result_array();
                                foreach ($prices as $x):
                                    ?>
                                    <option <?=p_selected($p == $x['id']);?> value="<?= $x['id']; ?>"><?= $x['name']; ?></option>
                                    <?php
                                endforeach;
                                ?>
                                <option value="-1" <?= p_selected(!empty($p) && !is_numeric($p)); ?> >Custom Price
                                </option>
                            </select>
                        </div>

                        <div class="form-group inactive" id="pricebox">
                            <label class="bmd-label-floating">Enter Custom Prices</label>
                    <textarea class="form-control" name="pricebox" rows="3"><?php
                        echo !empty($p) && !is_numeric($p) ?  $p:"";
                        ?></textarea>
                            <label class="bmd-help">Custom Price e.g 234=1.5 separated by paragraph</label>
                        </div>


                        <?php
                        $pdnd = $array->get("dnd_rate");
                        ?>

                        <div class="form-group" >
                            <label class="bmd-label-floating">Special DND Price</label>

                            <select id="pricednd" name="pricednd" class="form-control myselect"
                                    onchange="this.value == -1?$('#priceboxdnd').show(100):$('#priceboxdnd').hide(100)">
                                <option value="">Use Default DND Rate</option>
                                <?php
                                d()->where("active", 1);
                                $prices = c()->get("rate")->result_array();
                                foreach ($prices as $x):
                                    ?>
                                    <option <?=p_selected($pdnd == $x['id']);?> value="<?= $x['id']; ?>"><?= $x['name']; ?></option>
                                    <?php
                                endforeach;
                                ?>
                                <option value="-1" <?= p_selected(!empty($pdnd) && !is_numeric($pdnd)); ?> >Custom Price
                                </option>
                            </select>
                        </div>

                        <div class="form-group inactive" id="priceboxdnd">
                            <label class="bmd-label-floating">Enter Custom DND Price</label>
                    <textarea class="form-control" name="priceboxdnd" rows="3"><?php

                        echo !empty($pdnd) && is_numeric($pdnd) ? "" : $pdnd;
                        ?></textarea>
                            <label class="bmd-help">Custom Price e.g 234=1.5 separated by paragraph</label>
                        </div>

                        <?php
                    }

                    if(hAccess("change_user_gateway")) {
                        ?>
                        <div class="form-group" >
                            <label class="bmd-label-floating">Special Gateway</label>

                            <select id="gateway" name="gateway"  class="form-control myselect" >
                                <option value="">Select Gateway Price</option>
                                <?php
                                $gt = $array->get("gateway");

                                d()->where("active", 1);
                                $prices = c()->get("gateway")->result_array();
                                foreach($prices as $x):
                                    ?>
                                    <option <?=p_selected($gt == $x['id']);?>  value="<?=$x['id'];?>"><?=$x['name'];?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                ?>

                <div class="form-group">
                        <label class="bmd-label-floating">Sex</label>
                        <select name="sex" class="form-control">
                            <option <?=p_selected($array->get("sex"),"male");?> value="male">Male</option>
                            <option <?=p_selected($array->get("sex"),"female");?> value="female">Female</option>
                         </select>
                 </div>

                 <div class="form-group">
                        <label class="bmd-label-floating">Default User Route</label>
                        <select name="route" class="form-control">
                            <option <?=p_selected($array->get("route"),"0");?> value="0">Normal Route</option>
                            <option <?=p_selected($array->get("route"),"1");?> value="1">Alternate Route</option>
                            <option <?=p_selected($array->get("route"),"2");?> value="2">Banking Route</option>
                         </select>
                 </div>
                 <div class="form-group">
                        <label class="bmd-label-floating">User Type</label>
                        <select name="is_admin" class="form-control">
                            <option <?=p_selected($array->get("is_admin"),"0");?> value="0">Member</option>
                            <option <?=p_selected($array->get("is_admin"),"1");?> value="1">Staff</option>
                         </select>
                 </div>
                 <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select name="disabled" class="form-control" onchange="this.value == 1?$('#disabled_text').show(100):$('#disabled_text').hide(100)">
                            <option <?=p_selected($array->get("disabled"),"0");?> value="0">Active</option>
                            <option <?=p_selected($array->get("disabled") != 0);?> value="1">Disable User <?=$array->get("disabled")>2?"(".convert_to_datetime($array->get("disabled")).")":"";?></option>
                         </select>
                 </div>
                 <div class="form-group" id="disabled_text">
                        <label class="bmd-label-floating">Disable Text</label>
                            <input class="form-control" value="<?=$array->get("disabled_text");?>" name="disabled_text"/>
                 </div>



                <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised"><?php echo "Save";
                            ?></button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <?php
endforeach;
?>
<script>
    addPageHook(function () {
        $("[type=checkbox]").trigger("change");
        $(".myform select").trigger("change");
        return 'destroy';
    });

    function update_id($response){
        $("#id").val($response.id);
    }
</script>



