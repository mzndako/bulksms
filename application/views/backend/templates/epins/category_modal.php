<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if($param1 == ""){
    $edit_data[0]['name'] = "";

    $update = "create";
}else if($param1 == "0") {
    $edit_data[0]['parent_id'] = $param2;
    $update = "create";
}else {
    $edit_data = c()->get_where('epins_category', array('id' => $param1))->result_array();
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
                        <?=ucwords($update);?> Epin Category
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('epins/category/'.construct_url($param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

                <input type="hidden" name="parent_id" value="<?=$array->get("parent_id");?>"/>

                <?php
                    if(!empty($array->get("parent_id"))) {
                        ?>

                        <div class="form-group">
                            <label class="bmd-label-floating">Category</label>
                            <input type="text" class="form-control" readonly value="<?= c()->get_row("epins_category", "id", $array->get("parent_id"), "name"); ?>"/>
                        </div>
                        <?php
                    }
                ?>

                <div class="form-group">
                    <label class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="name" value="<?=$array->get("name"); ?>"/>
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Description</label>
                    <input type="text" class="form-control" name="description" value="<?=$array->get("description"); ?>"/>
                </div>

                <?php
                    if(!empty($param1)) {
                        ?>
<div class="form-group">
                        <div class="checkbox checkbox-secondary">
                            <label>
                            <input type="checkbox"  name="active" <?=$array->get("active")==1?"checked=checked":""; ?> /> Activated
                                </label>
                        </div>
</div>
                        <?php
                    }
                ?>


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



