<?php echo form_open(url('epins/view/search') , array('class' => '','target'=>'_top'));;?>

<div class="row">
    <div class="col-md-3 form-group">
        <label class="bmd-label-floating">Category</label>
        <select name="category_id" class="form-control">
            <option value="">All Categories</option>

            <?php

                $array = c()->get_where("epins_category", "parent_id", 0)->result_array();

                foreach($array as $row) {
                    $rows = c()->get_where("epins_category", "parent_id", $row['id'])->result_array();
                    print_option($row['id'], "All $row[name]", $category_id);

                    foreach($rows as $row2){
                        print_option($row2['id'], "$row[name] - $row2[name]", $category_id);
                    }

                }
            ?>

        </select>

    </div>

    <div class="col-md-3 form-group">
        <label class="bmd-label-floating">Type</label>
        <select name="type"  class="form-control">
            <option value="0" <?=p_selected($type == "0");?>>All Type</option>
            <option value="1" <?=p_selected($type == "1");?>>Unused</option>
            <option value="2" <?=p_selected($type == "2");?>>Used</option>
        </select>
    </div>

    <?php
        $all_users = get_arrange_id("users", "id");
    ?>
    <div class="col-md-3 form-group fixed-focused">
        <label class="bmd-label-floating">Used By</label>
        <select name="user_id" class="form-control user-select2">
            <option value="">Any User (<?=count($all_users);?>)</option>
            <?php
            $all_users = get_arrange_id($all_users, "id");
            foreach($all_users as $user) {
                if(empty($user_id))
                    break;
                if($user['id'] == $user_id) {
                    ?>
                    <option selected
                            value="<?= $user['id']; ?>"><?= c()->get_full_name($user); ?></option>
                    <?php
                    break;
                }
            }
            ?>
        </select>

    </div>
    <div class="col-md-3 form-group fixed-focused">
        <label class="bmd-label-floating">Uploaded By</label>
        <select name="uploaded_by" class="form-control">
            <option value="">Any User</option>
            <?php
            d()->group_by("uploaded_by");
            $users = c()->get("epins")->result_array();
            foreach($users as $user) {
                if(empty($user['id']))
                    continue;
                $name = c()->get_full_name(getIndex($all_users, $user['id']));
                if(empty($name))
                    continue;
                    ?>
                    <option <?=p_selected($uploaded_by, $user['id']);?>
                            value="<?= $user['id']; ?>"><?= $name; ?></option>
                    <?php

            }
            ?>
        </select>
    </div>
    </div>
<div class="row">

    <div class="col-md-3 form-group">
        <label class="bmd-label-floating">Used From Date</label>
        <input type="text" name="date1" value="<?=$date1;?>" class="form-control date"/>
    </div>

    <div class="col-md-3 form-group">
        <label class="bmd-label-floating">Used To Date</label>
        <input  type="text" name="date2" value="<?=$date2;?>" class="form-control date"/>
    </div>


    <div class="col-md-3 form-group">
        <label class="bmd-label-floating">Search</label>
        <input type="text" name="search" value="<?=$search;?>" class="form-control">
        <label class="bmd-help">Search for pin or serial number</label>
    </div>

    <div class="col-md-3 form-group">
        <label class="bmd-label-floating"></label>
        <button class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
                                                                 aria-hidden="true"></i> <i
                class="fa fa-search" aria-hidden="true"></i> Search
        </button>
    </div>


</div>
</form>

<div class="row">
    <br>

    <div class="col-md-12" style="color: black; font-size: 14px;">
        <?php
            if(!empty($date1) || !empty($date2)){
                print "<span style=color:brown>".convert_to_datetime($date1)." TO ".convert_to_datetime($date2)."</span><br>";
            }
        ?>
        Used Pins = <b><?=$used_pins;?></b>;
        UnUsed Pins = <b><?=$unused_pins;?></b>;
        Total = <b><?=$used_pins + $unused_pins;?></b>
    </div>
</div>
<br>

<div class="col-md-12">


    <table data-server-side="<?= history_link(); ?>" data-totalrecords="<?= empty($epins_count)?count($epins):$epins_count; ?>" class="table table-bordered datatable" id="table_expeorts">
        <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Serial No</th>
            <th>Pins</th>
            <th>Used By</th>
            <th>Used Date</th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $all_categories = get_arrange_id("epins_category", "id");
        $count = g("start") + 1;

        foreach($epins as $row):
            $parent_id = getIndexOf($all_categories, $row['category'], "parent_id");
            $cname = getIndexOf($all_categories, $parent_id, "name");
            $subname = getIndexOf($all_categories, $row['category'], "name");
            ?>

            <tr>
                <td><?php echo $count++;?></td>
                <td><?php echo $cname;?></td>
                <td><?php echo $subname;?></td>
                <td><?php echo empty(trim($row['serial']))?"--":"";?></td>
                <td><?php
                    if(hAccess("view_all_pins") || login_id() == $row['uploaded_by']){
                        print $row['pin'];;
                    }else{
                        $len = strlen($row['pin']);
                        $show = 4;
                        if($len <= $show+3){
                            print "************";
                        }else
                            print "***********".substr($row['pin'], $len - $show);
                    }
                    ;?></td>
                <td><?php echo empty($row['user_id'])?"--":c()->get_full_name(getIndex($all_users, $row['user_id']));?></td>

                <td><?php
                    echo empty($row['date_used'])?"--":convert_to_datetime($row['date_used'])
                    ?></td>

                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                            <!-- EDITING LINK -->
                            <li>
                                <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo url('modal/popup/reseller.domain_modal/'.$row['owner']);?>');">
                                    <i class="fa fa-globe" aria-hidden="true"></i>    View
                                </a>
                            </li>
                            <li class="divider"></li>

                            <!-- DELETION LINK -->
                            <li>
                                <a href="javascript:void(0)" onclick="confirm_delete('<?php echo url('epins/delete_epin/'.$row['id']);?>', this, true)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    <?php echo get_phrase('delete');?>
                                </a>
                            </li>

                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

