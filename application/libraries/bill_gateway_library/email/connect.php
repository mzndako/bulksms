<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */
include_once __DIR__."/functions.php";

$to_email = $this->get_mysetting("email");

$num = $this->get_option("number");
$type = $this->get_option("type");
$data_plan = $this->get_option("data_plan");
$bill_plan = $this->get_option("bill_plan");
$bill_type = $this->get_option("bill_type");
$amount = $this->get_option("amount");

if($type == "airtime"){
	$x = "<b>Mobile Network</b> = @@network@@<br><b>Amount</b> = $amount<br><b>Mobile Phone Number</b> = ".$this->get_option("number");
}

if($type == "dataplan"){
	$x = "<b>Mobile Network</b> = @@network@@<br><b>DataPlan</b> = $data_plan<br><b>Mobile Number</b> = ".$this->get_option("number");
}

if($type == "bill"){
	$x = "<b>CableTV</b> = ".bill_code($bill_type)."<br><b>Package</b> = $bill_plan<br><b>Smart Card No</b> = ".$this->get_option("number");
}

$network = empty($this->get_option("network"))?network($num):$this->get_option("network");
$link = str_replace("@@network@@", ucwords($network), $x);
$mail = "<h2>".ucwords($type)." Request</h2><br> $link";

$send_mail = array("html"=>$mail, "subject"=>ucwords($type)." Request", "to"=>$to_email);



return array("status"=>"ORDER_RECEIVED", "send_mail"=>$send_mail);
