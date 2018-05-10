<?php
rAccess("manage_reseller");

?>
<div classs="row">
    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-plus" aria-hidden="true"></i> Update Domain
        </div>
        <div class="panel-body">


    <table class="table">
        <tr>
            <td>#</td>
            <td>Domain</td>
            <td>Date</td>
            <td>Option</td>
        </tr>

        <?php
            d()->where("owner", $param1);
            $array = d()->get("domain")->result_array();
            $count = 1;
            foreach($array as $row) {
                ?>
            <tr>
                <td><?=$count++;?></td>
                <td><?=$row['domain'];?></td>
                <td><?=convert_to_datetime($row['date']);?></td>
                <td>
                    <span class="btn btn-raised btn-warning btn-sm" onclick="showAjaxModal('<?=url("modal/popup/reseller.domain_modal/$param1/$row[id]");?>')">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </span>
                    <span class="btn btn-raised btn-danger btn-sm" onclick="confirm_delete('<?=url("reseller/domain/delete/$param1/$row[id]");?>', this, true)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </span>
                </td>
            </tr>
                <?php
            }
        ?>
    </table>

            <br>
            <?php echo form_open(url('reseller/domain/update/'.$param1) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

            <input type="hidden" name="id" value="<?=$param2;?>"/>
            <input type="hidden" name="container" value="#modal_ajax .modal-body"/>

            <div class="form-group">
                <label class="bmd-label-floating">Domain Name</label>
                <input type="text" name="domain" value="<?php
                if(!empty($param2)){
                    d()->where("owner", $param1);
                    d()->where("id", $param2);
                    echo getIndex(d()->get("domain")->row_array(), "domain");
                }
?>" class="form-control"/>
            </div>



            <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-primary btn-raised"><?php echo empty($param2)?"Add":"Update";
                    ?></button>
            </div>
            </form>
    </div>
    </div>

</div>

<?php
    $response_result['current_url'] = "";
    $response_result['dont_hide_ajax_modal'] = true;
?>

