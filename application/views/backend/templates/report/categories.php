<?php echo form_open(url('report/manage_categories'.construct_url($type,"update",$id)), array(
    'class' => 'form-groups-bordered validate', 'target' => '_top')); ?>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="bmd-label-floating">Name</label>
            <input type="text" class="form-control" required name="name" value="<?=$name;?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="bmd-label-floating">Description</label>
            <input type="text" class="form-control" name="description" value="<?=$description;?>" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <button class="btn btn-warning" ><i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-save" aria-hidden="true"></i> <?=empty($id)?"Create":"Update";?> </button>
        </div>
    </div>
</div>
</form>
<div class="row">
<div class="col-md-12">
    <table  class="table table-striped datatable">
        <thead class="center">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Option</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $count = 1;
            foreach($categories as $row) {
                ?>
                <tr>
                    <td><?=$count++;?></td>
                    <td><?=$row['name'];?></td>
                    <td><?=$row['description'];?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                Options <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                <!-- EDITING LINK -->
                                <li>
                                    <a href="<?=url("report/manage_categories/$type/edit/$row[id]");?>" ajax="true" >
                                        <i class="fa fa-eye" aria-hidden="true"></i> Edit
                                    </a>
                                </li>
                                <li class="divider"></li>

                                    <li>
                                        <a href="javascript:void(0)" onclick="confirm_delete('<?=url("report/manage_categories/$type/delete/$row[id]");?>', this, true)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            <?php echo get_phrase('delete');?>
                                        </a>
                                    </li>


                            </ul>
                        </div>
                    </td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        </table>
</div>
</div>