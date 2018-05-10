<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */
include_once __DIR__."/functions.php";

$client_id = $this->get_mysetting("client_id");
$apikey = $this->get_mysetting("apikey");
$domain = "domain";
$num = $this->get_option("number");
$type = $this->get_option("type");
$data_plan = $this->get_option("data_plan");
$bill_plan = $this->get_option("bill_plan");
$bill_type = $this->get_option("bill_type");
$amount = $this->get_option("amount");

if($type == "airtime"){
	$x = "https://www.nellobytesystems.com/APIBuyAirTime.asp?UserID=$client_id&APIKey=$apikey&MobileNetwork=@@network@@&Amount=$amount&MobileNumber=".$this->get_option("number")."&CallBackURL=$domain";
}

if($type == "dataplan"){
	$x = "https://www.nellobytesystems.com/APIBuy.asp?UserID=$client_id&APIKey=$apikey&MobileNetwork=@@network@@&DataPlan=$data_plan&MobileNumber=".$this->get_option("number")."&CallBackURL=$domain";
}

if($type == "bill"){
	$x = "https://www.nellobytesystems.com/APIBuyCableTV.asp?UserID=$client_id&APIKey=$apikey&CableTV=".bill_code($bill_type)."&Package=$bill_plan&SmartCardNo=".$this->get_option("number")."&CallBackURL=$domain";
}

$network = empty($this->get_option("network"))?network($num):$this->get_option("network");
$link = str_replace("@@network@@", network_code($network), $x);
$sendURL = $link;

$ch = curl_init($sendURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
if(curl_error($ch)) {
	$response = curl_error($ch);
}
curl_close($ch);

$array = json_decode($response, true);

return $array;