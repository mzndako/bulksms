<?php
/*******************************************************************************
 *                      PHP Paypal IPN Integration Class
 *******************************************************************************
 *      Author:     Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    http://www.micahcarrick.com
 *
 *      File:       paypal.class.php
 *      Version:    1.3.0
 *      Copyright:  (c) 2005 - Micah Carrick 
 *                  You are free to use, distribute, and modify this software 
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *      
 *******************************************************************************
 *  VERION HISTORY:
 *      v1.3.0 [10.10.2005] - Fixed it so that single quotes are handled the 
 *                            right way rather than simple stripping them.  This
 *                            was needed because the user could still put in
 *                            quotes.
 *  
 *      v1.2.1 [06.05.2005] - Fixed typo from previous fix :)
 *
 *      v1.2.0 [05.31.2005] - Added the optional ability to remove all quotes
 *                            from the paypal posts.  The IPN will come back
 *                            invalid sometimes when quotes are used in certian
 *                            fields.
 *
 *      v1.1.0 [05.15.2005] - Revised the form output in the submit_paypal_post
 *                            method to allow non-javascript capable browsers
 *                            to provide a means of manual form submission.
 *
 *      v1.0.0 [04.16.2005] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      NOTE: See www.micahcarrick.com for the most recent version of this class
 *            along with any applicable sample files and other documentaion.
 *
 *      This file provides a neat and simple method to interface with paypal and
 *      The paypal Instant Payment Notification (IPN) interface.  This file is
 *      NOT intended to make the paypal integration "plug 'n' play". It still
 *      requires the developer (that should be you) to understand the paypal
 *      process and know the variables you want/need to pass to paypal to
 *      achieve what you want.  
 *
 *      This class handles the submission of an order to paypal aswell as the
 *      processing an Instant Payment Notification.
 *  
 *      This code is based on that of the php-toolkit from paypal.  I've taken
 *      the basic principals and put it in to a class so that it is a little
 *      easier--at least for me--to use.  The php-toolkit can be downloaded from
 *      http://sourceforge.net/projects/paypal.
 *      
 *      To submit an order to paypal, have your order form POST to a file with:
 *
 *          $p = new Paypal;
 *          $p->add_field('business', 'somebody@domain.com');
 *          $p->add_field('first_name', $_POST['first_name']);
 *          ... (add all your fields in the same manor)
 *          $p->submit_paypal_post();
 *
 *      To process an IPN, have your IPN processing file contain:
 *
 *          $p = new Paypal;
 *          if ($p->validate_ipn()) {
 *          ... (IPN is verified.  Details are in the ipn_data() array)
 *          }
 *
 *
 *      In case you are new to paypal, here is some information to help you:
 *
 *      1. Download and read the Merchant User Manual and Integration Guide from
 *         http://www.paypal.com/en_US/pdf/integration_guide.pdf.  This gives 
 *         you all the information you need including the fields you can pass to
 *         paypal (using add_field() with this class) aswell as all the fields
 *         that are returned in an IPN post (stored in the ipn_data() array in
 *         this class).  It also diagrams the entire transaction process.
 *
 *      2. Create a "sandbox" account for a buyer and a seller.  This is just
 *         a test account(s) that allow you to test your site from both the 
 *         seller and buyer perspective.  The instructions for this is available
 *         at https://developer.paypal.com/ as well as a great forum where you
 *         can ask all your paypal integration questions.  Make sure you follow
 *         all the directions in setting up a sandbox test environment, including
 *         the addition of fake bank accounts and credit cards.
 * 
 *******************************************************************************
*/

class User {
    
	var $register = array();
	var $fields = array();
	var $compulsory_fields = array();
	var $no_duplicate_fields = array();
	public $allow_empty_duplicate = false;
	var $user_id = 0;
	var $user = array();
	var $invalid_password = "Invalid Email or Password";
	var $invalid_user = "Email or Phone number does not exist";
	var $token_expires = 60 * 60 * 24;
	var $token = "";
	public $user_count = 0;

	function User($user=0, $columns="id") {
		if(!empty($user))
			$this->set_user($user, $columns);
	}

	function set_user($user, $columns='id'){
		if(empty($user))
			return 0;

		$count = 0;
		d()->group_start();
		foreach(string2array($columns) as $col){
			$u = $user;
			if(compareString($col,"phone")){
				$u = filter_numbers($user);
				if(empty($u))
					continue;
			}
			if($count == 0) {
				d()->where($col, $u);
			}else {
				d()->or_where($col, $u);
			}
			$count++;
		}
		d()->group_end();

		$row = c()->get("users");
		if($row->num_rows() == 1){
			$array = $row->row_array();
			$this->user = $array;
			$this->user_id = $array['id'];
			return 1;
		}

		$this->user_count = $row->num_rows();

		return $row->num_rows();
	}

	function get_user_id(){
		return $this->user_id;
	}

	function get_user(){
		return $this->user;
	}

	function get($field){
		return getIndex($this->user, $field);
	}

	function set_fields($array){
		$this->fields = $array;
	}

	function add_fields($col, $value){
		$this->fields[$col] = $value;
	}

	function compulsory_fields($field1, $field2 = ""){
		$args = func_get_args();
		foreach ($args as $arg) {
			if(strpos($arg, "=") === false)
				$arg = "name=$arg";
			$this->compulsory_fields[] = $arg;
		}
	}

	function no_duplicate_fields($field, $field2 = ""){
		$args = func_get_args();
		foreach ($args as $arg) {
			if(strpos($arg, "=") === false)
				$arg = "name=$arg";
			$this->no_duplicate_fields[] = $arg;
		}
	}

	function validate(){
		$all_error = array();
		$field_name = array();
		foreach($this->compulsory_fields as $fields_){
			$fields = string2array($fields_);
			$col_name = getIndex($fields, "name");
			$col_type = getIndex($fields, "type", "text");
			$label = getIndex($fields, "label", ucwords(str_replace("_"," ",$col_name)));
			$min = getIndex($fields, "min", 0);
			$max = getIndex($fields, "max", 1000);

			$value = getIndex($this->fields, $col_name);
			$value_len = strlen($value);

			if(empty($col_name))
				continue;

			$field_name[$col_name] = $label;
			$error = "";
			if($col_type == "email" && !c()->is_email($value))
				$error = "Invalid $label";

			if($col_type == "number" && !is_numeric($value))
				$error = "$label most be a number";

			if($value_len < $min || $value_len > $max)
				$error = "$label can not be less than $min character or greatherthan $max character";

			if(empty($error) && $col_type == "text" && empty(trim($value)))
				$error = $label. " can not be empty";

			if(!empty($error))
				$all_error[] = $error;
		}

		foreach($this->no_duplicate_fields as $fields){
			$fields = string2array($fields);
			$col_name = getIndex($fields, "name");
			$label = getIndex($fields, "label", getIndex($field_name, $col_name));
			$label = !empty($label)?$label:ucwords(str_replace("_"," ",$col_name));
			$value = getIndex($this->fields, $col_name);

			if(empty($value))
				continue;

			if(!empty($this->user_id)){
				d()->where("id !=", $this->user_id);
			}
			d()->where($col_name, $value);
			$row = c()->get("users");
			if($row->num_rows() > 0){
				$all_error[] = "$label already exists";
			}

		}

		return $all_error;
	}

	function update_user(){
		$data = $this->fields;
		if(!empty($data['password'])){
			$data['password'] = hash_password($data['password']);
		}

		if(!empty($this->user_id)){
			d()->where("id", $this->user_id);
			d()->update("users", $this->fields);
			return $this->user_id;
		}

		c()->insert("users", $data);
		$this->user_id = d()->insert_id();
		return $this->user_id;
	}

	function validate_password($password){
		$return = $this->invalid_password;

		if(empty($this->get_user()) || empty($password))
			return $return;

		if(password_verify($password, getIndex($this->get_user(), "password"))){
			return true;
		}

		return $return;
	}

	function perform_login($password){
		$validated = $this->validate_password($password);
		if($validated === true){
			return login_user($this->get_user_id());
		}

		return $validated;
	}

	function generate_reset_code(){
		if(empty($this->get_user()))
			return $this->invalid_user;

		$this->token = random_string("alnum", 50);

		$data['user_id'] = $this->get_user_id();
		$data['token'] = $this->token;
		$data['expires'] = time() * $this->token_expires;
		$data['date'] = time();
		c()->insert("token", $data);
		return true;
	}

	function get_token(){
		return $this->token;
	}

	function validate_token($token){
		if(empty($this->get_user()))
			return $this->invalid_user;

		d()->where("user_id", $this->get_user_id());
		d()->where("token", $token);
		d()->where("expires >=", time());
		$row = c()->get_where("token", array());

		if($row->num_rows() == 1)
			return true;

		return "Expired or Invalid Reset Link";
	}

	function delete_token($token){
		if(empty($this->get_user()))
			return $this->invalid_user;

		d()->where("user_id", $this->get_user_id());
		d()->where("token", $token);
		c()->delete("token");
		return true;
	}







}         


 
