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

class Report extends CI_Controller
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

    public function view(){
        rAccess("view_cashflow");

        $page_data['selected'] = false;
        if(isset($_POST['date1'])) {
            $page_data['selected'] = true;

            $date1 = parse_date($this->input->post("date1"));
            $date2 = parse_date($this->input->post("date2"));
            $search = $this->input->post("search");
            $searchDate = !empty($date1) && !empty($date2) ? true : false;

                $incomeCategories = empty($this->input->post("income")) ? array() : $this->input->post("income");
                $expenseCategories = empty($this->input->post("expense")) ? array() : $this->input->post("expense");

                $category = get_arrange_id_name("income_expense_categories", "id", "name");


                //DATABASE INCOME USING FUND WALLET
                $income = array();
                $expense = array();

                if ($searchDate) {
                    d()->where("date >=", strtotime($date1));
                    d()->where("date <=", strtotime($date2));
                }

                if (!empty($incomeCategories)) {
                    d()->where_in("payment_method", $incomeCategories);
                }else{
                    d()->where("payment_method", null);
                }

                if(!empty($search)){
                    d()->group_start();
                    d()->like("network", $search);
                    d()->or_like("type", $search);
                    d()->group_end();
                }
                d()->where("bill_type", "fund_wallet");
                d()->where("status", "completed");
//                d()->where("amount_credited >", 0);
                d()->group_by("payment_method");
                d()->select_sum("amount_credited", "amount");
                d()->order_by("payment_method", "ASC");
                d()->select("payment_method");
                $array = c()->get("bill_history")->result_array();

                foreach ($array as $row) {
                    $value['name'] = ucwords($row['payment_method']);
                    $value['amount'] = $row['amount'];
                    if(strtolower($value['name']) == "wallet"){
                        $value['name'] = "Recharge Wallet";
                        $value['amount'] = $value['amount']  * -1;
                        $expense[] = $value;
                    }else
                    $income[] = $value;
                }

                //INCOME FROM MANAGE INCOME CATEGORIES
                $selected = array();
                foreach ($incomeCategories as $cat) {
                    if (is_numeric($cat)) {
                        $selected[] = $cat;
                    }
                }
                if (!empty($selected)) {
                    d()->where_in("category_id", $selected);
                }else{
                    d()->where("category_id", 0);
                }
                d()->group_by("category_id");
                d()->where("type", 1);
                if ($searchDate) {
                    d()->where("date >=", strtotime($date1));
                    d()->where("date <=", strtotime($date2));
                }
                d()->select("category_id");
                d()->select_sum("amount");
                $array = c()->get("income_expense")->result_array();

                foreach ($array as $row) {
                    $value['name'] = getIndex($category, $row['category_id']);
                    $value['amount'] = $row['amount'];
                    $income[] = $value;
                }

                //END OF INCOME COMPUTATION

                //DATABASE EXPENSE USING SMS, AIRTIME, DATABUNDLE AND BILL
                if ($searchDate) {
                    d()->where("date >=", strtotime($date1));
                    d()->where("date <=", strtotime($date2));
                }


                if (!empty($expenseCategories)) {
                    d()->where_in("bill_type", $expenseCategories);
                }else{
                    d()->where("bill_type", null);
                }

                if(!empty($search)){
                    d()->group_start();
                    d()->like("network", $search);
                    d()->or_like("type", $search);
                    d()->group_end();
                }
                d()->where_in("status", array("order_completed","completed"));
                d()->group_by("bill_type");
                d()->order_by("bill_type", "ASC");
                d()->select("bill_type");
                d()->select_sum("amount", "amount");
                d()->select_sum("profit", "profit");
                $array = c()->get("bill_history")->result_array();

                foreach ($array as $row) {
                    $value['name'] = ucwords($row['bill_type']);
                    $value['amount'] = $row['amount'];
                    $value['profit'] = $row['profit'];
                    $expense[] = $value;
                }

                //EXPENSE FROM MANAGE EXPENSES CATEGORIES
                $selected = array();
                foreach ($expenseCategories as $cat) {
                    if (is_numeric($cat)) {
                        $selected[] = $cat;
                    }
                }
                if (!empty($selected)) {
                    d()->where_in("category_id", $selected);
                }else{
                    d()->where("category_id", 0);
                }
                d()->group_by("category_id");
                d()->where("type", 2);
                if ($searchDate) {
                    d()->where("date >=", strtotime($date1));
                    d()->where("date <=", strtotime($date2));
                }
                d()->select("category_id");
                d()->select_sum("amount");
                $array = c()->get("income_expense")->result_array();

                $value = array();
                foreach ($array as $row) {
                    $value['name'] = getIndex($category, $row['category_id']);
                    $value['amount'] = $row['amount'];
                    $expense[] = $value;
                }


        }

        $page_data['search'] = empty($search)?"":$search;
        $page_data['date1'] = empty($date1)?"1-".date("M-Y")." 12:00 AM":$date1;
        $page_data['date2'] = empty($date2)?date("d-M-Y")." 11:59 PM":$date2;
        $page_data['income'] = empty($income)?array():$income;
        $page_data['expense'] = empty($expense)?array():$expense;
        $page_data['incomeCategories'] = empty($incomeCategories)?array():$incomeCategories;
        $page_data['expenseCategories'] = empty($expenseCategories)?array():$expenseCategories;

        $page_data['page_name'] = 'report/view';
        $page_data['page_title'] = "Cash Flow";
        $this->load->view('backend/index', $page_data);
    }


    public function report($type = "", $param1 = "", $param2 = "", $search = "", $category_id = ""){

        if($type == "income"){
            rAccess("manage_income");
        }else{
            rAccess("manage_expenses");
        }


        if($param1 == "select") {
            $search = uri_encode($this->input->post("keyword"));
            $date1 = parse_date($this->input->post("date1"));
            $date2 = parse_date($this->input->post("date2"));
            $category_id = $this->input->post("category_id");

            return return_function("report" . construct_url($type, $date1, $date2, $search, $category_id));
        }

        if($param1 == "delete"){
            d()->where("type",$type == "income"?1:2);
            d()->where("id", $param2);
            c()->delete("income_expense");
        }


        $count = 0;
        $search = empty($search)?"":utf8_decode(uri_decode($search));
        $date1 = $param1;
        $date2 = $param2;

        while(true) {

            if (!empty($date1)) {
                d()->where("date>=", strtotime($date1));
                d()->where("date<=", strtotime($date2));
            }

            d()->where("type", $type == "income"?1:2);

            if(!empty($category_id)){
                d()->where("category_id", $category_id);
            }

            if(!is_empty($search)){
               d()->like("name", $search);
            }

            if($count == 0){
//                datatable_order("option=sent.date,recipient=phone,date=sent.date", "sent.date:desc","#,username");
                d()->order_by("date", "DESC");
                d()->limit(empty(g("length"))?datatable_limit():g("length"));
                d()->offset(empty(g("start"))?0:g("start"));
                $page_data['report'] = d()->get("income_expense")->result_array();
            }elseif($count == 1) {
//                if(empty($date1)){
//                    d()->where("date>=", strtotime(date("d-m-Y")." 00:00:01"));
//                    d()->where("date<=", strtotime(date("d-m-Y")." 23:59:59"));
//                }
                d()->select_sum("amount");
                $page_data['total_cost'] = d()->get("income_expense")->row_array()['amount'];
            }else{
                $page_data['history_count'] = d()->count_all_results("income_expense");
                break;
            }
            $count++;
        }

        $page_data['date1'] = empty($date1)?"":$date1;
        $page_data['date2'] = empty($date2)?"":$date2;
        $page_data['keyword'] = $search;
        $page_data['type'] = $type;
        $page_data['category_id'] = $category_id;
        $page_data['page_name'] = 'report/report';
        $page_data['page_title'] = $type == "income"?"Manage Income":"Manage Expenses";
        $this->load->view('backend/index', $page_data);
    }


    public function update($type = "", $param1 = ""){
        if($type == "income"){
            rAccess("manage_income");
        }else{
            rAccess("manage_expenses");
        }

        $data['name'] = $this->input->post("name");
        $data['amount'] = parse_amount($this->input->post("amount"));
        $data['category_id'] = $this->input->post("category_id");
        $data['date'] = strtotime($this->input->post("date"));
        $data['updated_time'] = time();


        if(empty($data['name'])){
            ajaxFormDie("Name can not be empty");
        }

        if(empty($data['amount'])){
            ajaxFormDie("Please enter a valid amount");
        }

        if(empty($param1)){
            $data['type'] = $type == "income"?1:2;
            c()->insert("income_expense", $data);
            $msg = "Created Successfully";
        }else{
            d()->where("id", $param1);
            c()->update("income_expense", $data);
            $msg = "Updated Successfully";
        }

        return_function("report/$type", $msg);
    }



    public function manage_categories($type = "income", $param1 = "", $param2 = "", $param3 = ""){

        if($type == "income"){
            rAccess("manage_income_categories");
        }else{
            rAccess("manage_expense_categories");
        }

        if($param1 == "update"){
            $data['name'] = $this->input->post("name");
            $data['description'] = $this->input->post("description");
            $data['updated_time'] = time();

            if(empty($data['name'])){
                ajaxFormDie("Name can not be empty");
            }
            if(empty($param2)){
                $data['type'] = $type == "income"?1:2;
                c()->insert("income_expense_categories", $data);
                $msg = "Successfully Created";
            }else{
                d()->where("id", $param2);
                c()->update("income_expense_categories", $data);
                $msg = "Successfully Updated";
            }

            return return_function("manage_categories".construct_url($type), $msg);
        }


        if($param1 == "delete"){
            d()->where("id", $param2);
            c()->delete("income_expense_categories");
            ajaxFormDie("Successfully Deleted", "success");
        }

        $page_data['name'] = "";
        $page_data['description'] = "";
        $page_data['id'] = "";
        $page_data['type'] = $type;
        if($param1 == "edit"){
            d()->where("id", $param2);
            $row = c()->get("income_expense_categories")->row_array();
            if(empty($row))
                ajaxFormDie("Invalid ID");

            $page_data['name'] = $row['name'];
            $page_data['description'] = $row['description'];
            $page_data['id'] = $row['id'];
        }

        d()->order_by("name", "ASC");
        d()->where("type", $type == "income"?1:2);
        $page_data['categories'] = c()->get("income_expense_categories")->result_array();

        $page_data['page_name'] = 'report/categories';
        $page_data['page_title'] = $type == "income"?"Manage Income Categories":"Manage Expense Categories";
        $this->load->view('backend/index', $page_data);

    }




}
