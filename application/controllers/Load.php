<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *	@author 	: Joyonto Roy
 *	date		: 27 september, 2014
 *	FPS School Management System Pro
 *	http://codecanyon.net/user/FreePhpSoftwares
 *	support@freephpsoftwares.com
 */

class Load extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    public function json($param1 = "", $param2 = "", $param3 = ""){
        rAccess("login");

        header('Content-Type: application/json');

        $result = array();
        if($param1 == "users"){
            $search = $this->input->get("search");
            if(!empty($search)){
                $word = urldecode($search);
//                $word = "gm";
                d()->group_start();
                d()->like("fname", $word);
                d()->or_like("surname", $word);
                d()->or_like("username", $word);
                $filter = filter_numbers($word);
                if(count_numbers($filter) == 1){
                    d()->or_like("phone", $filter);
                }

                d()->or_like("phone", $word);

                d()->or_like("email", $word);
                d()->group_end();
            }

            d()->limit(20);
            $all_users = c()->get("users")->result_array();
            foreach($all_users as $row){
                $m['id'] = $row['id'];
                $m['username'] = empty($row['username'])?"":$row['username'];
                $m['phone'] = $row['phone'];
                $m['balance'] = format_wallet($row['balance']);
                $m['name'] = c()->get_full_name($row);
                $m['names'] = $row['fname']." ".$row['surname'];
                $result[] = $m;
            }
        }

        if($param1 == "sub_categories"){
            d()->order_by("numeric_order", "ASC");
            d()->where("parent_id", $param2);
            $array = c()->get("categories")->result_array();
            foreach($array as $row){
                $result[$row['id']] = $row['name'];
            }
        }

        if($param1 == "properties"){
            d()->where("category_id", $param2);
            $array = c()->get("properties")->result_array();
//            $array = array();
            $str = "";
            $convert2array = string2array("select,radio,checkbox");
            foreach($array as $row){
                $label = $row['label'];
                $name = trim(strtolower(str_replace(" ","_",$row['label'])));
                $data['name'] = $name;
                $data['type'] = $row['type'];
                $data['options'] = in_array($data['type'],  $convert2array)?string2array($row['value']):$row['value'];

                $input = c()->create_input($data);
                $str .=<<<eof
                <div class="form-group">
				<label class="bmd-label-floating">$label</label>
				$input
			</div>
eof;



            }
            $result['result'] = $str;
        }

        echo json_encode($result);
    }


}
