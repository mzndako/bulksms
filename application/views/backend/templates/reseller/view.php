<div class="col-md-12">
    <button class="btn btn-raised btn-warning pull-right" onclick="showAjaxModal('<?=url("modal/popup/reseller.update_modal/create");?>')">
        Add A Reseller
    </button>
<br><br>


                <table class="table table-bordered partial-datatable" id="table_expeorts">
                	<thead>
                		<tr>
                    		<th>#</th>
                    		<th>Reseller</th>
                    		<th>Domain</th>
                    		<th>Admin</th>
                            <th>Date Registered</th>
                            <th>Enabled</th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                        <?php
                        $users = get_arrange_id("users", "id");
                        d()->where("parent", owner);
                        $reseller = d()->get("reseller")->result_array();
                        $count = 1;
                        foreach($reseller as $row):?>

                        <tr>
							<td><?php echo $count++;?></td>
							<td><?php echo c()->get_full_name(getIndex($users, $row['user_id']));?></td>
                            <td><?php
                                d()->where("owner", $row['owner']);
                                $domain = d()->get("domain")->result_array();
                                $y = array();
                                foreach($domain as $x){
                                    $y[] = $x['domain'];
                                }
                                print implode(", ", $y);
                                ?></td>
							<td>
                                <?php
                                d()->where("id", $row['user_id']);
                                echo c()->get_full_name(d()->get("users")->row_array());?>
                            </td>
                            <td><?=convert_to_date($row['date']);?></td>
                            <td>
                                <div class="switch switch-primary">
                                    <label >
                                        <input type="checkbox" value="1" href="<?=url('reseller/disable/'.$row['owner']);?>" <?=$row['disabled'] == 0?"checked":"";?> onchange="loadContainer(this)"/>
                                    </label>
                                </div>
                            </td>

							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                        <li>
                                            <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo url('modal/popup/reseller.domain_modal/'.$row['owner']);?>');">
                                           <i class="fa fa-globe" aria-hidden="true"></i>    Update Domain
                                            </a>
                                        </li>
                                        <li class="divider"></li>

<li>
                                            <a href="javascript:void(0)" onclick="showFullAjaxModal('<?php echo url('modal/popup/reseller.domain_modal/'.$row['owner']);?>', this);">
                                                <i class="fa fa-adjust" aria-hidden="true"></i>
                                               Update Privileges
                                            </a>
                                        </li>
                                        <li class="divider"></li>

                                    <!-- DELETION LINK -->
                                       <li>
                                           <a href="javascript:void(0)" onclick="confirm_delete('<?php echo url('reseller/delete/'.$row['owner']);?>', this, true)">
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

