<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_gateway"))
    die("Access Denied");

this()->load->library("Billpayment");
$b = new Billpayment();
$b->set_gateway($param1);
$bill_gateway = $b->bill_gateway();

?>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?=ucwords(getIndex($bill_gateway, $param1));?> Setting
                    </div>
                </div>
            </div>
            <div class="panel-body gateway-modal">

                <?php echo form_open(url('setting/bill_gateway/update_setting'.construct_url($param1)) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>


                <?php
                $config = $b->config();
                    foreach($config as $name => $options){
                        $data = array();
                        if(is_array($options)){
                            $data = $options;
                            $data['name'] = $name;
                        }else{
                            $data['name'] = $options;
                        }

                        $data['value'] = $b->get_mysetting($data['name']);

                        $label = empty(getIndex($data, "label"))?ucwords(str_replace("_", " ",$data['name'])):getIndex($data, "label");
                ?>

                <div class="form-group" >
                    <label class="bmd-label-floating"><?=$label;?></label>
                    <?=c()->create_input($data);?>

                </div>


                <?php
                    }
                ?>






                <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised">
                            <i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-save" aria-hidden="true"></i>
                            Save
                        </button>
                </div>
                </form>
            </div>

        </div>
    </div>

