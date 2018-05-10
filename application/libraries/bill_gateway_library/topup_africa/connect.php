<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */

if(!empty($this->get_mysetting("token")) && $this->get_mysetting("expired") > time())
	goto stage2;

$sendURL = "https://pos.ipst.ae:8453/User.asmx/Login";
$post = array("deviceDescription"=> "SOFTWARE VERSION : 78\nOS VERSION : 3.18.22\nOS API LEVEL : 23\nIMEI SLOT 1 : 489746543178297\nIMEI SLOT 2 : 356185083503862\nNETWORK OPERATOR MCC+MNC : 62130\nNETWORK OPERATOR NAME : MTN - NG\nSIM OPERATOR MCC+MNC : 62130\nSIM OPERATOR NAME : MTN - NG\nSUBSCRIBER ID (IMSI) : 621300102889532\nMANUFACTURER : GIONEE\nDEVICE : GiONEE_BBL7515A\nPRODUCT : GN8003\nMODEL : GN8003\nDISPLAY : amigo3.5.1\n",
    "login"=> $this->get_mysetting("username"),
    "password"=> $this->get_mysetting("password"));
$post['login'] = "07034634717";
$post['password'] = "ndazhitsu";
$ch = curl_init($sendURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
$payload = json_encode($post);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
if(curl_error($ch)) {
	$response = curl_error($ch);
}
curl_close($ch);
$array = json_decode($response, true);
$result = getIndex($array, "d", array());

if(getIndex($result, "descr") != "OK")
	return $this->mybill->failed("Invalid Gateway Account Details");

$this->set_mysetting("token", $result['authGuid']);
$this->set_mysetting("user_id", $result['userGuid']);
$this->set_mysetting("expired", $result['Expired']);

stage2:
$token = $this->get_mysetting("token");
$user_id = $this->get_mysetting("user_id");


