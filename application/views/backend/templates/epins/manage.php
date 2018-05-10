<div class="col-md-12">
    <br>
    <br>
    <?php
        if(hAccess("upload_epins")) {
            ?>
            <a ajax=true class="btn btn-raised btn-info" href="<?= url("epins/upload"); ?>">
                ADD/UPLOAD EPINS
            </a>
            <?php
        }
    ?>

    <button class="btn btn-raised btn-warning pull-right" onclick="showAjaxModal('<?=url("modal/popup/epins.category_modal");?>')">
        Add Category
    </button>
    <br><br>


    <table class="table table-bordered " >
        <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Description</th>
            <th>Unused Pins</th>
            <th>Used Pins</th>
            <th>Total</th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        d()->where("parent_id", 0);
        $categories = d()->get("epins_category")->result_array();
        $count = 1;
        foreach($categories as $row):
            d()->where("parent_id", $row['id']);
            $sub_categories = c()->get("epins_category")->result_array();
            if(empty($sub_categories)){
                $sub_categories = array(array());
            }
            $shown = false;
            foreach($sub_categories as $sub) {
                $obj = new process_array($sub);
                ?>
                <tr>
                    <?php
                        if(!$shown) {
                            ?>
                            <td rowspan="<?=count($sub_categories);?>"><?php echo $count++; ?></td>
                            <td rowspan="<?=count($sub_categories);?>"><?php echo $row['name']; ?></td>
                            <?php
                            $shown = true;
                        }
                    ?>
                    <td>
                        <?=$obj->get("name");?>
                    </td>
                    <td>
                        <?=$obj->get("description");?>
                    </td>
                    <td>
                        <?php
                            d()->where("category", $obj->get("id"));
                            d()->where("user_id", 0);
                            $unused = c()->count_all("epins");
                            echo empty($sub['id'])?"":$unused;
                        ;?>
                    </td>
                    <td>
                        <?php
                            d()->where("category", $obj->get("id"));
                            d()->where("user_id !=", 0);
                            $used = c()->count_all("epins");
                            echo empty($sub['id'])?"":$unused;
                        ;?>
                    </td>
                    <td>
                        <?php
                        echo empty($sub['id'])?"":$unused + $used;
                        ?>
                    </td>

                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                <!-- EDITING LINK -->
                                <li>
                                    <a href="javascript:void(0)"
                                       onclick="showAjaxModal('<?php echo url('modal/popup/epins.category_modal/0/'.$row['id']); ?>');">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        Add Sub-Category
                                    </a>
                                </li>

                                <?php
                                    if(!empty($sub['id'])) {
                                        ?>
                                        <!-- EDITING LINK -->
                                        <li class="divider"></li>

                                        <li>
                                            <a href="javascript:void(0)"
                                               onclick="showAjaxModal('<?php echo url('modal/popup/epins.category_modal/' . $sub['id']); ?>');">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                Edit Sub-Category
                                            </a>
                                        </li>

                                        <li class="divider"></li>

                                        <li>
                                            <a
                                               onclick="return show_dialog(this)" href="<?php echo url('epins/category_delete/' . $sub['id']); ?>" data-text="Delete Epins Categories?">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <?php echo get_phrase('delete'); ?> Sub-Category
                                            </a>
                                        </li>
                                        <?php
                                    }
                                ?>
                                <li class="divider"></li>

                                <li>
                                    <a href="javascript:void(0)"
                                       onclick="showAjaxModal('<?php echo url('modal/popup/epins.category_modal/' . $row['id']); ?>');">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit Category
                                    </a>
                                </li>

                                <li class="divider"></li>
                                <li>
                                    <a ajax="true"
                                       href="<?php echo url('epins/view/' . $row['id']); ?>" >
                                        <i class="fa fa-eye" aria-hidden="true"></i>
      View Pins
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <!-- DELETION LINK -->
                                <li>
                                    <a onclick="return show_dialog(this)" href="<?php echo url('epins/category_delete/' . $row['id']); ?>" data-text="Delete Epins Category and Sub Categories?"  >
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        <?php echo get_phrase('delete'); ?> Category & Sub-Category
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </td>
                </tr>

                <?php
            }
        endforeach;?>
        </tbody>
    </table>
</div>

