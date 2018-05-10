<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12 col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary b-w-0" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    Upload Pins
                </div>
            </div>



            <div class="panel-body">
                <?php echo form_open(url('epins/upload/upload'), array(
                    'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>

                <input type="hidden" name="function_all" value="show_rejected_epins"/>

                <div class="alert alert-danger alert-dismissable inactive" id="alert_error">
                    <span href="javascript:void(0)" class="close" onclick="$(this).parent().hide(100)" aria-label="close">&times;</span>
                    <span class="alert_content " id="epins_content"></span>
                </div>

                <div class="form-group fixed-focused">
                    <label class="bmd-label-floating">Category</label>
                   <select class="form-control" name="category">
                       <?php
                            d()->where("parent_id", 0);
                            $categories = c()->get("epins_category")->result_array();
                            foreach($categories as $row) {
                                d()->where("parent_id", $row['id']);
                                $subcategories = c()->get("epins_category")->result_array();

                                ?>
                                <optgroup label="<?=$row['name'];?>">
                                    <?php
                                        foreach($subcategories as $row2)
                                            print_option($row2['id'], $row['name']." - ".$row2['name']);
                                    ?>


                                </optgroup>

                        <?php
                            }
                       ?>
                   </select>
                </div>


                <div class="form-group fixed-focused">
                    <div class="radio radio-inline" >
                    <label>
                        <input type="radio" value="file" onchange="show_upload_epins(this.value)" name="type" checked/> Upload Pins
                    </label>
                    </div>

                    <div class="radio" style="margin-left: 10px;">
                    <label>
                        <input type="radio" value="text" onchange="show_upload_epins(this.value)" name="type"/> Type Pins
                    </label>
                    </div>
                </div>
<hr>
                <div class="form-group type-file">
                    An excel file with one column should be uploaded to serve as the PINs. But if two columns are uploaded, the first column will be used as the serial number while the second column will be used as the PIN.
                </div>

                <div class="form-group fixed-focused type-file">
                    <label class="bmd-label-floating">File (xlx, xlxs, cvs)</label>
                    <input type="file" name="file" class="form-control" />
                </div>

                <div class="form-group type-text inactive">
                    Enter your PINs separated by Enter/NewLine (ie each PIN in one line).<br>To enter PINs with serial number, serial number and pin should be in the same line but separated by equal sign (=) e.g BN43234222313333=123456789874.
                    The serial number should come first before the pin
                </div>

                <div class="form-group type-text inactive">
                    <label class="bmd-label-floating">Enter PINs</label>
                    <textarea name="text" rows="10" class="form-control"></textarea>
                </div>

                <div class="col-md-12" align="center">
                    <br>
                <button class="btn btn-warning btn-raised">
                    <i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i> <i class="fa fa-upload" aria-hidden="true"></i> Upload
                </button>
                </div>



        </div>
    </div>

</div>
</div>


<script>
    function show_upload_epins(val){
        $(".type-file").hide();
        $(".type-text").hide();
        if(val == "file"){
            $(".type-file").show(100);
        }else{
            $(".type-text").show(100);
        }
    }

    function show_rejected_epins(response){
        if(response.notification.errorType == "success"){
            $("#alert_error").show();
            $("#alert_error .alert_content").html(response.message== undefined?response.notification.error_:response.message);

        }
    }


</script>
