<!--	<link rel="stylesheet" href="--><?//=assets_url("$theme_path/js/datatables/responsive/css/datatables.responsive.css");?><!--">-->
	<link rel="stylesheet" href="<?=assets_url("$theme_path/js/material-datatables/datatables.min.css");?>">
	<link rel="stylesheet" href="<?=assets_url("$theme_path/js/select2/select2-bootstrap.css");?>">
	<link rel="stylesheet" href="<?=assets_url("$theme_path/js/select2/select2.css");?>">
	<link rel="stylesheet" href="<?=assets_url("$theme_path/js/selectboxit/jquery.selectBoxIt.css");?>">

   	<!-- Bottom Scripts -->
	<script src="<?=assets_url("$theme_path/js/gsap/main-gsap.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/sweetalert2/dist/sweetalert2.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/bootstrap.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/joinable.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/resizeable.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/neon-api.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/toastr.js");?>"></script>
    <script src="<?=assets_url("$theme_path/js/jquery.validate.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/moment.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/fullcalendar/fullcalendar.min.js");?>"></script>
    <script src="<?=assets_url("$theme_path/js/bootstrap-datepicker.js");?>"></script>
    <script src="<?=assets_url("$theme_path/js/fileinput.js");?>"></script>
    
<!--    <script src="--><?//=assets_url("$theme_path/js/jquery.dataTables.min.js");?><!--"></script>-->
<!--	<script src="--><?//=assets_url("$theme_path/js/datatables/TableTools.min.js");?><!--"></script>-->
<!--	<script src="--><?//=assets_url("$theme_path/js/dataTables.bootstrap.js");?><!--"></script>-->
<!--	<script src="--><?//=assets_url("$theme_path/js/datatables/jquery.dataTables.columnFilter.js");?><!--"></script>-->
<!--	<script src="--><?//=assets_url("$theme_path/js/datatables/lodash.min.js");?><!--"></script>-->
<!--	<script src="--><?//=assets_url("$theme_path/js/datatables/responsive/js/datatables.responsive.js");?><!--"></script>-->
	<script src="<?=assets_url("$theme_path/js/material-datatables/datatables.min.js");?>"></script>
    <script src="<?=assets_url("$theme_path/js/select2/select2.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/selectboxit/jquery.selectBoxIt.min.js");?>"></script>

<!--	<script src="$theme_path/tinymce/tinymce.min.js"></script>-->

	<script src="<?=assets_url("$theme_path/js/neon-calendar.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/neon-chat.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/neon-custom.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/neon-demo.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/intro.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/mine.js?$version");?>"></script>
	<script src="<?=assets_url("$theme_path/js/sketch.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/jquery.form.min.js");?>"></script>
	<script src="<?=assets_url("$theme_path/js/nestedsortable.js");?>"></script>
<!--	<script type="text/javascript" src="--><?//=assets_url("$theme_path/ckeditor/ckeditor.js");?><!--"></script>-->
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/datetime/DateTimePicker.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/adminlte/js/fastclick.min.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/adminlte/js/app.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/adminlte/js/jquery.slimscroll.min.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/jquery-fullscreen/jquery.fullscreen-min.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/summernote/dist/summernote.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/amcharts/amcharts.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/amcharts/pie.js");?>"></script>
	<script type="text/javascript" src="<?=assets_url("$theme_path/js/selectize/js/standalone/selectize.js");?>"></script>



	<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>



<?php endif;?>
<a id="perform_click"></a>
<div id="reloadDialog" data-title="Reload Page" data-text="The Site was updated in the background. You most reload the site to continue?" data-confirm-text="Reload Now!"></div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
	var currentPage = "<?=assets_url(uri_string());?>";
	var currentUri = "<?=uri_string();?>";
	var domain = "<?=url();?>";


var datatable;
	function startIntro(){
		var intro = introJs();
		intro.setOption('tooltipPosition', 'auto');
		intro.setOption('showProgress', true);
		intro.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top'])
		intro.onbeforechange(function () {

		});
		intro.onexit(function(){
//			$(".introDark").removeClass("introDark");
		})
		intro.onafterchange(function () {

			if($is_mobile){
				var x = parse_number($(".introjs-tooltip").css("margin-top"));
				$(".introjs-tooltip").css("margin-top", (x + 100) + "px");

				var z = parse_number($(".introjs-tooltip").css("z-index"));
				$(".introjs-tooltip").css("z-index", "-1");

				setTimeout(function() {
					var y = parse_number($(".introjs-tooltip").css("margin-top"));
					if(x+100 != y) {
						$(".introjs-tooltip").css("margin-top", (y + 100) + "px");
					}
//					setTimeout(function() {
						$(".introjs-tooltip").css("z-index", z);
//					}, 1000);
				}, 500);
			}
//			$(".introDark").removeClass("introDark");
//			$(this._introItems[this._currentStep].element).addClass("introDark");
//			$(this._introItems[this._currentStep].element).addClass("introDark");

			if($(this._introItems[this._currentStep].element).data("removeintro")){
				$(this._introItems[this._currentStep].element).removeAttrs("data-intro")
			}
		});
		intro.start();
	}
	jQuery(document).ready(function($)
	{



		var datatable = $("#table_exports").dataTable({
			"sPaginationType": "bootstrap",
			"responsive": true,
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "print",
						"fnSetText"    : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(5, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								if (e.which == 27) {
									datatable.fnSetColumnVis(5, true);
								}
							});
						},

					},
				]
			},

		});

		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});

		$('#dtBox').DateTimePicker({
			dateFormat:	"dd-MM-yyyy"
		});





	});


function select_all(checkbox,select){
	$state = $(checkbox).is(':checked') ;

	var chk = $(select);
	for (i = 0; i < chk.length; i++) {
		chk[i].checked = $state ;
	}

}

	function show_on_select(me, myclass, inverse){
		if((inverse && !$(me).is(":checked")) || (!inverse && $(me).is(":checked"))){
			$(myclass).show(100);
		}else{
			$(myclass).hide(100);
		}
	}

function select_all_checkbox(checkbox,classes){
	if($(checkbox).is(':checked') ){
		$("."+classes+"").prop("checked","checked");// Select All Options
	}else{
		$("."+classes+"").removeAttr("checked");
	}
}

function printThis(id, header){
	$(id).printThis({
		header: header == undefined?"":header
	});
}

function my_alert($text, $type, onclick_, $title, $confirmText){
	if($type == undefined)
		$type = "";

	swal({
			title: $title == undefined?"":$title,
			html: $text,
			type: $type,
			allowOutsideClick: false,
			confirmButtonText: !$confirmText?"OK":$confirmText,
		},
		function(e){
			if(onclick_!=undefined)
				onclick_(e);
		}
	);
}

	function import_contacts(){
		var rep = "";
		$.each($("#mycontacts").find("[type=checkbox]"), function(k, v){
			if( !$(this).is(":checked"))
				return;

			var x = $(this).parents(".checkbox").text().trim();
			rep += "," + x;
		});
		if(is_empty(rep)){
			notifyError("No contact selected");
			return;
		}
		var p = $(".mycontactimports").val();
		$(".mycontactimports").val(p + ", "+ rep);
		$(".mycontactimports").blur();
		hideAjaxmodal();
	}

	function closeAlertNotification(){
		var id = $('#my_notification').find(".close").first().data("id");
		$('#my_notification').hide(100);
		var url = "<?=url("admin/notifications/read/");?>"+id;
		$.ajax({
			url : url,
			cache : false,
			type : "GET",
			timeout:   120000,
			success : function(data) {

			}});
	}

	$version = <?=$version;?>;

	function showDialogNotification($title, $text, id){
		my_alert($text,"",function(){
			var url = "<?=url("admin/notifications/read/");?>"+id;
			$.ajax({
				url : url,
				cache : false,
				type : "GET",
				timeout:   120000,
				success : function(data) {

				}});
		}, $title, "OK. I have Read");
	}
//	$('select').select2();
		
</script>

<style>
	.label{
		font-size: 12px !important;
	}
</style>
