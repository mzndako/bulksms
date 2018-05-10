<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_notifications"))
    die("Access Denied");




    ?>
    <?php echo form_open(url('admin/notifications/'.construct_url("update_hp")) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>



            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        Home Page Notification Settings
                    </div>
                </div>

            <div class="panel-body">
                <b>Set Up Notification Popup for all users (Both login or logout users)</b>
<div class="row">
                <div class="col-md-12">

                 <div class="form-group">
                        <label class="bmd-label-floating">Title</label>
                        <input type="text" required name="title" value="<?=get_setting('hp_notification_title');?>" class="form-control"/>
                 </div>


                <div class="form-group focused">
                    <label class="bmd-label-floating">Notification</label>
                    <textarea data-height="150px" data-width="100%" class="form-control summernote" name="message" rows="8"><?=get_setting('hp_notification_message');?></textarea>

                </div>


            <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input  <?=get_setting('hp_notification_show_once') == 1?"checked":"";?> type="checkbox" name="show_once" value="1" class="">
                        Select to show just once per session OR<br>Unselect to show every time the user visit home page</label>
            </div>


                  <div class="form-group checkbox checkbox-secondary">
                        <label>
                            <input <?=empty(get_setting('hp_notification_enabled'))?"":"checked";?> type="checkbox" name="enabled" value="1">
                        Enabled</label>
                 </div>



        </div>

         <div class="col-md-12" align="center">
                    <br><br>
                        <button type="submit" class="btn btn-success btn-raised"> <i class="fa fa-refresh inactive fa-spin" aria-hidden="true"></i>
                            <i class="fa fa-save" aria-hidden="true"></i> Save
                        </button>
         </div>
         </div>
    </div>
    </div>
  </form>

