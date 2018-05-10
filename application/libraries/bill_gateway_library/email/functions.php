<?php

function network_code($network){
switch($network){
case "mtn": return "01";
case "glo": return "02";
case "9mobile": return "03";
case "airtel": return "04";
}
return "";
}