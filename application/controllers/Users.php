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

class Users extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library('user');
	}


	function view($param1 = "", $regdate1 = "", $regdate2 = "", $llogin1 = "", $llogin2 = "", $search = ""){
		rAccess("view_user");



		$all_users = array();
		if($param1 == "search") {
			if(post_set("activate_reg")){
				if(empty($this->input->post("reg_date1")) || empty($this->input->post("reg_date2")))
					ajaxFormDie("Please specify the search start and end date for registration");

				$regdate1 = parse_date($this->input->post("reg_date1"));
				$regdate2 = parse_date($this->input->post("reg_date2"));
			}

			if(post_set("activate_lastlogin")){
				if(empty($this->input->post("lastlogin_date1")) || empty($this->input->post("lastlogin_date2")))
					ajaxFormDie("Please specify the search start and end date for Last Login");

				$llogin1 = parse_date($this->input->post("lastlogin_date1"));
				$llogin2 = parse_date($this->input->post("lastlogin_date2"));
			}

			$type = $this->input->post("type");
			$search = uri_encode($this->input->post("search"));
			return return_function("view".construct_url($type, $regdate1, $regdate2, $llogin1, $llogin2, $search));
		}

		$count = 0;

		$search = trim(uri_decode($search));
		while(true) {

			if (!empty($regdate1) && !empty($regdate2)) {
				d()->where("registration_date >=", date2strtotime($regdate1));
				d()->where("registration_date <=", date2strtotime($regdate2));
			}

			if (!empty($llogin1) && !empty($llogin2)) {
				d()->where("last_login >=", date2strtotime($llogin1));
				d()->where("last_login <=", date2strtotime($llogin2));
			}

			if (!empty($param1)) {
				if($param1 == "admin" || $param1 == "member")
					d()->where("is_admin", $param1 == "admin" ? 1 : 0);
				if($param1 == "disabled")
					d()->where("disabled != ", 0);
			}

			if (!empty($search)) {
				$word = utf8_encode($search);
				d()->group_start();
				d()->like("fname", $word);
				d()->or_like("surname", $word);
				d()->or_like("username", $word);
				$filter = filter_numbers($word);
				if (count_numbers($filter) == 1) {
					d()->or_like("phone", $filter);
				}
				d()->or_like("phone", $word);
				d()->or_like("email", $word);
				d()->group_end();
			}

			if($count == 0){
				datatable_order("#=registration_date,names=fname,option=registration_date,p. balance=previous_balance,total credited=total_units,reg date=registration_date,last_login", "registration_date:desc","type");
				datatable_limit_set(10);
				datatable_offset_set();
				$page_data['all_users'] = c()->get("users")->result_array();
			}else{
				$page_data['all_users_count']= c()->count_all("users");
				break;
			}
			$count++;
		}
		$ms = array();
		$ms['lastlogin_date1'] = $llogin1;
		$ms['lastlogin_date2'] = $llogin2;
		$ms['reg_date1'] = $regdate1;
		$ms['reg_date2'] = $regdate2;
		$ms['search'] = $search;

		$page_data['mysearch'] = $ms;
		$page_data['page_name'] = 'users/view';
		$page_data['page_title'] = "Manage Users";
		$this->load->view('backend/index', $page_data);
	}

	function update(){
		rAccess("view_user");

			$data['fname'] = $this->input->post("fname");
			$data['surname'] = $this->input->post("surname");
			$data['username'] = $this->input->post("username");
			$data['sex'] = $this->input->post("sex");
			$data['phone'] = filter_numbers($this->input->post("phone"));
			$data['email'] = $this->input->post("email");
			$data['is_admin'] = empty($this->input->post("is_admin"))?0:1;
			$password = $this->input->post("password");
			$data['route'] = $this->input->post("route");
			$data['disabled'] = $this->input->post("disabled") == 0?0:time();
			$data['disabled_text'] = $this->input->post("disabled_text");

			if(!empty($password))
				$data['password'] = hash_password($password);

			if(empty($data['fname']))
				ajaxFormDie("First Name can not be empty");

			if(empty($data['email']) && empty($data['phone']))
				ajaxFormDie("Email and Phone number can not both be empty");

			if(count_numbers($data['phone']) != 1)
				ajaxFormDie("Invalid Phone number entered");

			if(empty($this->input->post("id"))){
				$data['registration_date'] = time();
				$id = 0;
				$msg = "Created Successfully";
			}else{
				$id = $this->input->post("id");
				$msg = "Updated Successfully";
			}

			if($this->input->post("price") == "-1"){
				if(empty($this->input->post("pricebox")))
					ajaxFormDie("The custom price can not be empty");
				$data['rate'] = $this->input->post("pricebox");
			}else{
				$data['rate'] = $this->input->post("price");
			}

			if($this->input->post("pricednd") == "-1"){
				if(empty($this->input->post("priceboxdnd")))
					ajaxFormDie("The custom dnd price can not be empty");
				$data['dnd_rate'] = $this->input->post("priceboxdnd");
			}else{
				$data['dnd_rate'] = $this->input->post("pricednd");
			}

			$data['gateway'] = $this->input->post("gateway");

			$user = new User($id);
			$user->set_fields($data);
			$user->compulsory_fields("name=fname,label=First Name");

			foreach(default_register_column() as $col){
				$user->compulsory_fields($col);
				$user->no_duplicate_fields($col);
			}

			$validate = $user->validate();

			if(!empty($validate)){
				ajaxFormDie($validate[0]);
			}

			$id = $user->update_user();

			ajaxFormDie($msg, "success", array("id"=>$id));
	}

	function credit_user($param1 = ""){
		rAccess("credit_user");

		if($param1 == "proceed"){
			$rec = $this->input->post("receiver");

			if(empty($rec))
				ajaxFormDie("Valid Receiver Details Needed");

			$this->load->library("user");
			$user = new User($rec, implode(",", default_login_column()));

			if($user->user_count > 1)
				ajaxFormDie("Duplicate Users with this detail exist. Please Use another details");

			if(empty($user->get_user_id())){
				ajaxFormDie("Invalid User Details");
			}

			ajaxFormDie("", "success", array("user_id"=>$user->get_user_id()));

		}
		$page_data['page_name'] = 'users/credit_user';
		$page_data['page_title'] = "Credit User Account";
		$this->load->view('backend/index', $page_data);
	}



	function role($param1 = "", $param2 = "")
	{
		rAccess("manage_role");

		if ($param1 == 'update') {
			$data['name'] = $this->input->post("name");
			$id = $this->input->post("id");
			$menu = new MenuBuilder();
			$access = array();
			foreach ($menu->get_menu(true) as $row) {
				if (!empty($this->input->post($row['id']))) {
					$access[] = $this->input->post($row['id']);
				}
			}

			if (empty($data['name'])) {
				ajaxFormDie("Name can not be empty");
			}

			$data['access'] = empty($access) ? "" : implode(",", $access);

			if (empty($id)) {
				c()->insert("role", $data);
			} else {
				c()->where("id", $id);
				c()->update("role", $data);
			}

			return return_function("role", "Successful");
		}

		if ($param1 == 'delete') {
			c()->where("role_id", $param2);
			c()->delete("role");
			return return_function("role", "Successfully Deleted");
		}

		if ($param1 == 'member_permission') {
			$menu = new MenuBuilder();
			$member = array();
			foreach ($menu->get_menu(true) as $row) {
				if($row['for_members'] != 1)
					continue;
				if (!empty($this->input->post("member_" . $row['id']))) {
					$member[] = $this->input->post("member_" . $row['id']);
				}

			}

			c()->save_setting("member_permission", empty($member) ? "" : implode(",", $member));

			ajaxFormDie("Saved", "success");

		}

		$page_data['id'] = '';
		if ($param1 == 'edit') {
			$page_data['id'] = $param2;
		}

		$page_data['page_name'] = 'users/role';
		$page_data['page_title'] = 'Manage Role';
		$this->load->view('backend/index', $page_data);
	}

	function options($param1 = "", $param2 = ""){
		this()->load->library("PaymentMethods");
		$pg = new PaymentMethods();
		$pg->load_classes();

		$page_data['pg'] = $pg;
		$page_data['page_name'] = 'users/view';

		if($param1 == "update_balance"){
			$type = $this->input->post("action");
			$amount = parse_amount($this->input->post("amount"));
			$tf = parse_amount($this->input->post("tf"));
			$method = !empty($this->input->post("method"))?$this->input->post("method"):"bank";

			if($amount == 0){
				ajaxFormDie("Please specify a valid amount");
			}

			$data['user_id'] = $param2;
			$data['bill_type'] = "fund_wallet";
			$data['type'] = "Fund Wallet";
			$data['recipient'] = "Account Credited";
			$data['amount'] = $amount;



			if($type == "credit"){
				rAccess("credit_user");

				$on_credit = false;
				if($method == "debt"){
				    rAccess("allow_on_credit");
				    $on_credit = true;
                }
				if($method == "airtime"){
					$y = "payment_airtime";
					if(class_exists($y)) {
						$x = new $y();
						$trans = $x->process_transaction_fee($amount);
						$tf = $trans['transaction_fee'];
					}
				}

				$amt_credited = $amount - $tf;

				if($amt_credited <= 0)
					ajaxFormDie("Invalid Amount");

				$p_balance = user_balance($param2);

				if(!hAccess("manage_admin_credit") && !$on_credit){
					if(is_admin($param2)){
						ajaxFormDie("You don't have permission to credit an Admin");
					}
					if(user_balance() < $amt_credited)
						ajaxFormDie("Insufficient Balance");

					update_user_balance($amt_credited,false,false,login_id());
					$data_ = $data;
					$data_['user_id'] = login_id();
					$data_['recipient'] = "Transfer to ".c()->get_full_name($param2);
					$data_['amount'] = "$amt_credited";
					$data_['amount_credited'] = "-$amt_credited";
					$data_['bill_type'] = "fund_admin";
					$data_['type'] = "Fund User Wallet";
					$data_['balance'] = user_balance();

					insert_history($data_);
				}

				update_user_balance($amt_credited,true,true,$param2);

				if($on_credit){
                    d()->set("debt", "debt + $amt_credited", false);
                    d()->where("id", $param2);
                    c()->update("users");
                    $data['recipient'] = "On Credit";

                }
				$data['payment_method'] = $method;

				if(is_admin($param2)){
					$data['bill_type'] = "fund_admin";
					$data['type'] = "Fund Admin Wallet";
					$data['payment_method'] = "wallet";;
				}
				$data['transaction_fee'] = $tf;
				$data['amount_credited'] = $amt_credited;
				$data['balance'] = user_balance($param2);
				insert_history($data);

				$m = $data;
				$m['p_balance'] = format_wallet($p_balance, -1);
				$m['transaction_fee'] = format_wallet($tf, -1);
				$m['balance'] = format_wallet($m['balance'], -1);
				$m['amount_credited'] = format_wallet($m['amount_credited'], -1);
				$m['amount'] = format_wallet($m['amount'], -1);

				if(!empty($this->input->post("send_mail"))) {
					c()->send_notification("fund_wallet_mail", user_data("email", $param2), true, $m, false, $param2);
				}

				if(!empty($this->input->post("send_sms")))
					c()->send_notification("fund_wallet_sms", user_data("phone", $param2), 1, $m, false, $param2);

				set_flash_message("User Account Successfully Credited");
			}else{
				rAccess("debit_user");

				update_user_balance($amount,false,true,$param2);
				$data['amount_credited'] = "-$amount";
				$data['balance'] = user_balance($param2);
				$data['recipient'] = "Account Debited";
				insert_history($data);

				set_flash_message("User Account Successfully Debited");
			}

			$page_data['page_name'] = 'users/update_balance_modal';
			$page_data['param1'] = $param2;

		}

		if($param1 == "update_privilege"){
			rAccess("change_staff_privilege");
			$is_administrator = empty($is_administrator)?0:1;

			if($is_administrator == 1){
				$data['access'] = -1;
			}else{
				$access = parse_number($this->input->post("privilege"));

				if(empty($access) || $access < 1){
					$access = 0;
				}
				$data['access'] = $access;
			}
			d()->where("id", $param2);
			c()->update("users", $data);

			ajaxFormDie("User Privilege Successfully Updated");
		}

		if($param1 == "delete_user"){
			rAccess("delete_user");

			$tables = d()->list_tables();
			foreach($tables as $tb){
				$fields = d()->list_fields($tb);
				foreach($fields as $f){
					if ($f == 'user_id') {
						d()->where("user_id", $param2);
						c()->delete($tb);
					}
				}
			}

			d()->where("id", $param2);
			c()->delete("users");

			ajaxFormDie("Successfully Deleted", "success");
		}

		$page_data['page_title'] = 'Manage User';
		$this->load->view('backend/index', $page_data);
	}


	function profile($param1 = ""){
		rAccess("update_profile");

		if($param1 == "update"){
			$user = new User(login_id());

			if(isset($_POST['update'])) {
				$data['fname'] = $this->input->post("fname");
				$data['surname'] = $this->input->post("surname");
				$data['sender_id'] = $this->input->post("sender_id");
				$data['email'] = $this->input->post("email");
				$data['phone'] = $this->input->post("phone");


				$user->set_fields($data);
				$user->compulsory_fields("name=fname,label=First Name");

				foreach (default_register_column() as $col) {
					if($col == "username")
						continue;

					$user->compulsory_fields($col);
					$user->no_duplicate_fields($col);
				}
				$validate = $user->validate();
				if(!empty($validate)){
					ajaxFormDie($validate[0]);
				}
				$user->update_user();
				ajaxFormDie("Saved Successfully", "success");
			}else{
				$password = $this->input->post("current_password");
				$new_password = $this->input->post("new_password1");
				if(!password_verify($password, user_data("password"))){

					if(empty(user_data("last_password")) || user_data("last_password") != previous_password_hash($password)) {

						ajaxFormDie("Current Password is Incorrect");
					}
				}

				if(strlen($new_password) < 5){
					ajaxFormDie("New Password Most not be less than 5 letters");
				}

				if($new_password != $this->input->post("new_password2")){
					ajaxFormDie("New Password and Confirm Password Must be the same");
				}

				d()->where("id", login_id());
				c()->update("users", array("password"=>hash_password($new_password)));

				set_flash_message("Password Change Successful");
				return return_function("profile");
			}

		}

		if($param1 == "upload_profile"){
			$x = c()->move_image("profile", "profile", login_id(), false, false, "", 1024 * 2, ".jpg, .png, .gif, .jpeg");
			if($x !== true){
				ajaxFormDie($x);
			}
			ajaxFormDie("Profile Picture Successfully Updated", "success");
		}

		$page_data['page_name'] = 'users/profile';
		$page_data['page_title'] = "User Profile";
		$this->load->view('backend/index', $page_data);
	}



}
