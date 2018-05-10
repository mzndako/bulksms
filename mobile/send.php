<?php

$post = array();
$post['username'] = $username;
$post['password'] = $password;
$post['message'] = $message;
$post['sender'] = $sender;
$post['recipient'] = $recipient;
$post['schedule'] = $schedule;
$post['explain'] = $convert;
$post['device'] = @$others;
$post['route'] = "";

$host = $_SERVER['HTTP_HOST'];
//$host .= "/bulksms/server";
$link = "http://$host/api/bulksms";
$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
if(curl_error($ch)) {
	$response = curl_error($ch);
}

if(!empty($response)) {
	$array = explode("|", $response);
	print $array[0];

	if(!empty($array[1]) && strpos($array[1], "Successfully") === false){
	print " => But We couldn't send sms to some numbers due to DND. Please login to {$host} to send messages using Banking Route. The DND Numbers are: ".$array[1]."";
	}
}

curl_close($ch);
