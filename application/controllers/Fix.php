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

class Fix extends CI_Controller
{

    private $odb;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
//        $this->odb = $this->load->database("smswise", true);
        $this->load->library('session');
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

    }

    public function list_reseller(){
        if(!is_admin() || !is_mz())
            die("Please login as admin");

        $array = d()->get("reseller")->result_array();

        foreach($array as $row){
            d()->where("owner", $row['owner']);
            $domain = d()->get("domain")->result_array();
            $domain = get_arrange_id_name($domain, "id", "domain");
            $domain = @implode(", ", $domain);
            print "owner id = $row[owner]; domain = $domain<br>";
        }

    }

    public function move_db( $owner, $other_table){
        if(empty($owner))
            die("No defined owner");

        if(!is_admin() || !is_mz())
            die("Please login as admin");

        set_time_limit(300);
        print "Started = ".gdate()."<br><br>";
        if($other_table == "information"){
            $array = $this->odb->get("information")->result_array();
            foreach($array as $row){
                d()->where("owner", $owner);
                d()->where("username", $row['username']);
                $myrow = d()->get("users")->row_array();
                if(empty($myrow)){
                    $data['username'] = $row['username'];
                    $data['fname'] = $row['fname'];
                    $data['surname'] = $row['lname'];
                    $data['email'] = $row['email'];
                    $data['last_password'] = $row['password'];
                    $data['previous_balance'] = $row['balance'];
                    $data['phone'] = $row['phone'];
                    $data['state'] = $row['state'];
                    $data['sender_id'] = $row['senderid'];
                    $data['registration_date'] = strtotime(empty($row['reg_date'])?"":$row['reg_date']);
                    $data['owner'] = $owner;
                    d()->insert("users", $data);
                    print "inserted => $row[username]<br>";
                }else{
                    print "Already Exited User = $row[username]<br>";
                }
            }
        }

        if($other_table == "phonebook"){
            //get client 2 phonebook
            $this->odb->order_by("user", "ASC");
            $array = $this->odb->get("phonebook")->result_array();
            foreach($array as $row){
                d()->where("owner", $owner);
                d()->where("username", $row['user']);
                $myrow = d()->get("users")->row_array();
                if(!empty($myrow)){
                    $data['user_id'] = $myrow['id'];
                    $data['name'] = $row['name'];
                    $data['numbers'] = $row['contacts'];
                    $data['date'] = strtolower($row['date']);
                    $data['owner'] = $owner;
                    d()->insert("phonebook", $data);
                    print "inserted => $row[user] ($row[name])<br>";
                }else{
                    print "User doesnt exist = $row[user]<br>";
                }
            }
        }

        if($other_table == "message"){
            //get sent message from client 2
            $this->odb->order_by("user", "ASC");
            $osent = $this->odb->get("sent")->result_array();
            //loop through client 2 message
            foreach($osent as $row){
                //get client 2 user on client 1
                d()->where("owner", $owner);
                d()->where("username", $row['user']);
                $user = d()->get("users")->row_array();

                if(!empty($user)){
                    //insert client 2 messages into client 1
                    $data['owner'] = $owner;
                    $data['sender_id'] = $row['sender_id'];
                    $data['message'] = $row['message'];
                    $data['date'] = strtotime($row['date']);
                    $data['method'] = $row['method'];
                    d()->insert("sent", $data);
                    $msgid = d()->insert_id();


                    //get client 2 recipients
                    $this->odb->where("sentid", $row['id']);
                    $orep = $this->odb->get("recipient")->result_array();
                    //loop through client 2 recipients
                    $batch = array();
                    $c = 0;
                    d()->db_debug = false;

                    foreach($orep as $r){
                        $data2['owner'] = $owner;
                        $data2['sent_id'] = $msgid;
                        $data2['user_id'] = $user['id'];
                        $data2['phone'] = $r['phone'];
                        $data2['msg_id'] = $r['msgid'];
                        $data2['status'] = $r['status'];
                        $data2['cost'] = $r['cost'];
                        $data2['donedate'] = strtotime($r['donedate']);
                        d()->insert("recipient", $data2);
                        $c++;
//                        $batch[] = $data2;
                    }
                    d()->db_debug = true;

//                    if(!empty($batch))
//                        d()->insert_batch("recipient", $batch);

                    print "inserted => $row[user] ($c $row[sender_id])<br>";
                }else{
                    print "User doesnt exist = $row[user]<br>";
                }
            }
        }


        if($other_table == "draft"){
            //get client 2 draft
            $this->odb->order_by("user", "ASC");
            $array = $this->odb->get("draft")->result_array();
            foreach($array as $row){
                d()->where("owner", $owner);
                d()->where("username", $row['user']);
                $myrow = d()->get("users")->row_array();
                if(!empty($myrow)){
                    $data['user_id'] = $myrow['id'];
                    $data['sender'] = $row['sender_id'];
                    $data['message'] = $row['message'];
                    $data['recipient'] = $row['recipients'];
                    $data['date'] = strtolower($row['date']);
                    $data['owner'] = $owner;
                    d()->insert("draft", $data);
                    print "inserted => $row[user] ($row[sender_id])<br>";
                }else{
                    print "User doesnt exist = $row[user]<br>";
                }
            }
        }




        print "<br><br>Ended = ".gdate()."";
    }

    public function delete_all($owner, $table){

    }

    public function list_db($owner,$table){
        d()->where("owner", $owner);
        $return = d()->get($table)->result_array();
        print "count = ".count($return)."<br><Br>";
        print_r($return);
    }
    public function list_odb($table){
        $return = $this->odb->get($table)->result_array();
        print "count = ".count($return)."<br><Br>";
        print_r($return);
    }

    public function fix_number_format(){
        $array = c()->get("users")->result_array();
        $count = 0;
        foreach($array as $row){
            if(empty($row['phone'])){
                continue;
            }

            if(strlen(trim($row['phone'])) != 11 && strlen(trim($row['phone'])) != 10)
                continue;

            $data['phone'] = filter_numbers($row['phone']);
            if(strlen($data['phone']) == 13){
                d()->where("id", $row['id']);
                d()->limit(1);
                d()->update("users", $data);
                $count++;
                print "$row[phone] => $data[phone]<br>";
            }
        }

        print "Change $count numbers;";
    }

}
