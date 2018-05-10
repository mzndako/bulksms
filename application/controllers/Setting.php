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

class Setting extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Billpayment');
        $this->load->library('PaymentMethods');
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
    }

    function general($param1 = "", $param2 = "", $param3 = ""){
        rAccess("general_setting");

        if($param1 == "update"){
            $company = general_settings($param2);
            foreach($company as $k => $v){
                if(is_numeric($k))
                    $k = $v;
                set_setting($k, parse_string($this->input->post($k)));
            }

            set_setting("force_https", empty($this->input->post("force_https"))?0:1);

            if($this->input->post("site_name") !== null) {
                set_setting("site_name", $this->input->post("site_name"));
                set_setting("currency", $this->input->post("currency"));
                set_setting("currency_suffix", $this->input->post("currency_suffix"));
            }
            ajaxFormDie("Successfully Saved", "success");
        }

        if($param1 == 'template'){
            if($param2 == 'skin_color')
                set_setting('skin_color', $param3);

            redirect(url("setting/general#templateBox"));
        }

        if($param1 == "upload_logo"){
            $x = c()->move_image("logo", "logo", "logo", false, false, "Logo", 1024 * 2, ".jpg, .png, .gif, .jpeg");
            if($x !== true){
                ajaxFormDie($x);
            }

            $x = c()->move_image("favicon", "favicon", "favicon", false, false, "Favicon", 200, ".ico");
            if($x !== true){
                ajaxFormDie($x);
            }
            ajaxFormDie("Files Successfully Uploaded", "success");
        }


        $page_data['page_name'] = 'setting/general';
        $page_data['page_title'] = "General Setting";
        $this->load->view('backend/index', $page_data);
    }

    function payment_gateway($param1 = "", $param2 = "", $param3 = "", $param4 = ""){
        rAccess("payment_gateway");

        if($param1 == "save"){
            $pg = new PaymentMethods();
            foreach($pg->atm_methods() as $key1 => $config) {
                foreach ($config['options'] as $key2 => $options) {
                    if(!is_array($options))
                        $key2 = $options;

                    $pg->save_settings("atm_{$key1}_$key2", parse_string($this->input->post("atm_{$key1}_$key2")));
                }
            }

            foreach($pg->bitcoin_methods() as $key1 => $config) {
                foreach ($config['options'] as $key2 => $options) {
                    if(!is_array($options))
                        $key2 = $options;

                    $pg->save_settings("bitcoin_{$key1}_$key2", parse_string($this->input->post("bitcoin_{$key1}_$key2")));
                }
            }

            $pg->save_settings("bank_accounts", parse_string($this->input->post("bank_accounts")));
            $pg->save_settings("internet_accounts", parse_string($this->input->post("bank_accounts")));
            $pg->save_settings("mobile_accounts", parse_string($this->input->post("bank_accounts")));
            $pg->save_settings("airtime_accounts", parse_string($this->input->post("bank_accounts")));

            $pg->save_settings("bank_detail", parse_string($this->input->post("bank_detail")));
            $pg->save_settings("internet_detail", parse_string($this->input->post("internet_detail")));
            $pg->save_settings("mobile_detail", parse_string($this->input->post("mobile_detail")));
            $pg->save_settings("airtime_network", parse_string($this->input->post("airtime_network")));
            $pg->save_settings("airtime_detail", parse_string($this->input->post("airtime_detail")));
            $pg->save_settings("airtime_transaction_fee", parse_string($this->input->post("airtime_transaction_fee")));
            $pg->save_settings("airtime_email", parse_string($this->input->post("airtime_email")));

            ajaxFormDie("Saved Successfully", "success");
        }

        if($param1 == "enabled"){
            if($param3 == "reseller"){
                $param3 = $param4;
                $param2 = "{$param2}_reseller";
            }
            pay()->save_method_status($param2,empty($param3)?0:1);
            if(empty($param3)){
                ajaxFormDie("Disabled Successfully");
            }else{
                ajaxFormDie("Enabled Successfully", "success");
            }
        }

        if($param1 == 'template'){
            if($param2 == 'skin_color')
                set_setting('skin_color', $param3);

            redirect(url("setting/general#templateBox"));
        }


        $page_data['page_name'] = 'setting/payment_gateway';
        $page_data['page_title'] = "Payment Gateway";
        $this->load->view('backend/index', $page_data);
    }

    function theme($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_theme");

        if($param1 == "update"){
            $company = general_settings("company");
            foreach($company as $k => $v){
                set_setting($k, parse_string($this->input->post($k)));
            }
            set_setting("site_name", $this->input->post("site_name"));
            set_setting("currency", $this->input->post("currency"));
            ajaxFormDie("Successfully Saved", "success");
        }

        if($param1 == "update_menu"){
            set_setting("frontend_menu", json_encode($this->input->post("menu")));
        }

        if($param1 == 'default_backend'){
            if($param2 == 'skin_color'){
                set_setting('skin_color', $param3);
                redirect(url("setting/theme"));
            }

            if($param2 == "theme_login_bg_color1"){
                set_setting('theme_login_bg_color1', "#".$param3);
            }

            if($param2 == "theme_login_bg_color2"){
                set_setting('theme_login_bg_color2', "#".$param3);
            }

            if($param2 == "theme_login_header_text_color"){
                set_setting('theme_login_header_text_color', "#".$param3);
            }

            ajaxFormDie("Save Successfully", "success");
        }

        if($param1 == "default_frontend"){
            if(empty($param2)){
                ajaxFormDie("Please select a valid theme");
            }
            set_setting('current_frontend_theme', $param2);
            ajaxFormDie("'$param2' Set as the default theme.", "success");
        }

        if($param1 == "update_frontend"){
            if(empty($param2)){
                ajaxFormDie("Error updating....");
            }
            foreach($this->input->post() as $key => $value){
                save_setting("theme_".$param2."_$key", $value);
            }
            foreach($_FILES as $image => $files){
                c()->move_image($image,"theme_images", $param2."_$image");
            }

            ajaxFormDie("Saved Successfully", "success");
        }


        $page_data['page_name'] = 'setting/theme';
        $page_data['page_title'] = "Manage Site Theme";
        $this->load->view('backend/index', $page_data);
    }


    function gateway($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_gateway");

        if($param1 == "update"){
            $data['name'] = trim($this->input->post("name"));
            $data['send_api'] = trim($this->input->post("send_api"));
            $data['success_word'] = trim($this->input->post("success_word"));
            $data['balance_api'] = $this->input->post("balance_api");
            $data['method'] = $this->input->post("method");
            $data['unicode_api'] = $this->input->post("unicode_api");
            $data['flash_api'] = $this->input->post("flash_api");
            $data['delivery_api'] = $this->input->post("delivery_api");
            $data['batch'] = parse_number($this->input->post("batch"));
            $data['route'] = $this->input->post("route");
            $data['tag'] = empty($this->input->post("tag"))?"":$this->input->post("tag");

            if(empty($data['name']))
                ajaxFormDie("Please provide a name");

            if(empty($data['send_api']) || empty($data['success_word'])){
                ajaxFormDie("Send API or Success Word can not be empty");
            }

            if(!preg_match("/https?:\/\//", $data['send_api'])){
                ajaxFormDie("Send API must begin with http:// or https://");
            }

            if(empty($this->input->post("special_price")) || empty($this->input->post("price"))){
                $data['rate'] = "";
            }else{
                if($this->input->post("price") == "-1"){
                    if(empty($this->input->post("pricebox")))
                        ajaxFormDie("The custom price can not be empty");
                    $data['rate'] = $this->input->post("pricebox");
                }else{
                    $data['rate'] = $this->input->post("price");
                }
            }


            if(empty($param2)){
                $data['date'] = time();
                c()->insert("gateway", $data);
                $msg = "Successfully Created";
            }else{
                c()->where("id", $param2);
                c()->update("gateway", $data);
                $msg = "Successfully Updated";
            }

            return return_function("gateway", $msg);
        }

        if($param1 == "default_dnd_gateway"){
            if(c()->get_row("gateway", "id", "$param2", "active") != "1" && $param2 != "reseller")
                ajaxFormDie("This gateway is deactivated. Please activate first");
            set_setting("default_dnd_gateway", $param2);
        }

        if($param1 == "default_gateway"){
            if(c()->get_row("gateway", "id", "$param2", "active") != "1" && $param2 != "reseller")
                ajaxFormDie("This gateway is deactivated. Please activate first");
            set_setting("default_gateway", $param2);
        }

        if($param1 == "activate"){
            if(empty($param3)){
                if($param2 == get_setting("default_gateway"))
                    ajaxFormDie("Can Not Deactivate Default Gateway");
                if($param2 == get_setting("default_dnd_gateway"))
                    ajaxFormDie("Can Not Deactivate Default DND Gateway");
            }

            d()->where("id", $param2);
            c()->update("gateway", array("active"=>empty($param3)?0:1));
            if(empty($param3)){
                ajaxFormDie("Deactivated Successfully");
            }else{
                ajaxFormDie("Activated Successfully", "success");
            }
        }

        if($param1 == "delete"){
                if($param2 == get_setting("default_gateway"))
                    ajaxFormDie("Can Not Delete Default Gateway");
                if($param2 == get_setting("default_dnd_gateway"))
                    ajaxFormDie("Can Not Delete Default DND Gateway");

            d()->where("id", $param2);
            c()->delete("gateway");
            ajaxFormDie("Delete Successful", "success");
        }





        $page_data['page_name'] = 'setting/gateway';
        $page_data['page_title'] = "Gateway Setting";
        $this->load->view('backend/index', $page_data);
    }


    function rate($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_rate");

        if($param1 == "update"){
            $data['name'] = trim($this->input->post("name"));
            $data['rate'] = $this->input->post("rate");

            if(empty($data['name']))
                ajaxFormDie("Please provide a name");

            if(is_empty($data['rate'])){
                ajaxFormDie("Rate can not be empty");
            }

            if(empty($param2)){
                $data['date'] = time();
                c()->insert("rate", $data);
                $msg = "Successfully Created";
            }else{
                c()->where("id", $param2);
                c()->update("rate", $data);
                $msg = "Successfully Updated";
            }

            return return_function("rate", $msg);
        }

        if($param1 == "update_bill"){
            $data['name'] = trim($this->input->post("name"));

            if(empty($data['name']))
                ajaxFormDie("Please provide a name");

            $bill_array = bill()->bill_payment_rate();
            $bill = array();
            foreach($bill_array['airtime'] as $airtime){
                $bill['airtime'][$airtime] = $this->input->post("airtime_$airtime");
            }

            foreach($bill_array['dataplan'] as $airtime=> $dataplan) {
                foreach ($dataplan as $unit => $amount) {
                    $bill['dataplan'][$airtime][$unit] = preg_replace("/[^\d.-]/","",$this->input->post("$airtime"."_".str_replace(".","_",$unit)));
                }
            }

            foreach($bill_array['bill'] as $package=> $bills) {
                foreach ($bills as $plan => $y) {
                    $bill['bill'][$package][$plan] = preg_replace("/[^\d.]/","",$this->input->post("$package"."_$plan"));
                }
            }

            $data['bill'] = json_encode($bill);

            if(empty($param2)){
                $data['date'] = time();
                c()->insert("bill_rate", $data);
                $msg = "Successfully Created";
            }else{
                c()->where("id", $param2);
                c()->update("bill_rate", $data);
                $msg = "Successfully Updated";
            }

            return return_function("rate/#bill", $msg);
        }

        if($param1 == "activate"){
            if(empty($param3)){
                if($param2 == get_setting("default_rate"))
                    ajaxFormDie("Can Not Deactivate Default Rate");
                if($param2 == get_setting("default_dnd_rate"))
                    ajaxFormDie("Can Not Deactivate Default DND Rate");
            }
            d()->where("id", $param2);
            c()->update("rate", array("active"=>empty($param3)?0:1));
            if(empty($param3)){
                ajaxFormDie("Deactivated Successfully");
            }else{
                ajaxFormDie("Activated Successfully", "success");
            }
        }

        if($param1 == "activate_bill"){
            d()->where("id", $param2);
            c()->update("bill_rate", array("active"=>empty($param3)?0:1));
            if(empty($param3)){
                ajaxFormDie("Deactivated Successfully");
            }else{
                ajaxFormDie("Activated Successfully", "success");
            }
        }

        if($param1 == "default_rate"){
            if(c()->get_row("rate", "id", "$param2", "active") != "1")
                ajaxFormDie("This rate is deactivated. Please activate it first");
            set_setting("default_rate", $param2);
        }

        if($param1 == "default_dnd_rate"){
            if(c()->get_row("rate", "id", "$param2", "active") != "1")
                ajaxFormDie("This rate is deactivated. Please activate it first");

            set_setting("default_dnd_rate", $param2);
        }

        if($param1 == "default_bill_rate"){
            set_setting("default_bill_rate", $param2);
            return return_function("rate");
        }

        if($param1 == "update_cost"){
            set_setting("cost_sms_rate", $this->input->post("cost_sms_rate"));
            set_setting("cost_dnd_rate", $this->input->post("cost_dnd_rate"));
            set_setting("cost_bill_rate", $this->input->post("cost_bill_rate"));
            set_flash_message("Saved Successfully");
            return return_function("rate/#cost");
        }


        if($param1 == "delete"){
            if($param2 == get_setting("default_rate"))
                ajaxFormDie("Can Not Delete Default Rate");
            if($param2 == get_setting("default_dnd_rate"))
                ajaxFormDie("Can Not Delete Default DND Rate");

            d()->where("id", $param2);
            c()->delete("rate");
            ajaxFormDie("Delete Successful", "success");
        }

        if($param1 == "delete_bill"){
            d()->where("id", $param2);
            c()->delete("bill_rate");
            ajaxFormDie("Delete Successful", "success");
        }



        $page_data['page_name'] = 'setting/rate';
        $page_data['page_title'] = "Rate/Price Setting";
        $this->load->view('backend/index', $page_data);
    }

    function bill_gateway($param1 = "", $param2 = ""){

        if($param1 == "save"){


            $bill_array = bill()->bill_payment_rate();
            $bill = array();
            foreach($bill_array['airtime'] as $airtime){
                $bill['airtime'][$airtime] = $this->input->post("airtime_$airtime");
            }

            foreach($bill_array['dataplan'] as $airtime=> $dataplan) {
                foreach ($dataplan as $unit => $amount) {
                    $bill['dataplan'][$airtime][$unit] = $this->input->post("$airtime"."_".str_replace(".","_",$unit));
                }
            }

            foreach($bill_array['bill'] as $package=> $bills) {
                foreach ($bills as $plan => $y) {
                    $bill['bill'][$package][$plan] = $this->input->post("$package"."_$plan");
                }
            }

            $bills = json_encode($bill);

            set_setting("bill_gateway", $bills);
            ajaxFormDie("Saved", "success");
        }

        if($param1 == "update_setting"){
            this()->load->library("Billpayment");
            $b = new Billpayment();
            $b->set_gateway($param2);

            $config = $b->config();
            foreach($config as $name => $options) {
                if (!is_array($options)) {
                    $name = $options;
                }
                $b->set_mysetting($name, $this->input->post($name));
            }

            ajaxFormDie("Saved Successfully", "success");
        }
    }

    function page($param1 = "", $param2 = "", $param3 = ""){
        rAccess("manage_page");

        if($param1 == "update"){
            $id = $this->input->post("id");
            $data['title'] = trim($this->input->post("title"));
            $data['content'] = $this->input->post("content");

            if(empty($data['title']))
                ajaxFormDie("Please provide a title");

            if(is_empty($data['content'])){
                ajaxFormDie("Please fill the page content");
            }

            $data['date'] = time();

            if(empty($id)){
                c()->insert("page", $data);
                $id = c()->insert_id();
                $msg = "Successfully Created";
            }else{
                c()->where("id", $id);
                c()->update("page", $data);
                $msg = "Successfully Updated";
            }

            ajaxFormDie($msg, "success", array("id"=>$id));
        }

        if($param1 == "disabled"){
            d()->where("id", $param2);
            c()->update("page", array("disabled"=>!empty($param3)?0:1));
            if(empty($param3)){
                ajaxFormDie("Disabled Successfully");
            }else{
                ajaxFormDie("Enabled Successfully", "success");
            }
        }

        if($param1 == "delete"){
            d()->where("id", $param2);
            c()->delete("page");
            ajaxFormDie("Delete Successful", "success");
        }



        $page_data['page_name'] = 'setting/page';
        $page_data['page_title'] = "Create/Update Pages";
        $this->load->view('backend/index', $page_data);
    }



}
