<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Class Cart
 * @property Billpayment_model $billpayment_model Cart module
 */
class Billpayment_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }

    function bill_payment_rate(){
        $airtime = string2array("mtn,9mobile,airtel,glo");
        $dataplan = string2array("mtn=500=N300|1000=N550|1500.01=N950|2000=N1100|3500.01=N1900.00|5000=N2750|10000.01=N4750|22000.01=N9500,".
            "glo=1600.01=N950.00|3750.01=N1850.00|5000.01=N2250.00|6000.01=N2700.00|8000.01=N3600.00|12000.01=N4500.00|16000.01=N7200.00|30000.01=N13500.00|45000.01=N16200.00,".
            "9mobile=250=N250.00|500=N350.00|500.01=N475.00|1000=N650.00|1000.01=N950.00|2000=N1300.00|1500.01=N1140.00|2500.01=N1900.00|3000=N1950.00|3500.01=N2375.00|4000=N2600.00|5000=N3250.00|5000.01=N3325.00|6000=N3900.00|7000=N4550.00|8000=N5200.00|9000=N5850.00|10000=N6500.00|11500.01=N7600.00|15000.01=N9500.00|27000.01=N17100.00,".
            "airtel=1500.01=N950.00|3500.01=N1900.00|7000.01=N3325.00|10000.01=N4750.00|16000.01=N7600.00|22000.01=N9500.00");
        $bill['dstv'] = string2array("01=name=DStv Access|amount=N1900,02=name=DStv Family|amount=3800,03=name=DStv Compact|amount=6300,04=name=DStv Compact Plus|amount=9900,05=name=DStv Premium|amount=14700,06=name=DStv Premium + HD/Exra View|amount=16900");
        $bill["gotv"] = string2array("02=name=GOtv Value|amount=1250,03=name=GOtv Plus|amount=1900");
        $bill['startimes'] = string2array("01=name=SarTimes Nova|amount=900,02=name=SarTimes Basic|amount=1300,03=name=SarTimes Smart|amount=1900,04=name=SarTimes Classic|amount=2600,05=name=SarTimes Unique|amount=3800");
        return array("airtime"=>$airtime, "dataplan"=>$dataplan, "bill"=>$bill);
    }

    function convert_to_mb($data){
        $x = (int) $data;
        if($x < 1000)
            return $x." MB";
        return round($x / 1000, 1)." GB";
    }

    function errors($status, $code = "", $remark = ""){
        switch($status){
            case "ORDER_RECEIVED": $x = "Processing"; break;
            case "ORDER_ERROR": $x = "Error $code"; break;
            case "ORDER_COMPLETED":
                $x = $code != 201?"Completed":"Completed but no response from server yet"; break;
            case "ORDER_ONHOLD": $x = "Order On Hold ($code)"; break;
            case "ORDER_CANCELLED": $x = "Order Cancelled ($code)"; break;
            case "INVALID_CREDENTIALS": $x = "Invalid Gateway Configuration"; break;
            case "INSUFFICIENT_BALANCE": $x = "Invalid Gateway Account Limit"; break;
        }
        if(empty($x))
        $x = ucwords(strtolower(str_replace("_", " ", $status)));
        $x = "<b>$x</b>";
        if(!empty($remark)){
            $x = $x."<br><i>$remark</i>";
        }
        return $x;
    }

}
