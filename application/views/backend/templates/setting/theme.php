<?php
$backend_theme_path = THEME_FRONTEND_PATH;
$array = scandir($backend_theme_path);

$files = array();
foreach($array as $x){
	if($x == '.' || $x == '..' || $x == 'index.php')
		continue;
	$files[] = str_replace(".php","",$x);
}
?>


<ul class="nav nav-tabs bordered nav-tabs-primary">
	<li class="nav-item">
		<a data-target="#backend" class="nav-link active" data-toggle="tab"><i class="entypo-menu"></i>
			Backend Template
		</a>
	</li>
	<li class="nav-item">
		<a data-target="#frontend" class="nav-link" data-toggle="tab"><i class="entypo-menu"></i>
			Frontend Template
		</a>
	</li>
	<li class="nav-item">
		<a data-target="#menu" class="nav-link" data-toggle="tab"><i class="entypo-menu"></i>
		Menu
		</a>
	</li>
</ul>
<!------CONTROL TABS END------>

<div class="tab-content">
<!--            GENERAL SETTINGS -->
	<div class="tab-pane box row active" id="backend">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">
							<i class="fa fa-desktop" aria-hidden="true"></i>
							Template Settings
						</div>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group tag">
									SKIN COLOR:
								</div>
								<div style="margin-top: 10px; text-align: center">
									<?php
									$colors = tcolor();
									$selcolor = tcolor($skin_color);
									foreach ($colors as $color => $code) {
										?>
										<div data-href="<?=url("setting/theme/default_backend/skin_color/$color");?>" onclick="confirm_dialog(this, 'Select as Skin Color', '', {runFunction: function(confirm,me){
									if(confirm)
										open_link(me);
									}})" style="background: <?= $code; ?>; cursor: pointer; margin-bottom: 10px;">

											<i class="fa fa-thumbs-up" style="color: <?=$code == $selcolor?"white":$code;?>;"
											   aria-hidden="true"></i>
										</div>
										<?php
									}
									?>
								</div>

								<br>
								<div class="form-group tag">
									LOGIN BACKGROUND COLOR (MIX):
								</div>
								<br>
								Color 1:
								<br>
								<input type="color" value="<?=get_setting("theme_login_bg_color1");?>" style="width: 100%; height: 30px; cursor: pointer;" onchange="loadContainer(this)" href="<?=url("setting/theme/default_backend/theme_login_bg_color1");?>" /><br>
								Color 2:
								<br>
								<input type="color" value="<?=get_setting("theme_login_bg_color2");?>" style="width: 100%; height: 30px; cursor: pointer;" onchange="loadContainer(this)" href="<?=url("setting/theme/default_backend/theme_login_bg_color2");?>" />

								Login Header Text Color:
								<br>
								<input type="color" value="<?=get_setting("theme_login_header_text_color");?>" style="width: 100%; height: 30px; cursor: pointer;" onchange="loadContainer(this)" href="<?=url("setting/theme/default_backend/theme_login_header_text_color");?>" />

							</div>


						</div>
					</div>
				</div>
			</div>




		</div>
	</div>





	<!----REPORT CARD SETTINGS--->

	<div class="tab-pane box row" id="frontend">
		<div class="nav-tabs-vertical" id="myclass">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="bmd-label-floating">Select Default Template</label>
						<select href="<?=url("setting/theme/default_frontend");?>" class="form-control" onchange="loadContainer(this)">
<option value="">None</option>
							<?php
								foreach($files as $file) {
									if((!is_mz() || !is_owner()) && $file == "corlate")
										continue;
									$x = $backend_theme_path."/$file/config.php";
									if(!file_exists($x))
										continue;
							  ?>
								<option <?=p_selected(get_setting("current_frontend_theme"), $file);?> value="<?=$file;?>"><?=ucwords(str_replace("_"," ", $file));?></option>
								<?php
								};?>
						</select>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs nav-tabs-black-color">
				<?php
				$active = "active";
				foreach($files as $file) {
					if((!is_mz() || !is_owner()) && $file == "corlate")
						continue;
					$x = $backend_theme_path."/$file/config.php";
					if(!file_exists($x))
						continue;
					?>
					<li class="nav-item">
						<a data-target="#file_<?=$file;?>" class="nav-link <?=$active;?>" data-toggle="tab"><i class=""></i>
							<?=ucwords($file);?>
						</a>
					</li>
					<?php
					$active = "";
				}
				?>
			</ul>
			<div class="tab-content ">
				<!--           LOAD FILES-->
				<?php
				$active = "active";
				foreach($files as $file){
					if((!is_mz() || !is_owner()) && $file == "corlate")
						continue;
					$load_settings = true;
					c()->template_name = $file;
					$x = $backend_theme_path."/$file/config.php";
					if(!file_exists($x))
						continue;
					$default = array();
					include $x;
					?>
					<div class="tab-pane box <?=$active;?>" id="file_<?=$file;?>">
						<div class="row">
							<div class="col-md-12">
								<?php echo form_open(url('setting/theme/update_frontend/'.str_replace(".php", "", $file)) ,
									array('class' => 'form-horizontal  validate','target'=>'_top'));?>
								<div class="panel panel-primary" >

									<div class="panel-heading">
										<div class="panel-title">
											<?=ucwords(str_replace("_", " ", $file));?>  Template
										</div>
									</div>

									<div class="panel-body row">
										<div class="col-lg-offset-2 col-lg-8 col-md-12">
											<?php

											if(!empty($default)){
												foreach($default as $key => $value)
													$settings[$key] = $value;
											}

											foreach($settings as $key => $value) {
												$array = array();
												$dv = "";
												if(is_array($value)){
													$array = $value;
													$array['name'] = $key;
													$dv = getIndex($value, "value");
												}else{
													if(strpos($value,"=") === false)
														$array['name'] = $value;
													else{
														$array = string2array($value);
														$array['name'] = $key;
													}
												}

												$array['label'] = getIndex($array, "label", ucwords(str_replace("_"," ",$array['name'])));
												$array['type'] = getIndex($array, "type","text");
												if($array['type'] == 'image'){
													$array['type_'] = "theme_images";
													$array['id'] = "$file"."_".$array['name'];
												}else {
													$array['value'] = c()->get_template_settings($array['name']);
													if(empty(strip_tags($array['value']))){
														$array['value'] = $dv;
													}
												}


												?>
												<div class="col-md-12" >
													<div class="form-group focused">
														<label class="bmd-label-floating"><?php echo $array['label']; ?></label><?php
														if($array['type'] == "image")
															echo "<br>";

														?>

														<?php echo c()->create_input($array); ?>
													</div>
												</div>

												<?php
											}
											?>
											<div class="col-md-12" align="center">

												<button name="submit" type="submit" class="btn btn-danger btn-raised ">
													<i class="fa fa-refresh fa-spin inactive" aria-hidden="true"></i>  <i class="fa fa-save" aria-hidden="true"></i> Save
												</button>



											</div>
										</div>

									</div>
								</div>
								<?php echo form_close();?>
							</div>




						</div>
					</div>
					<?php
					$active = "";
				} ;?>
				<!----END OF FILE LOADING--->

			</div>
		</div>
	</div>

	<div class="tab-pane box row" id="menu">

		<div class="row">
			<div class="col-sm-3 col-md-offset-1 col-md-3" style="border-right: 1px solid #ccc;">
				<hr>
				<b>CURRENT THEME DEFAULT MENU</b><br>
				<div class="default_menu">
				<?php
					$c = get_setting("current_frontend_theme", "default");
					$c = empty($c)?"default":$c;;
					$file_path = THEME_FRONTEND_PATH."/".$c."/config.php";
					$menu_file = array();

					if(file_exists($file_path)){
						include $file_path;
					}

					if(empty($menu_file)){
						$menu_file = array();
					}

					foreach($menu_file as $row){
						$label = getIndex($row, "label");
						$str = "";
						foreach($row as $key=>$value){
							$str .= " data-$key='$value' ";
						}
						print "<div $str onclick='add_sort(this)'>$label<i class='fa fa-arrow-right pull-right' aria-hidden='true'></i></div>";
					}
				?>

				</div>
				<hr>
				<b>PAGE MENU</b><br>
				<div class="default_menu">
					<?php

					foreach(c()->get_where("page", "disabled", 0)->result_array() as $row){
						$link = "page/$row[id]";
						$label = substr($row['title'], 0, 50);
						print "<div data-show='all' data-link='$link' data-label='$label' onclick='add_sort(this)'>$label<i class='fa fa-arrow-right pull-right' aria-hidden='true'></i></div>";
					}
					?>

				</div>
				<hr>
				<b>CUSTOM MENU</b><br>
				<div>
					<div class="form-group">
						<label class="bmd-label-floating">Name</label>
						<input type="text" value="" name="name" class="form-control" id="sort_label" />
					</div>
					<div class="form-group">
						<label class="bmd-label-floating">Link</label>
						<input type="text" value="" name="link" class="form-control" id="sort_link" />
					</div>
					<div class="form-group">
						<label class="bmd-label-floating">When to Show</label>
						<select id="sort_show" class="form-control">
							<option value="all">All the time</option>
							<option value="login">Show Only When Login</option>
							<option value="logout">Show Only When LogOut</option>
						</select>
					</div>
					<br>
					<div class="col-md-12" align="center">
						<span onclick="add_sort(null)" id="add_menu_btn" class="btn btn-warning btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</span>
						<span id="update_menu_btn" onclick="update_sort()" class="btn btn-info btn-sm inactive"><i class="fa fa-bookmark-o" aria-hidden="true"></i> Update</span>
						<span id="clear_menu_btn" onclick="clear_sort()" class="btn btn-default btn-sm inactive"> <i class="fa fa-eraser" aria-hidden="true"></i> Clear</span>
					</div>
				</div>
			</div>
			<div class="col-sm-9 col-md-6">
				<hr>
				<b>CURRENT MENU</b><BR>
				<ol class="sortable" id="mz_sort">
					<?php
						$menu = new front_menu();

					$x = $menu->show_menu();
					print $x;

						?>
				</ol>
				<br>
				<br>
				<br>
				<div class="col-sm-12" align="center">
			<span class="btn btn-raised btn-success" onclick="save_sort()">
			<i class="fa fa-save" aria-hidden="true"></i>	Save
			</span>
				</div>
			</div>

		</div>




	</div>
</div>

<script type="text/javascript">

	function add_sort(me){
		if(is_empty(me)){
			$link = $("#sort_link").val();
			$label = $("#sort_label").val();
			$show = $("#sort_show").val();
			if(is_empty($link) || is_empty($label)){
				my_alert("Name or Link can not be empty");
				return;
			}
			$("#sort_link").val("");
			$("#sort_label").val("");
			$("#sort_show").val("all");
			$("#sort_show").select2();

			$str = "data-link='"+$link+"' data-show='"+$show+"' data-label='"+$label+"'";
		}else {
			$str = "";
			$label = $(me).data("label");
			$.each($(me).data(), function(key, value){
				$str += " data-"+key+"='"+value+"' ";
			});

		}

		$(".sortable").append("<li id='menu_"+(Math.random() * 80000000)+"' "+$str+"><div><span>"+$label+'</span>'+'<?=$menu->delete_icon();?>'+'<?=$menu->edit_icon();?>'+"</div></li>");

	}

	function save_sort(){
//		$array = $('.sortable').nestedSortable('toArray', {startDepthCount: 0});
		$array = new my_sort().sort($('.sortable > li'));
		post_data('<?=url("setting/theme/update_menu");?>', {menu: $array});
	}

//	<li id="menu_17836755.808698703" data-label="Welcome" data-link="#" data-show="all" data-section="services">	<div><span>Welcome</span><i class="fa fa-trash pull-right" onclick="delete_sort(this)"></i><i class="fa fa-edit pull-right" onclick="edit_sort(this)"></i></div></li>

//	{item_id: "39054785.70847969", parent_id: null, label: "Dashboard", link: "admin", show: "login"}
	function my_sort(){
		var array = [];
		var self = this;
		this.sort = function(row, parent_id){
			$.each($(row), function(){
				$li = $(this);
				$x = {};
				$x.item_id = $li.attr("id");
				$x.parent_id = parent_id || 0;
				$x.label = $li.data("label");
				$x.link = $li.data("link");
				$x.show = $li.data("show");
				array.push($x);
				if($li.find("ol").length > 0)
					self.sort($li.find("ol").first().find(">li"), $x.item_id);
			});
			return array;
		}
	}

	$last_li = null;
	function edit_sort(me){
		$li = $(me).parents("li").first();
		$("#sort_link").val($($li).data("link"));
		$("#sort_label").val($($li).data("label"));
		$("#sort_show").val($($li).data("show"));
		$("#sort_show").select2();

		$("#add_menu_btn").hide();

		$("#update_menu_btn").show();
		$("#clear_menu_btn").show();

		$last_li = $li;
		updateFloatingLabels();
	}

	function clear_sort(){
		$("#sort_link").val("");
		$("#sort_label").val("");
		$("#sort_show").val("all");
		$("#sort_show").select2();

		$("#add_menu_btn").show();

		$("#update_menu_btn").hide();
		$("#clear_menu_btn").hide();
		$last_li = null;
		updateFloatingLabels();
	}

	function update_sort(){
		if(is_empty($last_li)){
			clear_sort();
			return;
		}
		$link = $("#sort_link").val();
		$label = $("#sort_label").val();
		$show = $("#sort_show").val();

		if(is_empty($link) || is_empty($label)){
			my_alert("Name or Link can not be empty. If you need a new Custom Menu, Click on 'Clear' first");
			return;
		}
		$($last_li).data("link", $link);
		$($last_li).data("label", $label);
		$($last_li).data("show", $show);
		$($last_li).find(">div span").text($label);
		clear_sort();

	}

	function delete_sort(me){
		$(me).parents("li").first().remove();
	}

	addPageHook(function(){
		$('.sortable').nestedSortable({
			handle: 'div',
			items: 'li',
			toleranceElement: '> div'
		}).toArray();
	});
</script>