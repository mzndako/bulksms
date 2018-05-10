<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
$type = $param1;

if($type == "income"){
    rAccess("manage_income");
}else{
    rAccess("manage_expenses");
}

if($param2 == ""){
    $edit_data[0]['name'] = "";
    $edit_data[0]['date'] = time();

    $update = "create";
}else {
    $edit_data = c()->get_where('income_expense', array('id' => $param2))->result_array();
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
                        <?=ucwords($update);?> <?=ucwords($type);?>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('report/update/'.construct_url($type, $param2)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

                <div class="form-group">
                    <label class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="name" value="<?=$array->get("name"); ?>"/>
                </div>


                <div class="form-group">
                    <label class="bmd-label-floating">Amount</label>
                    <input type="text" required class="form-control number" name="amount" value="<?=$array->get("amount"); ?>"/>
                </div>


                <div class="form-group">
                            <label class="bmd-label-floating">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Categories</option>
                                <?php
                                    d()->where("type", $type == "income"?1:2);
                                    $category = c()->get("income_expense_categories")->result_array();
                                    foreach($category as $row){
                                        print_option($row['id'], $row['name'], $array->get("category_id"));
                                    }
                                ?>
                            </select>
                        </div>



                <div class="form-group">
                    <label class="bmd-label-floating">Date</label>
                    <input type="text" required data-format="dd-MMM-yyyy hh:mm AA" class="form-control datetime" name="date" value="<?=convert_to_datetime($array->get("date"), "d-M-Y h:m A"); ?>"/>
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



