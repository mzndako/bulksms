<?php
//include 'send1.php';


//errorhandler();

function getValue($value){
        if(isset($_GET[$value]))
            return $_GET[$value];
        return "";
 }

 function getValue2($value){
     //$value = strtoupper($value);
     //$value = "$value";

        if(isset($_GET[$value]))
            return $_GET[$value];
        return "";
 }
 
if(isset($_GET["balance"])){
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $username = urldecode(getValue("username"));
        $password = urldecode(getValue("password"));
     }else {
        $username = $_SERVER['HTTP_USERNAME'];
        $password = $_SERVER['HTTP_PASSWORD'];}



    include "balance.php";

        
}else if($_SERVER['REQUEST_METHOD'] == 'POST' | $_SERVER['REQUEST_METHOD']=='GET'){
    $ok = 0;
    $random = rand(100000, 3000000);
    $convert = "false";
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $username = urldecode(getValue2("username"));
        $password = urldecode(getValue2("password"));
        $recipient = urldecode(getValue2("recipient"));
        $message = urldecode(getValue2("message"));
        $schedule = urldecode(getValue2("schedule"));
        $sender = urldecode(getValue2("sender"));
        $others = urldecode(getValue2("others"));
        $version = urldecode(getValue2("version"));

        $message = str_replace("%0A", "\n", $message);
//        print "OK ". $schedule;
    }else if(isset($_POST['HTTP_USERNAME'])) {
        $username = $_POST['HTTP_USERNAME'];
        $password = $_POST['HTTP_PASSWORD'];
        $sender = $_POST['HTTP_SENDER'];
        $message = $_POST['HTTP_MESSAGE'];
        $recipient = $_POST['HTTP_RECIPIENT'];
        $schedule = isset($_POST['HTTP_SCHEDULE'])?$_POST['HTTP_SCHEDULE']:"";
        $others = isset($_POST['HTTP_OTHERS'])?$_POST['HTTP_OTHERS']:"";
        $err = "";
        $sch = false;
        if ( get_magic_quotes_gpc() ) {
            $message = stripslashes($_POST['HTTP_MESSAGE']);
            $sender = stripslashes($_POST['HTTP_SENDER']);
            $username = stripslashes($username);
            $password = stripslashes($password);
        }
        $message = str_replace("%0A", "\n", $message);
    }else{
            $username = $_SERVER['HTTP_USERNAME'];
            $password = $_SERVER['HTTP_PASSWORD'];
            $sender = $_SERVER['HTTP_SENDER'];
            $message = $_SERVER['HTTP_MESSAGE'];
            $recipient = $_SERVER['HTTP_RECIPIENT'];
            $schedule = isset($_SERVER['HTTP_SCHEDULE'])?$_SERVER['HTTP_SCHEDULE']:"";
            $others = isset($_SERVER['HTTP_OTHERS'])?$_SERVER['HTTP_OTHERS']:"";
            $err = "";
            $sch = false;
            if ( get_magic_quotes_gpc() ) {
                $message = stripslashes($_SERVER['HTTP_MESSAGE']);
                $sender = stripslashes($_SERVER['HTTP_SENDER']);
                $username = stripslashes($username);
                $password = stripslashes($password);
            }
            $message = str_replace("%0A", "\n", $message);

    }

    include "send.php";

    exit;

  
}
