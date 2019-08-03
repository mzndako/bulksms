<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */
include_once __DIR__."/functions.php";

$username = $this->get_mysetting("username");
$apikey = $this->get_mysetting("apikey");
$domain = "domain";
$num = $this->get_option("number");
$type = $this->get_option("type");
$data_plan = $this->get_option("data_plan");
$bill_plan = $this->get_option("bill_plan");
$bill_type = $this->get_option("bill_type");
$amount = $this->get_option("amount");
//$username = "mzndako";
//$apikey = "302d3eb040e5b32637fcfcf30348a6aa09a1d91bbe50046637079e862172cd47";
$gateway = new AfricasTalkingGateway($username, $apikey);

$response = Array("status"=>"ORDER_FAILED");
if($type == "airtime"){
    $recipients = array(
        array("phoneNumber"=>filter_numbers($num), "amount"=>"NGN $amount"),
    );
    $recipientStringFormat = json_encode($recipients);

    try {
        $results = $gateway->sendAirtime($recipientStringFormat);

        foreach($results as $result) {
            $status = $result->status;
            $status = strtolower($status);
            $sent = $status == "sent" || $status == "success"?true:false;
            $response['status'] = $sent?"ORDER_RECEIVED":"ORDER_FAIL";
            $response['orderid'] = $result->requestId;

            //Error message is important when the status is not Success
            $result->errorMessage;
        }
    }
    catch(AfricasTalkingGatewayException $e){
        $response['status'] = "ORDER_FAILED";
    }

    return $response;
}

return $response;