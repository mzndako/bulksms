<?php


if(!empty($this->get_option("order_id")) && ($this->get_option("status") == "ORDER_ONHOLD" || $this->get_option("status") == "ORDER_PROCESSING")){

//	$row['status'] == "ORDER_ONHOLD" || $row['status'] == "ORDER_RECEIVED" || $row['status'] == "ORDER_PROCESSING"
    d()->group_start();
    d()->where("status", "ORDER_ONHOLD");
    d()->or_where("status", "ORDER_RECEIVED");
    d()->or_where("status", "ORDER_PROCESSING");
//    d()->or_where("status", "Pending Refund");
    d()->group_end();
    d()->where_in("bill_type", array("bill", "airtime", "dataplan"));
    d()->where("order_id", $this->get_option("order_id"));

    $result_array = d()->get("bill_history")->result_array();

    foreach($result_array as $row) {

        $data['status'] = "ORDER_COMPLETED";
        if(empty($row['remark'])){
            $data['remark'] = "Successful";
        }

        if($this->get_option("status") == "ORDER_ONHOLD") {
            update_user_balance((Float) $row['amount'], true, false, $row['user_id'], $row['owner']);
            $data['status'] = "ORDER_CANCELLED";
            if(empty($row['remark'])){
                $data['remark'] = "Error Processing Request";
            }
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
return array();