<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary b-w-0" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?=$type == "income"?"Manage Income":"Manage Expenses";?>
                </div>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-6" align="left">
                        <div class="btn btn-info btn-flat" onclick="showAjaxModal('<?=url('modal/popup/report.update_report_modal/'.$type);?>')">Add <?=ucwords($type);?></div>
                    </div>
                    <div class="col-sm-6" align="right">
                        <a ajax="true" class="btn btn-info" href="<?=url('report/manage_categories/'.$type);?>">Manage Categories</a>
                    </div>
                </div>
                <?php echo form_open(url('report/report'.construct_url($type, "select")) , array('class' => '','target'=>'_top'));

                ?>
                <div class="row" style="margin-bottom: 5px;">

                    <div class="col-md-12">

                        <div class="col-md-3 form-group">
                            <label class="bmd-label-floating">From Date</label>
                            <input type="text" data-format="dd-MMM-yyyy hh:mm AA" name="date1" value="<?=$date1;?>" class="form-control datetime"/>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="bmd-label-floating">To Date</label>
                            <input  data-format="dd-MMM-yyyy hh:mm AA" type="text" name="date2" value="<?=$date2;?>" class="form-control datetime"/>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="bmd-label-floating">Search</label>
                            <input type="text" name="keyword" value="<?=$keyword;?>" class="form-control "/>
                        </div>

                            <div class="col-md-6 form-group">
                                <label class="bmd-label-floating">Categories</label>
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    <?php
                                    d()->where("type", $type == "income"?1:2);
                                    $ct = c()->get("income_expense_categories")->result_array();
                                    foreach($ct as $row) {
                                            ?>
                                            <option <?= p_selected($row['id'] == $category_id); ?>
                                                value="<?= $row['id']; ?>"><?=$row['name']; ?></option>
                                            <?php
                                    }
                                    ?>
                                </select>

                            </div>

                        <div class="col-md-3 form-group">
                            <label class="bmd-label-floating"></label>
                            <button name="search" class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
                                                                                                   aria-hidden="true"></i> <i
                                    class="fa fa-search" aria-hidden="true"></i> Search
                            </button>
                        </div>

                    </div>



                </div>
                </form>

                <div class="row">
                    <div class="col-md-12" style="color: brown;">
                       Total = <b><?= format_wallet($total_cost); ?> </b><br>
                        <br>
                    </div>
                </div>

                <div class="row">

                    <!----TABLE LISTING STARTS-->
                    <div class="col-md-12">

                        <table data-server-side="<?= history_link(); ?>" data-totalrecords="<?= empty($report_count)?count($report):$report_count; ?>" class="table table-striped datatable history">
                            <thead class="center">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
$category = get_arrange_id_name("income_expense_categories", "id","name");
                            $count = g("start") + 1;
                            foreach ($report as $row):


                                ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><span class="mydate"><?= convert_to_datetime($row['date']); ?></span></td>
                                    <td ><span class="sender"><?=$row['name'];?></span></td>
                                    <td ><span class="sender"><?=getIndex($category,$row['category_id'], "--");?></span></td>
                                    <td ><span class="sender"><?=format_wallet($row['amount']);?></span></td>
                                    <td >
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                Options <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                <!-- EDITING LINK -->
                                                <li>
                                                    <a href="javascript:void(0)" onclick="showAjaxModal('<?=url('modal/popup/report.update_report_modal/'.$type.'/'.$row['id']);?>', this)" >
                                                        <i class="fa fa-eye" aria-hidden="true"></i> Edit
                                                    </a>
                                                </li>

                                                    <li class="divider"></li>						<li>
                                                        <a href="javascript:void(0)" onclick="confirm_delete('<?=url("report/report/$type/delete/$row[id]");?>', this, true)">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            <?php echo get_phrase('delete');?>
                                                        </a>
                                                    </li>
                                            </ul>
                                        </div>


                                    </td>

                                </tr>
                                <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>


    </div>
</div>


