<?php
$category = get_arrange_id_name("income_expense_categories", "id", "name");

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary b-w-0" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    Cash Flow and Profit
                </div>
            </div>

            <div class="panel-body">


                <?php echo form_open(url('report/view') , array('class' => '','target'=>'_top'));

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
                            <input  type="text" name="search" value="<?=$search;?>" class="form-control"/>
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="bmd-label-floating"></label>
                            <button class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
                                                                                                   aria-hidden="true"></i> <i
                                    class="fa fa-search" aria-hidden="true"></i> Select
                            </button>
                        </div>
<div class="col-md-12 type1">
    <b>INCOME CATEGORIES</b>
</div>
                            <div class="col-md-12">
                                <?php
                                    $myIncome = Pay()->methods();
                                    d()->where("type", 1);
                                    $array = get_arrange_id_name("income_expense_categories","id", "id");
                                    $myIncome = array_merge($myIncome, $array);
                                    foreach($myIncome as $key => $value) {

                                        ?>
                                        <div style="margin-top: 0px;" class="checkbox checkbox-secondary checkbox-inline">
                                            <label>
                                                <input <?=p_checked(!$selected || in_array(is_numeric($value)?$value:$key, $incomeCategories));?> type="checkbox" name="income[]" value="<?=is_numeric($value)?$value:$key;?>"/> <?=is_numeric($key)?getIndex($category, $value):$value;?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>
<div class="col-md-12 type1">
    <b>EXPENSES CATEGORIES</b>
</div>
                            <div class="col-md-12 type1">
                                <?php
                                    $myExpense = array("sms"=>"sms","dataplan"=>"dataplan","airtime"=>"airtime","bill"=>"bill");
                                    d()->where("type", 2);
                                    $array = get_arrange_id_name("income_expense_categories","id", "id");
                                    $myExpense = array_merge($myExpense, $array);
                                    foreach($myExpense as $key => $value) {

                                        ?>
                                        <div style="margin-top: 0px;" class="checkbox checkbox-secondary checkbox-inline">
                                            <label>
                                                <input <?=p_checked(!$selected || in_array(is_numeric($value)?$value:$key, $expenseCategories));?> type="checkbox" name="expense[]" value="<?=is_numeric($value)?$value:$key;?>"/><?=is_numeric($value)?getIndex($category, $value):$value;?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>


                    </div>



                </div>
                </form>

<br>

                <div class="row">

                    <!----TABLE LISTING STARTS-->
                    <div class="col-xs-6" style="overflow: auto;">
<h3>CASH INFLOW</h3>
                        <table  class="table table-striped">
                            <thead class="center">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $incomeTotal = 0;
                            $count = 1;
                            foreach ($income as $row):


                                ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td ><?=$row['name'];?></td>
                                    <td ><?php $incomeTotal += $row['amount']; echo format_wallet($row['amount']);?></td>

                                </tr>
                                <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-xs-6" style="overflow: auto;">
<H3>CASH OUTFLOW</H3>
                        <table  class="table table-striped">
                            <thead class="center">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Amount</th>
                                <th>Computed Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $expenseTotal = 0;
                            $profitTotal = 0;
                            $count = 1;
                            foreach ($expense as $row):


                                ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td ><?=$row['name'];?></td>
                                    <td ><?php $expenseTotal += $row['amount']; echo format_wallet($row['amount']);?></td>
                                    <td ><?php if(empty($row['profit'])){
                                            echo "--";
                                        }else{
                                            $profitTotal += $row['profit'];
                                            echo format_wallet($row['profit']);
                                        }?></td>

                                </tr>
                                <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="row" style="color: red;">
                    <div align="right" class="col-xs-6">
                        TOTAL: <b><?=format_wallet($incomeTotal);?></b>
                    </div>
                    <div align="right" class="col-xs-6">
                        TOTAL: <b><?=format_wallet($expenseTotal);?></b><br>
                        COMPUTED PROFIT TOTAL: <?=format_wallet($profitTotal);?>
                    </div>
                    <br><br>
                    <h2 align="right">
                        NET BALANCE = <?=format_wallet($incomeTotal - $expenseTotal);?>
                    </h2>

                </div>

            </div>
        </div>


    </div>
</div>

