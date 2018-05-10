    <script type="text/javascript">
        $me__ = null;
        $catch = {};
        function showAjaxModal(url, class_, me, $option, success_) {
            // SHOWING AJAX PRELOADER IMAGE
            $me__ = me;
            jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?=assets_url("$theme_path/images/preloader.gif");?>" /></div>');
            if (!is_empty(class_)) {
                $("#modal_ajax .modal-dialog").addClass(class_);
            }

            if($option == undefined)
                $option = {backdrop: true};

            if($(me).data('header') == false || $option.header == false){
                $("#modal_ajax .modal-header").hide();
            }else{
                $("#modal_ajax .modal-header").show();
            }


            if($(me).data('footer') == false || $option.footer == false){
                $("#modal_ajax .modal-footer").hide();
            }else{
                $("#modal_ajax .modal-footer").show();
            }

            if($option == undefined)
                $option = {backdrop: true};

            if($(me).data('backdrop') != undefined){
                $option.backdrop = $(me).data('backdrop');
            }

            if($(me).data('keyboard') == undefined){
                $option.keyboard = $(me).data('keyboard');
            }

            if($option.height == undefined)
                $option.height = "480px";

            jQuery('#modal_ajax .modal-body').css("height", $option.height);

            // LOADING THE AJAX MODAL
            jQuery('#modal_ajax').modal( $option);
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS


            if($(me).data("catch")){
                if($catch[$(me).data("catch")]){
                    jQuery('#modal_ajax .modal-body').html($catch[$(me).data("catch")]);
                    return;
                }
            }

            if($(me).data("container") != undefined) {
                if($(me).data("container") == true){
                    $container = "#modal_container";
                }else{
                    $container = $(me).data("container");
                }
                loadContainer(url, $container );
            }else {
                $.ajax({
                    url: url,
                    success: function (response) {
                        jQuery('#modal_ajax .modal-body').html(response);
                        if(success_ != undefined)
                            success_();
                    },
                    error: function () {

                    }
                });
            }
            return false;
        }

        function showModal(text, me){
            $me__ = me;
            jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
            if(text != undefined)
                jQuery('#modal_ajax .modal-body').html(text);
        }

        function showFullAjaxModal(url, me) {
            $cls = "full_modal";
            return showAjaxModal(url, $cls, me)
        }

        function showAjaxModalNoHeader(url, me) {
            $cls = "full_modal";

            $option = {backdrop: true, header: false, footer: false, height: "620px"};

            return showAjaxModal(url, $cls, me, $option);
        }

        addPageHook(function(){
            eventOnAjaxModalHide();
            $("#modal_ajax").on("hidden.bs.modal", function () {
                $("#modal_ajax .modal-dialog").removeClass("full_modal");
            });
            return "destroy";
        });

        function hideAjaxmodal() {
            jQuery('#modal_ajax').modal('hide');
        }

        function eventOnAjaxModalHide(){
            $("#modal_ajax").on("hidden.bs.modal", function () {
                if(jQuery('#modal_ajax .modal-body').find("input[name=catch]").length > 0){
                    var name = jQuery('#modal_ajax .modal-body').find("input[name=catch]").val();
                    var content = jQuery('#modal_ajax .modal-body').html();
                    $catch[name] = content;
                }

            });
        }

        function nextModal(){
            if(is_empty($me__)){
                return notifyError("No modal opened yet");
            }
            $next = $($me__).parents("tr").first().next().find(".modal_next");
            if($next.length == 0){
                notifyError("End of Next");
            }else{
                $next.trigger("click");
            }
        }

        function prevModal(){
            if(is_empty($me__)){
                return notifyError("No modal opened yet");
            }
            $next = $($me__).parents("tr").first().prev().find(".modal_next");
            if($next.length == 0){
                notifyError("End of Previous");
            }else{
                $next.trigger("click");
            }
        }
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade " id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content ">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $system_name;?></h4>
                </div>
                
                <div class="modal-body" style="height:90%; overflow:auto;">
                
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-raised" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <script type="text/javascript">
        function confirm_delete(delete_url, container, delete_table_row) {
            var options = {};
            if(delete_table_row != undefined){
                options.function_success = function(response){
                    if(response.notification.errorType == "success"){
                        $(container).parents("tr").first().remove();
                    }
                }
            }
            return confirm_modal(delete_url, options, container);
        }


        function show_dialog(me, function_, options) {
            if (options == undefined)
                options = {};

            var container = $(me).data("container") || "";
            options.title = $(me).data("title") || "";
            options.me = me;
            options.text = $(me).data("text") || "Are you sure?";
            options.confirmText = $(me).data("confirmText") || "Yes!";
            options.cancelText = $(me).data("cancelText") || "No!";
            options.confirm = {};
            options.confirm.title = $(me).data("confirmTitle") || 'Processing';
            options.confirm.text = $(me).data("confirmText") || 'Successful';

            if(!is_empty(function_))
                options.runFunction = function_;

            confirm_dialog(me,options.title, container, options);
            return false;
        }

        $me_ = '';
        function confirm_dialog(me, title, container, options) {
            if (options == undefined)
                var options = {};
            $me_ = me;
            options.title = options.title || title;
            options.me = me;
            options.text = options.text || "Are you sure?";
            options.confirmText = options.confirmText || "Yes!";
            options.cancelText = options.cancelText || "No!";
            options.confirm = options.confirm || {};
            options.confirm.title = options.confirm.title || 'Processing';
            options.confirm.text = options.confirm.text || 'Successful';

            options.run_function = options.run_function || function (response) {buttonLoadingStop(me);	}

            var url = '';

            if ($(me).attr("href") != undefined && $(me).attr("href").length > 2) {
                url = $(me).attr("href");

                if (options.runFunction == undefined) {
                    options.runFunction = function (isConfirm) {
                        if (isConfirm) {
                            buttonLoadingStart(me);
                        }
                    }
                }
            } else {
                if (options.runFunction == undefined) {
                    options.runFunction = function (isConfirm) {
                        if (isConfirm) {
                            buttonLoadingStart(me);
                            $(me).parents("form").first().submit();
                        }else{
                            buttonLoadingStop(me);
                        }
                    }
                }
            }
            confirm_modal(url, options, container);
            return false;
        }

        function confirm_modal(delete_url, options, container) {

            if (options == undefined) {
                options = {};
            }
            if (options.title == undefined) {
                options.title = "Are you sure?";
            }
            if (options.text == undefined) {
                options.text = "You will not be able to recover it!";
            }
            if (options.confirmText == undefined) {
                options.confirmText = 'Yes, delete it!';
            }

            if (options.confirm == undefined) {
                options.confirm = {};
                options.confirm.title = 'Deleted!';
                options.confirm.text = 'Data being deleted successfully.';
            }

            if (options.cancelText == undefined) {
                options.cancelText = 'No, cancel plx!';
            }

            if (options.me == undefined) {
                options.me = "";
            }

            if (options.time == undefined) {
                options.time = 2000;
            }

            if (options.cancelable == undefined) {
                options.cancelable = false;
            }

//		jQuery('#modal-4').modal('show', {backdrop: 'static'});
//		document.getElementById('delete_link').setAttribute('href' , delete_url);
            swal({
                title: options.title,
                text: options.text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: options.confirmText,
                cancelButtonText: options.cancelText,
                confirmButtonClass: 'confirm-class',
                cancelButtonClass: 'cancel-class',
                closeOnConfirm: false,
                closeOnCancel: false,
                allowOutsideClick: options.cancelable
            }, function (isConfirm) {

                if (options.runFunction != undefined) {
                    options.runFunction(isConfirm, options.me);
                }

                if (isConfirm) {
                    swal({
                        title: options.confirm.title,
                        text: options.confirm.text,
                        timer: options.time,
                        type: "success"
                    });
                    loadContainer(delete_url, container, options);

                } else {
                    swal({
                        title: 'Cancel!',
                        text: 'Closing in 1 second.',
                        timer: 1200,
                        type: "error"
                    });
//                swal('Cancelled', 'Your imaginary file is safe :)', 'error');
                }

            });
            return false;
        }

        function show_image(image){
            var modal = document.getElementById('myModal');

//		var img = document.getElementById('myImg');
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            modal.style.display = "block";
            modalImg.src = $(image).attr("src");
            captionText.innerHTML = $(image).attr("alt");


        }

	function confirm_modal2(delete_url,additional)
	{
        if(additional != undefined){
            jQuery('#modal-4-danger-text').html(additional);
            jQuery('#modal-4-danger').show();
        }else{
            jQuery('#modal-4-danger').hide();
        }
		jQuery('#modal-4').modal('show', {backdrop: 'static'});

		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" >
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                <h3 style="color: red;" id="modal-4-danger">
                   <i class="fa fa-plus-circle"></i><span id="modal-4-danger-text"></span>
                </h3>
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_login">
        <div class="modal-dialog" style="max-width: 400px;">
            <div class="modal-content"  >

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Please Enter Login Details</h4>
                </div>
                <?php echo form_open(url('login/ajax_login'), array('class' => ' form-groups-bordered','target'=>'_top'));
                ?>
                <input type="hidden" name="function_success" value="hide_login"/>
                <div class="rdow">
                <div class="col-md-12">
                           <div class="form-group" >
                    <label class="bmd-label-floating">Phone or Email</label>
                    <input type="text" name="username" required value="" class="form-control"/>
                </div>

                <div class="form-group" >
                    <label class="bmd-label-floating">Password</label>
                    <input type="password" name="password" value="" required class="form-control"/>
                </div>
                <div class="checkbox">
                    <label data-original-title="Check to always keep you login">
                        <input type="checkbox" name="remember" value="1"/> Don't Log me out automatically
                    </label>
                </div>
                   <div align="center" class="col-md-12">
                       <input type="submit" class="btn btn-info" />

                   </div>
                </div>
                </div>
                    </form>



                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">

                </div>

            </div>
        </div>
    </div>