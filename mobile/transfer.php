<?php

if(isset($_GET["transfer"])){

    $host = $_SERVER['HTTP_HOST'];
    $link = "http://$host/api/transfer";

    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $post = $_POST;
    $post['username'] = $_SERVER['HTTP_USERNAME'];
    $post['password'] = $_SERVER['HTTP_PASSWORD'];
    $post['amount'] = $_SERVER['HTTP_AMOUNT'];
    $post['to'] = $_SERVER['HTTP_TO'];

        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );


    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if(curl_error($ch)) {
        $response = curl_error($ch);
    }
    curl_close($ch);
    print $response;

}


?>