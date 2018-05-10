<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_page"))
    die("Access Denied");

if(empty($param1)){
    $edit_data[] = array();
    $update = "create";
}else {

    d()->where("id", $param1);
    $edit_data = c()->get('page')->result_array();
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
                        <?=ucwords($update);?> Page
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(url('setting/page/'.construct_url("update",$param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

<input type="hidden" name="function_success" value="update_page_id"/>
<input type="hidden" name="id" value="<?=$array->get("id");?>"/>
                 <div class="form-group">
                        <label class="bmd-label-floating">Title</label>
                        <input type="text" required name="title" value="<?=$array->get('title');?>" class="form-control"/>
                 </div>


                <div class="form-group focused">
                    <label class="bmd-label-floating">Content</label>
                    <textarea data-height="500px" data-width="100%" class="form-control summernote" name="content" rows="8"><?=$array->get('content');?></textarea>

                </div>

                               <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised"> <i class="fa fa-refresh inactive fa-spin" aria-hidden="true"></i>
                            <i class="fa fa-save" aria-hidden="true"></i> Save
                        </button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <?php
endforeach;
?>



<script>
    function update_page_id(response){
        $("[name=id]").val(response.id);
    }
</script>