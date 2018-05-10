<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if($param1 ==  'create'){
    $edit_data[0]['name'] = "";

    $edit_data[0]['name_numeric'] = 1;
    $edit_data[0]['teacher_id'] = "";
    $edit_data[0]['type'] = 2;
    $edit_data[0]['type'] = 2;
    $update = "create";
}else {
    $edit_data = c()->get_where('reseller', array('owner' => $param3, "parent"=>owner))->result_array();
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
                        <?=ucwords($update);?> Reseller
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('reseller/update/'.construct_url($param2)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>


                 <div class="form-group">
                        <label class="bmd-label-floating">Member</label>
                        <select placeholder="Search Members" name="user_id" class="form-control user-select2">

                        </select>
                    </div>
                <br><br>

                <b>RESELLER LOGIN DETAILS</b><Br>
                You can leave any field empty to use the current user detail as the reseller detail instead.
                <div class="form-group">
                    <label class="bmd-label-floating">Reseller Email</label>
                    <input type="text" name="email" value="" class="form-control" />
                    <label class="bmd-help"></label>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Reseller Phone Number</label>
                    <input type="text" name="phone" value="" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Reseller Password</label>
                    <input type="text" name="password" value="" class="form-control" />
                </div>









                <div class="col-md-12" align="center">
                        <button type="submit" class="btn btn-primary btn-raised"><?php echo $update;
                            ?></button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <?php
endforeach;
?>



