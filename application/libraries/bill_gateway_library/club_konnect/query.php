<?php
include_once __DIR__."/functions.php";

$client_id = $this->get_mysetting("client_id");
$apikey = $this->get_mysetting("apikey");
$domain = "domain";

$link = "https://www.nellobytesystems.com/APIQuery.asp?UserID=$client_id&APIKey={$apikey}&OrderID=".$this->get_option("order_id");;
$ch = curl_init($link);
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

if(!empty($array) && !empty($this->get_option("order_id"))){
	$data['status'] = getIndex($array, "status");
	$data['status_code'] = getIndex($array, "status_code");
	$data['remark'] = getIndex($array, "remark");

//	$row['status'] == "ORDER_ONHOLD" || $row['status'] == "ORDER_RECEIVED" || $row['status'] == "ORDER_PROCESSING"
	d()->group_start();
	d()->where("status", "ORDER_ONHOLD");
	d()->or_where("status", "ORDER_RECEIVED");
	d()->or_where("status", "ORDER_PROCESSING");
	d()->or_where("status", "Pending Refund");
	d()->group_end();
	d()->where_in("bill_type", array("bill", "airtime", "dataplan"));
	d()->where("order_id", $this->get_option("order_id"));

	$result_array = d()->get("bill_history")->result_array();

	foreach($result_array as $row) {
		if ($data['status'] == "ORDER_CANCELLED") {
			$data['remark'] .= "<br><span style='color: red'>Refunded</span>";
			update_user_balance((Float) $row['amount'], true, false, $row['user_id'], $row['owner']);

			$m['owner'] = $row['owner'];
			$m['user_id'] = $row['user_id'];
			$m['type'] = "Account Refund";
			$m['bill_type'] = "others";
//			$m['amount'] = $row['amount'];
			$m['amount_credited'] = $row['amount'];
			$m['balance'] = user_balance($row['user_id']);
			$m['remark'] = "Refund Successful";
			insert_history($m);
		}

		d()->where("id", $row['id']);
		d()->update("bill_history", $data);
	}
}
return $array;