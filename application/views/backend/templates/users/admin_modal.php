<?php
if(empty($param2)){
    $edit_data[0]['name'] = "";
    $edit_data[0]['email'] = "";
    $edit_data[0]['phone'] = "";
    $edit_data[0]['access'] = "";
    $update = "create";
}else {
    $edit_data = c()->get_where('admin', array('admin_id' => $param2))->result_array();
    $update = "update";
}
$array = c()->get("role")->result_array();

foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary b-w-0" data-collapsed="0">

            <div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo ucwords($update). " Admin";?>
            	</div>
            </div>
        </div>
			<div class="panel-body">
				
                <?php echo form_open(url('user/admin/update'.construct_url($param2)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

<!--                <input type="hidden" name="current_url" value="">-->
                <div class="form-group">
                        <label class="bmd-label-floating"><?php echo get_phrase('name');?></label>
                            <input type="text" class="form-control" name="name"  value="<?php echo $row['name'];?>" required/>
                </div>

                <div class="form-group">
                        <label class="bmd-label-floating">Phone</label>
                            <input type="text" class="form-control" name="phone" required  value="<?php echo $row['phone'];?>"/>
                </div>

                <div class="form-group">
                        <label class="bmd-label-floating">Email</label>
                            <input type="email" required class="form-control" name="email"  value="<?php echo $row['email'];?>"/>
                </div>
 <?php
						if(empty($param2)) {
                            ?>
                            <div class="form-group">
                                <label class="bmd-label-floating">Password</label>
                                <input type="password" class="form-control autocomplete-off" name="password" value=""/>
                                <label class="bmd-help"
                                       style="display: block;"><?= empty($param2) ? '' : 'Leave Password blank to maintain previous password'; ?></label>
                            </div>
                            <?php
                        }
 ?>

                <div class="form-group">
                        <label class="bmd-label-floating">Access</label>
                    <select name="role_id" class="form-control">
                        <option value=""><?php echo get_phrase('select access type');?></option>
                        <?php
                        foreach($array as $row2):
                            ?>
                            <option value="<?php echo $row2['role_id'];?>"
                                <?php if($row['access'] == $row2['role_id'])echo 'selected';?>>
                                <?php echo $row2['name'];?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>


            		<div class="form-group" align="center">
						<div class="">
							<button type="submit" class="btn btn-primary btn-raised"><?php echo $update;
                                ?></button>
						</div>
					</div>
        		</form>
            </div>

    </div>
</div>

<?php
endforeach;
?>



