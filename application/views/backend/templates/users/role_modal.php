<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("change_staff_privilege"))
    die("Access Denied");



    d()->where("id", $param1);
    $edit_data = c()->get('users')->result_array();
    $update = "update";



foreach ( $edit_data as $row):
    $array = new process_array($row);

    if($array->get("is_admin") != 1){
        die("You can not set privilege for a member. Please change the member to a Staff first");
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        Update User Privilege
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('users/options/update_privilege'.construct_url($param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

                <input type="hidden" name="container" value="<?=showAjaxModalTag();?>" />
                <input type="hidden" name="dont_hide_ajax_modal" value="true" />
                 <div class="form-group">
                        <label class="bmd-label-floating">Email</label>
                        <input type="text" disabled value="<?=$array->get('email');?>" class="form-control"/>
                 </div>
                <div class="form-group">
                        <label class="bmd-label-floating">Phone</label>
                        <input type="text" disabled value="<?=$array->get('phone');?>" class="form-control"/>
                 </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" onchange="show_on_select(this, '#privilege', true)" name="is_administrator" value="1" <?=p_checked($array->get("access") == -1);?> /> is Administrator (Full Privilege)
                        </label>
                    </div>
                </div>

                 <div class="form-group" id="privilege">
                        <label class="bmd-label-floating">Action</label>
                        <select class="form-control" name="privilege">
                            <option value="0">Select Privilege For Staff</option>
                            <?php
                               $roles = c()->get("role")->result_array();
                                foreach($roles as $role) {
                                    ?>
                                    <option <?=$array->get("privilege") == $role['id']?"selected":"";?> value="<?=$role['id'];?>"><?=$role['name'];?></option>
                                    <?php
                                  }
                            ?>
                        </select>
                 </div>






                <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" onclick="return confirm_dialog(this, 'Update User Privilege')" class="btn btn-success btn-raised">Update Staff Privilege</button>
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
        return 'destroy';
    });
</script>



