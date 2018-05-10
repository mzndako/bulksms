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

class Epins extends CI_Controller
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

    public function view($category_id = "", $type = "", $user_id = "", $uploaded_by ="", $search = "", $date1 = "", $date2 = ""){
        rAccess("view_epins");

        if($category_id == "search"){
            $category_id = $this->input->post("category_id");
            $type = $this->input->post("type");
            $user_id = $this->input->post("user_id");
            $uploaded_by = $this->input->post("uploaded_by");
            $search = $this->input->post("search");
            $date1 = $this->input->post("date1");
            $date2 = $this->input->post("date2");
            return return_function("view".construct_url($category_id, $type, $user_id, $uploaded_by,uri_encode($search), parse_date($date1), parse_date($date2)));
        }

        $count = 0;
        $search = trim(uri_decode($search));
        $page_data['search'] = $search;
        $page_data['category_id'] = $category_id;
        $page_data['type'] = $type;
        $page_data['user_id'] = $user_id;
        $page_data['uploaded_by'] = $uploaded_by;
        $page_data['date1'] = empty($date1)?"":$date1;
        $page_data['date2'] = empty($date2)?"":$date2;

        while(true) {
            if ($type == 1) {
                    d()->where("date_used", 0);
            }
            if ($type == 2) {
                    d()->where("date_used !=", 0);
            }


            if (!empty($category_id)) {
                d()->where('category', $category_id);
            }

            if (!empty($page_data['user_id'])) {
                d()->where('user_id', $page_data['user_id']);
            }

            if (!empty($page_data['uploaded_by'])) {
                d()->where('uploaded_by', $page_data['uploaded_by']);
            }

            if (!empty($date1) || !empty($date2)) {
                d()->where('date_used >=', strtotime($date1));
                d()->where('date_used <=', strtotime($date2));
            }

            if (!empty($search)) {
                d()->group_start();
                d()->like('pin', $search);
                d()->or_like('serial', $search);
                d()->group_end();
            }

            if($count == 0){
                datatable_order("#=date,option=date,serial no=serial", "date:desc","type");
                d()->limit(empty(g("length"))?datatable_limit():g("length"));
                d()->offset(empty(g("start"))?0:g("start"));
                $page_data['epins'] = c()->get("epins")->result_array();
            }else if($count == 1) {
                d()->where("date_used !=", 0);
                $page_data['used_pins'] = c()->count_all("epins");
            }else if($count == 2) {
                d()->where("date_used", 0);
                $page_data['unused_pins'] = c()->count_all("epins");
            }else{
                $page_data['epins_count'] = c()->count_all("epins");
                break;
            }

            $count++;
        }

        $page_data['page_name'] = 'epins/view';
        $page_data['page_title'] = "View Epins";
        $this->load->view('backend/index', $page_data);
    }

    public function manage($param1 = "", $param2 = ""){
        rAccess("manage_epins");

        $page_data['page_name'] = 'epins/manage';
        $page_data['page_title'] = "Manage Epins";
        $this->load->view('backend/index', $page_data);
    }


    public function upload($param1 = "", $param2 = ""){
        rAccess("upload_epins");

        if($param1 == "upload"){
            $category = $this->input->post("category");

            if($this->input->post("type") == "file") {
                include 'Simplexlsx.class.php';
                if(empty($_FILES['file']['tmp_name'])){
                    ajaxFormDie("Please upload a file");
                }

                $xlsx = new SimpleXLSX($_FILES['file']['tmp_name']);
            list($num_cols, $num_rows) = $xlsx->dimension();
                $f = -1;
                $error = "";
                $text = "";
                foreach ($xlsx->rows() as $r) {
                    // Ignore the inital name row of excel file
                    $f++;
                    if ($f == 0) {
                        continue;
                    }
                    if($num_cols > 1){
                        $text .= $r[0]."=$r[1]\n";
                    }else{
                        $text .= $r[0]."\n";
                    }
                }

                if(empty(trim($text))){
                    ajaxFormDie("Please upload a valid file format");
                }
            }else{
                $text = $this->input->post("text");
                if(empty(trim($text))){
                    ajaxFormDie("PIN field can not be empty");
                }
            }

            $pins = explode("\n", $text);
            $failed = array();
            $success = 0;
            d()->db_debug = false;
            foreach($pins as $row){
                $row = trim($row);
                if(empty($row)){
                    continue;
                }
                $data = array();
                $data['category'] = $category;
                $x = explode("=", $row);

                if(count($x) == 1){
                    $data['pin'] = $x[0];
                }else{
                    $data['serial'] = $x[0];
                    $data['pin'] = $x[1];
                }

                $data['uploaded_by'] = login_id();
                $data['date'] = time();
                if(c()->insert("epins", $data)){
                    $success++;
                }else{
                    $failed[] = $row;
                }

            }
            $total = $success + count($failed);
            $msg = "$success out of $total PINs successfully uploaded";
            if(count($failed) > 0)
                $msg = "The following PINs could not be uploaded. Might already exist:<br>".implode("<br>", $failed);

            ajaxFormDie("$success out of $total PINs successfully uploaded","success", array("message"=>$msg));


        }

        $page_data['page_name'] = 'epins/upload_epins';
        $page_data['page_title'] = "Upload Epins";
        $this->load->view('backend/index', $page_data);
    }



    public function category($param1 = ""){
        $data['name'] = $this->input->post("name");
        $data['description'] = $this->input->post("description");
        $data['parent_id'] = $this->input->post("parent_id");

        if(empty($data['parent_id']))
            $data['parent_id'] = 0;

        if(empty($data['name']))
            ajaxFormDie("Name can not be empty");

        if(empty($param1)){
            $data['date'] = time();
            c()->insert("epins_category", $data);
            $msg = 'Successfully Created';
        }else{
            $data['active'] = empty($this->input->post("active"))?0:1;

            c()->where("id", $param1);
            c()->update("epins_category", $data);
            $msg = "Successfully Updated";
        }

        return return_function("view", $msg);

    }

    public function category_delete($param1 = "", $param2 = ""){
        rAccess("delete_epins_category");

        d()->group_start();
        d()->where("id", $param1);
        if($param2 == "all")
            d()->or_where("parent_id", $param1);

        d()->group_end();
        c()->delete("epins_category");
        return return_function("view", "Successfully Deleted");
    }




}
