<?php

/**
 * Created by PhpStorm.
 * User: MZ
 * Date: 15/12/2016
 * Time: 10:59 AM
 */
class process_array
{
	private $array = null;
	private $default = null;
	private $parameters = array();

	function __construct($array_or_object, $default = "")
	{
		$this->array = $array_or_object;
		$this->default = $default;
	}

	function set_parameters($param)
	{
		$this->parameters = $param;
	}

	function get($value, $default = null)
	{
		$d = $default == null ? $this->default : $default;

		if ($this->array === null)
			return null;

		return $this->check_and_get($value, $d);
	}

	function check_and_get($value, $default = "")
	{
		if (is_object($this->array) && isset($this->array->$value)) {
			return $this->array->$value;
		} else if (is_array($this->array) && isset($this->array[$value])) {
			return $this->array[$value];
		}

		if (isset($this->parameters[$value]) && is_array($this->parameters[$value])) {
			foreach ($this->parameters[$value] as $col) {
				if (is_object($this->array) && isset($this->array->$col)) {
					return $this->array->$col;
				} else if (is_array($this->array) && isset($this->array[$col])) {
					return $this->array[$col];
				}
			}
		}

		return $default;

	}
}

class front_menu
{
	public $menu = array();

	function __construct()
	{
		$menu = json_decode(get_setting("frontend_menu"), true);
		$this->menu = empty($menu)?array():$menu;
	}

	function show_menu($parent_id = "0")
	{
		$result = "";
		$edit = $this->edit_icon();
		$close = $this->delete_icon();

		foreach ($this->children($parent_id) as $row) {
			$str = "";
			if(empty($row['show']))
				$row['show'] = "all";

			foreach($row as $key=>$value){
				if($key == "item_id" || $key == "parent_id")
					continue;
				$str .= " data-$key='$value' ";
			}
			$result .= '<li id="menu_' . $row['item_id'] . '" '.$str.' >	<div><span>' . $row['label'] ."</span>".$close .$edit.'</div>';
			$x = $this->children($row['item_id']);
			if (!empty($x)) {
				$result .= "<ol>";
				$result .= $this->show_menu($row['item_id']);
				$result .= "</ol>";
			};

			$result .= "</li>";
		}
		return $result;
	}

	function delete_icon(){
		return '<i class="fa fa-trash pull-right" onclick="delete_sort(this)"></i>';
	}

	function edit_icon(){
		return '<i class="fa fa-edit pull-right"  onclick="edit_sort(this)"></i>';
	}

	function children($item_id = "")
	{
		$array = array();
		foreach ($this->menu as $row) {
			if ((empty($row['parent_id']) && empty($item_id)) || $row['parent_id'] == $item_id) {
				$array[] = $row;
			}
		}
		return $array;
	}

}

/**
 * Generate HTML for multi-dimensional menu from MySQL database
 * with ONE QUERY and WITHOUT RECURSION
 * @author J. Bruni
 */
class MenuBuilder
{
	public $second_access = false;
	private $permission = array();

	function generate_menu($access = '')
	{
		$this->permission = $access;
		return $this->build_menu($this->get_menu());
	}

	function build_menu($rows, $parent = 0, $depth = 0)
	{
		static $first = false;
		$id1 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
		$id2 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);

		$class = empty($parent) ? "" : "";
		$result = "";
		if (empty($parent)) {
			$result .= '<li>
                                    <a ajax="true" href="' . url("admin/dashboard") . '">
<i class="fa fa-dashboard"></i>                       <span class="btn-title">DASHBOARD</span>


                                    </a>
                       </li>
                                    ';
		}
		foreach ($rows as $row) {


			$icon = "<i class='" . $row['fa-icon'] . "'></i>";
			$xx = empty($parent) ? "" : "in";


			if ($row['parent_id'] == $parent) {

				if ($this->has_children($rows, $row['id'])) {
					$a = $this->children_has_permission($rows, $row['id']);
					if (empty($a)) {
						continue;
					}

					if (!empty($parent)) {
						$id1 = "";
						$id2 = "";
					}

					$show = "";
					if (!$first) {
						$show = "collapsed";
					} else {
						$xx = 'in';
					}
					$first = false;
					$result .= '<li class="treeview">
                                    <a href="#">
                                        <span>' . $icon . ' ' . $row['title'] . '</span>

                                        <i class="pull-right fa fa-caret-down"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                    ';
					$result .= $this->build_menu($rows, $row['id']);
					$result .= '</ul>';

				} else {
					$treemenu = empty($parent) ? "" : "";
					if (!$this->has_permission($row['access']))
						continue;

					$result .= '
                                    <li class="' . $treemenu . '">
                                    <a ajax=true href="' . url($row['link']) . '" >
                                            <span >
                                      ' . $icon . ' ' . $row['title'] . '</span>

                                </a>
                                ';
				}
				$result .= "</li>";
			}
			$id1 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
			$id2 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
		}
		if (empty($parent)) {
			$result .= '<li>
                                    <a  data-href="' . url("login/logout") . '" href="javascript:void(0)" data-title="Logout?" onclick="show_dialog(this, function(confirm, me){ if(confirm) open_link(me)})"  > <span style="color: red;" ><i class="fa fa-sign-out"></i> LOGOUT</span>


                                    </a>
                        </li>
                                    ';
		}
		$result .= "";

		return $result;
	}

	function children_has_permission($rows, $id)
	{
		foreach ($rows as $row) {
			if ($row['parent_id'] == $id) {
				if ($this->has_children($rows, $row['id'])) {
					if ($this->children_has_permission($rows, $row['id']))
						return true;
				}
				if ($this->has_permission($row['access']))
					return true;
			}
		}
		return false;
	}

	function has_children($rows, $id)
	{
		foreach ($rows as $row) {
			if ($row['parent_id'] == $id)
				return true;
		}
		return false;
	}

	function has_permission($access)
	{
		$x = $access;
//		return true;

		if (!$this->second_access)
			return hAccess($access);
//		return true;
		return in_array($access, $this->permission);
	}

	function get_menu($all_menu = false)
	{

		include __DIR__."/menu.php";
		$all = explode("\n", str_replace("\r","",$menu));
		$mymenu = array();
		$count = 9999;
		foreach($all as $row){
			$x = explode(",", $row);
			$y['id'] = empty($x[0])?$count++:$x[0];
			$y['title'] = $x[1];
			$y['parent_id'] = $x[2];
			$y['access'] = $x[3];
			$y['link'] = $x[4];
			$y['fa-icon'] = $x[5];
			$y['is_menu'] = parse_number(!isset($x[6])?"1":$x[6]);
			$y['for_members'] = (int) empty_0($x[7])?"1":$x[7];
			if (!$all_menu && $y['is_menu'] != 1)
				continue;
			$mymenu[$y["id"]] = $y;
		}
		return $mymenu;
		d()->order_by("position", "ASC");
		d()->order_by("id", "ASC");
		if (!$all_menu)
			d()->where("is_menu", 1);

		$menu = d()->get("menu_item")->result_array();
		return $menu;
	}

	function generate_permission($access = array())
	{
		$this->permission = $access;
		return $this->permission_menu($this->get_menu(true), 0);
	}

	function permission_menu($rows, $parent = 0, $loop = 1)
	{
		static $first = false;
		$id1 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
		$id2 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);

		$class = empty($parent) ? "my-main-list" : "my-list";
		$result = "";
		$result2 = "";
		foreach ($rows as $row) {
//			if(empty($row['parent_id']))
//				continue;

			$icon = !empty($row['fa-icon']) ? "<i class='" . $row['fa-icon'] . "'></i>" : "<i class='material-icons pull-left icon'>" . $row['material-icon'] . "</i>";
//                        $xx = $this->page_name == $key?"background: black; color: white;":"";
			$xx = empty($parent) ? "" : "in";
			$col = "col-md-4 col-lg-3 m-t-10";

			if ($row['parent_id'] == $parent) {

				if ($this->has_children($rows, $row['id']) && $loop == 1) {
					if (!empty($parent)) {
						$id1 = "";
						$id2 = "";
					}

					$show = "";
					if (!$first) {
						$show = "collapsed";
					} else {
						$xx = 'in';
					}
					$first = false;
//					if (empty($row['parent_id'])) {
//						$result .= $this->permission_menu($rows, $row['id']);
//						continue;
//					}

					$result .= '<div class="'.$col.'">
									<div class="panel panel-success m-b-2">
	                                    <div class="panel-heading"  data-parent="#' . $id1 . '" data-target="#' . $id2 . '">
	                                    <div  class="checkbox inline-block checkbox-secondary pos-rel pull-left">

                        <label>
                            <input type="checkbox" onclick="select_all_checkbox(this,\'permission_' . $row['id'] . '\');" value="1">
                        </label>
                    </div>
	                                        <span class="btn-title">' . $icon . ' ' . $row['title'] . '</span>


	                                        <i class="pull-right fa fa-caret-down"></i>
	                                    </div>
                                    </div>

                                    ';
					$result .= $this->permission_menu($rows, $row['id'], $loop + 1);
					$result .= '</div>';

				} else {
					$access = $row['access'];
					$s = $this->has_permission($access) ? "checked" : "";
					$add = empty($row['parent_id'])?$col:"";
					$x = '
                             <div>      <div class="checkbox inline-block checkbox-secondary pos-rel">
' . $icon . '
                        <label>
                            <input type="checkbox" class="all_permission permission_' . $row['parent_id'] . '" value="' . $row['access'] . '" ' . $s . ' name="' . $row['id'] . '">  ' . $row['title'] . '
                        </label>
                    </div>
                    </div>
                                ';
					if(empty($row['parent_id'])){
						$result2 .= $x;
					}else
						$result .= $x;
				}
				$result .= "";
			}
			$id1 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
			$id2 = "mz" . substr(uniqid(), rand(1, 7), 10) . "_" . rand(1, 10000);
		}
//		$result.= "</div>";

		if(!empty($result2)){
			$result2 = "<div class='$col'>".'<div class="panel panel-success m-b-2">
	                                    <div class="panel-heading">Others
	                                    </div>
                                    </div>'."$result2</div>";
		}

		return $result.$result2;
	}


}