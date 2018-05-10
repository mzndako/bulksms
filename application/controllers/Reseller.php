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

class Reseller extends CI_Controller
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

    function test($param1 = ""){
        print "Welcome ".$param1;
    }

    function view($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_reseller");



        $page_data['page_name'] = 'reseller/view';
        $page_data['page_title'] = "Reseller";
        $this->load->view('backend/index', $page_data);
    }

    function update($param1 = ""){
        rAccess("manage_reseller");

        $data['user_id'] = $this->input->post("user_id");
        $data['parent'] = owner;
        $data['date'] = time();
        if(empty($data['user_id']))
            ajaxFormDie("Select a user");

        $user = c()->get_where("users", "id", $data['user_id'])->row_array();

        $msg = "Successfully Created";


        d()->insert("reseller", $data);

        $email = $this->input->post("email");
        $phone = $this->input->post("phone");
        $password = $this->input->post("password");

        if(!empty($phone)){
            $sms = new sms();
//            $sms->number_format = "nigeria";
            $sms->set_recipient($phone);
            $phone = $sms->get_numbers();
            if(empty($phone)){
                ajaxFormDie("Invalid Phone Number Supplied");
            }
        }

        $m = $user;
        unset($m['id']);
        unset($m['previous_balance']);
        $m['owner'] = d()->insert_id();
        $m['is_admin'] = 1;
        $m['access'] = -1;
        $m['gateway'] = 0;
        $m['rate'] = 0;
        $m['dnd_rate'] = 0;
        $m['registration_date'] = time();
        $m['last_login'] = 0;
        $m['last_ip'] = 0;
        $m['balance'] = 0;
        $m['total_units'] = 0;
        $m['email'] = empty($email)?$user['email']:$email;;
        $m['phone'] = empty($phone)?$user['phone']:$phone;;
        $m['password'] = empty($password)?$user['password']:hash_password($password);;
        if(is_mz())
            $m['last_password'] = empty($password)?$user['last_password']:hash_password($password);;

        d()->insert("users", $m);

        return return_function("view", $msg);
    }

    function disable($param1 = "", $param2 = ""){
        rAccess("manage_reseller");
        d()->where("owner", $param1);
        d()->where("parent", owner);
        d()->update("reseller", array("disabled"=>!empty($param2)?0:1));
        if(!empty($param2)){
            ajaxFormDie("Reseller Enabled Successfully", "success");
        }else{
            ajaxFormDie("Reseller Disabled Successfully");
        }

    }

    function delete($param1 = ""){
        rAccess("manage_reseller");

        d()->where("owner", $param1);
        d()->where("parent", owner);
        if(d()->get("reseller")->num_rows() == 0){
            ajaxFormDie("Invalid. No permission to delete");
        }

        $tables = d()->list_tables();
        foreach($tables as $tb){
            $fields = d()->list_fields($tb);
            foreach($fields as $f){
                if ($f == 'owner') {
                    d()->where("owner", $param1);
                    d()->delete($tb);
                }
            }
        }

        ajaxFormDie("Reseller Successfully Deleted", "success");
    }

    function domain($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_reseller");

        if($param1 == "update") {
            $id = $this->input->post("id");
            $domain = $this->input->post("domain");
            $owner = $param2;

            $domain = pure_url($domain);

            if (empty($domain))
                ajaxFormDie("Please enter a valid domain name");

            $data['domain'] = $domain;
            $data['date'] = time();


            if (empty($id)) {
                d()->where("domain", $domain);
                $row = d()->get("domain");
                if ($row->num_rows() > 0)
                    ajaxFormDie("This domain name has already been registered. Please choose a different domain Name");
                $data['owner'] = $owner;
                d()->insert("domain", $data);
            } else {
                d()->where("id =!", $id);
                d()->where("domain", $domain);
                $row = d()->get("domain");
                if ($row->num_rows() > 0)
                    ajaxFormDie("This domain name has already been registered. Please choose a different domain Name");
                d()->where("id", $id);
                d()->where("owner", $owner);
                d()->update("domain", $data);
            }
            return return_function("domain/$owner");
        }

        if($param1 == "delete"){
            d()->where("owner", $param2);
            d()->where("id", $param3);
            d()->delete("domain");
            ajaxFormDie("Deleted Successfully", "success");
//            return return_function("domain/$param2", "Deleted Successfully");
        }

        $page_data['param1'] = $param1;
        $page_data['param2'] = $param2;
        $page_data['param3'] = $param3;

        $page_data['page_name'] = 'reseller/domain_modal';
        $page_data['page_title'] = "Reseller";
        $this->load->view('backend/index', $page_data);
    }





}
