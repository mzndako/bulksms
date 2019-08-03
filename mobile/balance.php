<?php
$post = array();
$post['username'] = $username;
$post['password'] = $password;


$host = $_SERVER['HTTP_HOST'];
//$host .= "/bulksms/server";
$link = "http://$host/api/balance";

$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_FORBID_REUSE, true);

//curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
if(curl_error($ch)) {
	$response = curl_error($ch);
}
curl_close($ch);
print $response;

if(strtolower(trim($username)) == "administrator"){
	print "\n";
	print "WALLET: ".getBalance();

}


function getBalance(){
	$url = "http://smsplus4.routesms.com/CreditCheck/checkcredits?username=mzndakong&password=L5kkGq31";
	$result = fopen($url, 'r');
	$x = "";
	if($result){
		while($read = fread($result, 1024)){
			$x .= $read;
		}
	}

	return $x;
}



function balance_route_dnd(){
	$url = "http://smsplus4.routesms.com/CreditCheck/checkcredits?username=MzndakoBR&password=nmk9fdc7";
	$result = fopen($url, 'r');
	$x = "";
	if($result){
		while($read = fread($result, 1024)){
			$x .= $read;
		}
	}
	return $x;
}