<div class="col-md-12">
    <br>
    <button class="btn btn-raised btn-info" onclick="showAjaxModal('<?=url("modal/popup/phonebook.view_modal");?>')">
   <i class="fa fa-plus" aria-hidden="true"></i>     Add Contact
    </button>
<br><br>

    <?php echo form_open(url('phonebook/view/search') , array('class' => '','target'=>'_top'));

    ?>
    <div class="row" style="margin-bottom: 5px;">

        <div class="col-md-12">
            <div class="col-md-4 form-group">
                <label class="bmd-label-floating">Search Contacts</label>
                <input type="text" name="keyword" value="<?=$keyword;?>" class="form-control"/>
            </div>

            <?php
            if(is_admin()) {
								$all_users = get_arrange_id("users", "id");
//                $all_users = array();;
                ?>
                <div class="col-md-4 form-group">
                    <label class="bmd-label-floating">Username</label>
                    <select name="user_id" class="form-control user-select2">
                        <option value="">All Users</option>
                        <?php
                        foreach($all_users as $user) {
                            if(empty($user_id))
                                break;

                            if($user['id'] == $user_id) {
                                ?>
                                <option selected value="<?= $user['id']; ?>"><?= c()->get_full_name($user); ?></option>
                                <?php
                                break;
                            }
                        }
                        ?>
                    </select>

                </div>
                <?php
            }
            ?>
            <div class="col-md-4 form-group">
                <label class="bmd-label-floating"></label>
                <button name="search" class="btn btn-raised btn-block btn-primary" ><i class="fa fa-refresh inactive fa-spin"
                                                                                       aria-hidden="true"></i> <i
                        class="fa fa-search" aria-hidden="true"></i> Search
                </button>
            </div>

        </div>



    </div>
    </form>


                <table class="table table-bordered partial-datatable" id="table_expeorts">
                	<thead>
                		<tr>
                    		<th>#</th>
                            <?php
                            if(is_admin()) {
                                ?>
                                <th>Username</th>
                                <?php
                            }
                            ?>
                    		<th>Name</th>
                    		<th>Contacts</th>
                            <th>Date Modified</th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                        <?php
                        $users = get_arrange_id("users", "id");

                        $count = 1;
                        foreach($phonebook as $row):?>

                        <tr>
							<td><?php echo $count++;?></td>
                            <?php
                                if(is_admin()) {
                                    ?>
                                    <td><?php echo c()->get_full_name(getIndex($users, $row['user_id'])); ?></td>
                                    <?php
                                }
                            ?>
                            <td>
                                <?=$row['name'];?>
                            </td>
                            <td>
                                <?php
                                    $numbers = $row['numbers'];
                                    $num = explode(",", $numbers);
                                    if(count($num) > 1){
                                        echo $num[0]. " (".count($num)." numbers)";
                                    }else{
                                        echo "$numbers";
                                    }
                                ?>
                            </td>
                            <td>
                                <?=convert_to_datetime($row['date']);?>
                            </td>


							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Options <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                        <li>
                                            <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo url('modal/popup/phonebook.view_modal/'.$row['id']);?>');">
                                           <i class="fa fa-edit" aria-hidden="true"></i>    Update
                                            </a>
                                        </li>
                                        <li class="divider"></li>


                                    <!-- DELETION LINK -->
                                       <li>
                                           <a href="javascript:void(0)" onclick="confirm_delete('<?php echo url('phonebook/delete/'.$row['id']);?>', this, true)">
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

