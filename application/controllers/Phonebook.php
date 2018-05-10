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

class Phonebook extends CI_Controller
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

    function view($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_phonebook");

        $user_id = "";
        $keyword = "";

        if($param1 == "search"){
            $keyword = $this->input->post("keyword");
            $user_id = $this->input->post("user_id");

            if(!empty($keyword)){
                d()->group_start();
                d()->like("name", $keyword);
                d()->or_like("numbers", $keyword);
                d()->group_end();
            }

            if(!empty($user_id)){
                d()->where("user_id", $user_id);
            }

            d()->limit(200);
            d()->order_by("name", "ASC");
            $phonebook = c()->get("phonebook")->result_array();
        }else{
            d()->limit(200);
            d()->order_by("name", "ASC");
            $phonebook = c()->get("phonebook")->result_array();
        }

        $page_data['user_id'] = $user_id;
        $page_data['keyword'] = $keyword;

        $page_data['phonebook'] = $phonebook;
        $page_data['page_name'] = 'phonebook/view';
        $page_data['page_title'] = "Phonebook";
        $this->load->view('backend/index', $page_data);
    }

    function update($param1 = "", $param2 = ""){
        rAccess("manage_phonebook");

        $data['name'] = $this->input->post("name");
        $data['numbers'] = $this->input->post("numbers");
        $data['date'] = time();

        if(empty($data['name']) || empty($data['numbers']))
            ajaxFormDie("Name or Number Field can not be empty");

        if(empty($param1)){
            $data['user_id'] = login_id();
            c()->insert("phonebook", $data);
            $msg = "Successfully Created";
        }else{
            d()->where("id", $param1);
            if(!is_admin()) {
                d()->where("user_id", login_id());
            }
            c()->update("phonebook", $data);
            $msg = "Successfully Updated";
        }

        if(!empty($param2)){
            ajaxFormDie("Successfully Created", "success", array("hide_ajax_modal"=>true));
        }

        return return_function("view", $msg);
    }


    function delete($param1 = ""){
        rAccess("manage_phonebook");

        d()->where("id", $param1);
        if(!is_admin())
            d()->where("user_id", login_id());

        c()->delete("phonebook");

        ajaxFormDie("Successfully Deleted", "success");
    }






}