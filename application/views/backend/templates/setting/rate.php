<div class="row">
    <ul class="nav nav-tabs bordered">
        <li class="nav-item active">
            <a data-target="#bulksms" class="nav-link active" data-toggle="tab"> <i class="fa fa-envelope-o"
                                                                                    aria-hidden="true"></i>
                Bulk SMS Rate
            </a>
        </li>
        <li class="nav-item">
            <a data-target="#bill" class="nav-link" data-toggle="tab"><i class="fa fa-credit-card"
                                                                         aria-hidden="true"></i>
                Bill Payment Rate
            </a>
        </li>
        <?php
            if(is_owner()) {
                ?>
                <li class="nav-item">
                    <a data-target="#cost" class="nav-link" data-toggle="tab"><i class="fa fa-archive"
                                                                                 aria-hidden="true"></i>
                        Cost (Buying Price)
                    </a>
                </li>
                <?php
            }
        ?>


    </ul>
    <!------CONTROL TABS END------>

    <div class="tab-content">
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="bulksms">
            <div class="row">
                <?php

                $gateway = c()->get("rate")->result_array();
                $count = 1;

                ?>

                <div class="col-md-3">

                </div>
            </div>
            <br>
            <br>
            <button class="btn btn-raised btn-warning pull-right"
                    onclick="showAjaxModal('<?= url("modal/popup/setting.rate_modal"); ?>')">
                All New Rate
            </button>
            <br>
            <br>

            <div class="responsive-table">
                <table class="table table-bordered table-striped">
                    <thead class="center">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Rate</th>
                        <th colspan="2" class="center">Default</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Date</th>
                        <th class="no-print" rowspan="2">Option</th>
                    </tr>
                    <tr>
                        <th class="center">SMS Rate</th>
                        <th class="center">DND Rate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php


                    $count = 1;
                    foreach ($gateway as $row):
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td>
                                <?= str_replace("\n", "<br>", $row['rate']); ?>
                            </td>
                            <td align="center">
                                <?php
                                if (get_setting("default_rate") != $row['id']):

                                    ?>
                                    <i onclick="show_dialog(this)" data-toggle="tooltip" title="Set as Default Rate"
                                       data-text="Activate this rate as the 'Default Rate'"
                                       href="<?= url('setting/rate/default_rate/' . $row['id']); ?>"
                                       class="fa fa-star-o fa-2x cursor"></i>
                                    <?php
                                else:
                                    ?>
                                    <i class="fa fa-star fa-2x" aria-hidden="true"></i>
                                    <?php
                                endif;
                                ?>
                            </td>
                            <td align="center">
                                <?php
                                if (get_setting("default_dnd_rate") != $row['id']):

                                    ?>
                                    <i onclick="show_dialog(this)" data-toggle="tooltip" title="Set as Default DND Rate"
                                       data-text="Activate this rate as the 'Default DND Rate'"
                                       href="<?= url('setting/rate/default_dnd_rate/' . $row['id']); ?>"
                                       class="fa fa-star-o fa-2x cursor"></i>
                                    <?php
                                else:
                                    ?>
                                    <i class="fa fa-star fa-2x" aria-hidden="true"></i>
                                    <?php
                                endif;
                                ?>
                            </td>

                            <td class="center">
                                <i onclick="loadContainer(this)" data-toggle="tooltip"
                                   title="Activate/De-activate this Rate?"
                                   href="<?= url('setting/rate/activate/' . $row['id']); ?>"
                                   class="fa fa-toggle-<?= $row['active'] == 1 ? "on" : "off"; ?> fa-2x cursor"></i>

                            </td>
                            <td>
                                <?= convert_to_date($row['date']); ?>
                            </td>
                            <td class="center" align="center">
                                <button data-toggle="tooltip" title="Edit Rate"
                                        onclick="showAjaxModal('<?= url("modal/popup/setting.rate_modal/$row[id]"); ?>')"
                                        class="btn btn-sm btn-raise btn-warning">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>
                                <button data-toggle="tooltip" title="Delete Rate"
                                        onclick="confirm_delete('<?= url("setting/rate/delete/$row[id]"); ?>', this, true)"
                                        class="btn btn-sm btn-raise btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!----TABLE LISTING ENDS--->

        <div class="tab-pane" id="bill">

            <br>
            <br>
            <button class="btn btn-raised btn-warning pull-right"
                    onclick="showAjaxModal('<?= url("modal/popup/setting.bill_rate_modal"); ?>')">
                All New Rate
            </button>
            <br>
            <br>

            <div class="responsive-table">
                <table class="table table-bordered table-striped">
                    <thead class="center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>

                        <th class="center">Sell Rate</th>

                        <th>Status</th>
                        <th>Date</th>
                        <th class="no-print">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $rate = c()->get("bill_rate")->result_array();
                    $count = 1;
                    foreach ($rate as $row):
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td align="center">
                                <?php
                                if (get_setting("default_bill_rate") != $row['id']):

                                    ?>
                                    <i onclick="show_dialog(this, null, {run_function:function(){activate_bill_tab();}})"
                                       data-toggle="tooltip" title="Set as Default Bill Rate"
                                       data-text="Activate this bill rate as the 'Default Rate'"
                                       href="<?= url('setting/rate/default_bill_rate/' . $row['id']); ?>"
                                       class="fa fa-star-o fa-2x cursor"></i>
                                    <?php
                                else:
                                    ?>
                                    <i class="fa fa-star fa-2x" aria-hidden="true"></i>
                                    <?php
                                endif;
                                ?>
                            </td>


                            <td class="center">
                                <i onclick="loadContainer(this)" data-toggle="tooltip"
                                   title="Activate/De-activate this Rate?"
                                   href="<?= url('setting/rate/activate_bill/' . $row['id']); ?>"
                                   class="fa fa-toggle-<?= $row['active'] == 1 ? "on" : "off"; ?> fa-2x cursor"></i>

                            </td>

                            <td>
                                <?= convert_to_date($row['date']); ?>
                            </td>
                            <td class="center" align="center">
                                <button data-toggle="tooltip" title="Edit Rate"
                                        onclick="showAjaxModal('<?= url("modal/popup/setting.bill_rate_modal/$row[id]"); ?>')"
                                        class="btn btn-sm btn-raise btn-warning">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>
                                <button data-toggle="tooltip" title="Delete Rate"
                                        onclick="confirm_delete('<?= url("setting/rate/delete_bill/$row[id]"); ?>', this, true)"
                                        class="btn btn-sm btn-raise btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>


<!--        SET BUYING PRICE (COST)-->
        <div class="tab-pane" id="cost">
            <br>

            <?php
            if (is_owner()) {
            ?>
            <b>Default Cost is the amount you are paying your subscriber. It will be used to compute the Profit
                Made</b>

             <div class="row">
             <div class="col-md-3">
                 <?php echo form_open(url('setting/rate/'.construct_url("update_cost")) , array('class' => ' validate','target'=>'_top'));?>

                 <?php
            $array = array("cost_sms_rate", "cost_dnd_rate");
            foreach ($array as $name) {
                ?>

                    <div class="form-group fixed-focused">
                        <label class="bmd-label-floating "><?=ucwords(str_replace("_"," ", $name));?></label>
                        <select class="form-control"  name="<?=$name;?>">
                            <option value="">Select Rate</option>
                            <?php
                            foreach ($gateway as $gt) {
                                ?>
                                <option value="<?=$gt['id'];?>" <?=p_selected(get_setting($name), $gt['id']);?>><?=$gt['name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php
            }
            ?>

                     <div class="form-group fixed-focused">
                         <label class="bmd-label-floating">Bill Rate Cost</label>
                         <select class="form-control" name="cost_bill_rate">
                             <option value="">Select Rate</option>
                             <?php
                             foreach ($rate as $rt) {
                                 ?>
                                 <option value="<?=$rt['id'];?>" <?=p_selected(get_setting("cost_bill_rate"), $rt['id']);?>><?=$rt['name'];?></option>
                                 <?php
                             }
                             ?>
                         </select>
                     </div>

                 <div align="center" class="col-md-12">
                     <br>
                     <button class="btn btn-info btn-raised">
                         <i class="fa fa-spin fa-refresh inactive"></i>
                         <i class="fa fa-save" aria-hidden="true"></i> Save
                     </button>
                 </div>
                 </form>
             </div>
             </div>
                <?php
            }
            ?>
        </div>
    </div>

</div>


<script type="text/javascript">


    addPageHook(function () {
        if (get_hash()) {
            trigger_tab(get_hash());
        }
        return "destroy";

    });

    function activate_bill_tab() {
        trigger_tab("#bill");
    }
    ;


</script>