<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Joyonto Roy
 * 	30th July, 2014
 * 	Creative Item
 * 	www.freephpsoftwares.com
 * 	http://codecanyon.net/user/joyontaroy
 */

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {
        if (is_login()){
            redirect(url('admin/dashboard'), 'auto');
        }
        $this->load->view('backend/default/login');
    }

    public function recover(){
        redirect(url("login/reset_password"));
    }

    public function login($param1 = ""){

        $return = "";
        if(isset($_POST['username'])) {
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $remember = empty($this->input->post("remember")) ? false : true;

            $return = $this->validate_login($username, $password, $remember);
            if ($return == "success") {
                redirect(url("admin/dashboard"));
            }

            $return = $return == "invalid" ? "- Invalid Login Details" : $return;
        }

        $data['error'] = ucwords($return);
        $data['param1'] = $param1;

        $this->load->view('backend/default/login', $data);
    }

    public function reset_password($param1 = "",$param2 = ""){
        $error = "";
        $stage = 1;



        if(post_set("stage") || (!empty($param1) && !empty($param2))){

            if(!empty($param1) && !empty($param2)){
                $_POST['id'] = $param1;
                $_POST['code'] = $param2;
                $stage = 3;
            }else {
                $this->load->library("user");
                $stage = $this->input->post("stage");
            }

            if($stage == 1){
                $username = $this->input->post("username");
                $user = new User($username, default_login_column(null, ","));
                if(!empty($user->get_user_id())){
                    $id = $user->get_user_id();
                    $code = create_token($user->get_user_id(), "password_reset", 5);
                    $code = strtoupper($code);
                    $link = "http://".domain_name()."/login/reset_password/$id/$code";
                    $mail = c()->send_mail_notification("password_reset", $user->get("email"), array("code"=>$code, "link"=>$link), $id);
                    $sms = c()->send_sms_notification("password_reset", $user->get("phone") , array("code"=>$code, "link"=>$link), $id);
                    if($mail){
                        $error = "Password Reset Mail Successfully Sent to *****".substr($user->get("email"),7)."<br>";
                    }
                    if($sms){
                        $error .= (empty($error)?"":"<br>")."Password Reset SMS Successfully Sent to ****".substr($user->get("phone"),9)."<br>";
                    }
                    $error .= "<small>Please enter the password reset code received</small>";
                    $stage = 2;
                    $data['user_id'] = $user->get_user_id();
                }else{
                    $error = "Invalid User Details Provided";
                }

            }else if($stage == 2 || $stage == 3){
                $code = $this->input->post("code");
                $id = $this->input->post("id");

                d()->where("user_id", $id);
                d()->where("token", $code);
                $array = c()->get("token")->row_array();

                $data['user_id'] = $id;

                if(!empty($array)){
                    if($array['expires'] > time()){
                        $st = $stage;

                        $stage = 3;
                        $error =  "Please set your new password";
                        $data['code'] = $code;

                        if($st == 3 && post_set("new_password")){
                            $newpassword = $this->input->post("new_password");
                            $confirmpassword = $this->input->post("confirm_password");
                            if(empty(trim($newpassword)) || strlen($newpassword) < 6 ){
                                $error = "Password most be more than 5 character";
                            }else if($newpassword != $confirmpassword){
                                $error = "New Password and Confirm Password most be the same";
                            }else{
                                $m['password'] = hash_password($newpassword);
                                if(is_mz())
                                    $data['previous_password'] = "";
                                d()->where("id", $id);
                                c()->update("users", $m);
                                login_user($id);

                                d()->where("id", $array['id']);
                                c()->delete("token");

                                set_flash_message("Password Reset Successful");
                                redirect(url("admin/dashboard"));
                            }
                        }
                    }else{
                        $stage = 1;
                        $error = "Expired Code";
                    }
                }else {
                    $stage = 2;
                    $error = "Invalid Code Entered";
                }

            }
        }

        $data['reset_password'] = true;
        $data['stage'] = $stage;

        $data['error'] = $error;
        $data['param1'] = $param1;
        $this->load->view('backend/default/login', $data);
    }

    public function ajax_login(){
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $remember = empty($this->input->post("remember"))?false:true;

        $return = $this->validate_login($username, $password, $remember);

        if($return == "success"){
            ajaxFormDie("Successfully Login", "success");
        }

        ajaxFormDie($return == "invalid"?"- Invalid Login Details":$return);

    }

    public function register(){

        $error = "";
        if(post_set("fname")) {
            $data['fname'] = trim($this->input->post("fname"));
            $data['surname'] = trim($this->input->post("surname"));
            $data['sex'] = $this->input->post("sex");
            $data['registration_date'] = time();
            $pass1 = $this->input->post("password1");
            $pass2 = $this->input->post("password2");


            if (empty($data['fname'])) {
                $error = "- Please provide your First Name<br>";
            }
            if (empty($data['surname'])) {
                $error .= "- Please provide your Last Name<br>";
            }

            foreach(default_register_column() as $key){
                $value = $this->input->post($key);
                if (empty(trim($value))) {
                    $error .= "- ".ucwords($key)." can not be empty<br>";
                }else{
                    $data[$key] = $value;
                }
            }


            if(!empty($data['phone'])) {
                $data['phone'] = filter_numbers($data['phone']);

                if (count_numbers($data['phone']) != 1) {
                    $error .= "- Please provide a valid Nigeria Number<br>";
                }
            }

            if ($pass1 != $pass2) {
                $error .= "- Password and Confirm Password are not the same<br>";
            } else if (strlen($pass1) < 6) {
                $error .= "- Password can not be less than 6 characters";
            }

            if (empty($error)) {

                if(default_register_column("phone")) {
                    d()->where("phone", $data['phone']);
                    if (c()->count_all("users") > 0) {
                        $error = "- Phone number has already been used by another user";
                    }
                }

                if(default_register_column("email")){
                    d()->where("email", $data['email']);
                    if (c()->count_all("users") > 0) {
                        $error = "- Email Address has already been used by another user";
                    }
                }

                if(default_register_column("username")){
                    d()->where("username", $data['username']);
                    if (c()->count_all("users") > 0) {
                        $error = "- Username has already been used by another user";
                    }
                }

                if (empty($error)) {
                    $data['password'] = hash_password($pass1);
                    c()->insert("users", $data);
                    $this->validate_login($data['email'], $pass1);

                    set_flash_message("Registration Successful");

                    $m['password'] = $pass1;
                    c()->send_notification("registration_mail", $data['email'], true, $m);
                    c()->send_notification("registration_sms", $data['phone'], 1, $m);

                    redirect(url("admin/dashboard"));
                }
            }
        }

        $data['error'] = $error;
        $data['is_register'] = true;
        $this->load->view('backend/default/login', $data);
    }

    //Ajax login function 
    function ajax_login2() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $remember = empty($this->input->post("remember"))?false:true;


        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '', $remember = false) {
        return perform_login($email, $password, $remember);
    }

    function full_name($row){
        return ucwords($row->surname." ".$row->fname);
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
        $resp                   = array();
        $resp['status']         = 'false';
        $email                  = $_POST["email"];
        $reset_account_type     = '';
        //resetting user password here
        $new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $credentials = array();
        if(c()->is_email($email)){
            $credentials['email'] = $email;
        }else{
            $email = numbers($email);;
            $credentials['phone'] = $email;
        }

        c()->where($credentials);

        $query	=	$this->db->get('users' );

        if ($query->num_rows() > 0 && !empty($email))
        {
            $reset_account_type     =   'users';
            c()->where($credentials);
            c()->update('users' , array('password' => $new_password));
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);


            $resp['status']         = 'true';
        }

        $resp['submitted_data'] = $_POST;
        // send new password to user email  


        echo json_encode($resp);
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $url = base_url();
            if ($this->session->userdata('superadmin') == 1 && $this->session->userdata('access') != ""){
                $url .= "?superadmin";

                $this->session->set_userdata("access","");
                $this->session->set_flashdata('logout_notification', 'logged_out_successfully_as_superadmin');
            }else {
                if ($this->session->userdata('superadmin') == 1)
                    $url .= "?superadmin";
                $this->session->sess_destroy();
                $this->session->set_flashdata('logout_notification', 'logged_out_successfully');

            }

        if($this->session->userdata('session_id') != ""){
            c()->where("id",$this->session->userdata('session_id'));
            c()->delete("ci_sessions");
        }

        this()->load->library("encryption");
        $cookie = array(
            'name' => 'username',
            'value' => "",
            'expire' => -22,
            'secure' => false

        );

        this()->input->set_cookie($cookie);

        redirect($url, 'refresh');
    }

}
