<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_gateway"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {

    d()->where("id", $param1);
    $edit_data = c()->get('rate')->result_array();
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
                        <?=ucwords($update);?> SMS Rate
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('setting/rate/'.construct_url("update",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>


                 <div class="form-group">
                        <label class="bmd-label-floating">Name</label>
                        <input type="text" required name="name" value="<?=$array->get('name');?>" class="form-control"/>
                 </div>


                <div class="form-group ">
                    <label class="bmd-label-floating">Rate</label>
                    <textarea class="form-control" name="rate" rows="8"><?=$array->get('rate');?></textarea>
                    <label class="bmd-help">Enter format number per price e.g 234=1.5 separated by paragraph or comma</label>
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



