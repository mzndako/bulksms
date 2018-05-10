<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(empty($param1)){
    $edit_data[0]['name'] = "";
    $edit_data[0]['numbers'] = "";
    $update = "create";
}else {
    if(!is_admin())
        d()->where("user_id", login_id());

    d()->where("id", $param1);
    $edit_data = c()->get('phonebook')->result_array();
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
                        <?=ucwords($update);?> Contact
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('phonebook/update/'.construct_url($param1,$param2)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

              <div class="form-group">
                    <label class="bmd-label-floating">Name</label>
                    <input type="text" name="name" value="<?=$array->get("name");?>" class="form-control" />
                    <label class="bmd-help"></label>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Phone Number</label>
                    <textarea type="text" name="numbers"  class="form-control" ><?=$array->get("numbers");?></textarea>
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



