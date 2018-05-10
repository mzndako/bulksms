<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */


function network_code($network){
	switch($network){
		case "mtn": return "01";
		case "glo": return "02";
		case "9mobile": return "03";
		case "airtel": return "04";
	}
	return "";
}

function bill_code($bill_type){
	switch($bill_type){
		case "dstv": return "01";
		case "gotv": return "02";
		case "startimes": return "03";
	}
	return "";
}