<?php
$config = array(
    "paystack" => array("name" => "Pay Stack <a target='_blank' href='http://paystack.com'>Visit Website</a>", "options" => array("secret_key" => string2array("label=Secret Key"), "public_key" => string2array("label=Public Key"), 'transaction_fee', "method" => array("label" => "Loading Method", "type" => "select", "options" => array("Load on this website", "Direct User to Paystack.com")), "allow_reseller" => array("label" => "Allow Reseller's to use this gateway", "type" => "select", "options" => array("No", "Yes")), "enabled" => array("label" => "Enabled", "type" => "select", "options" => array("enabled", "disabled", "Use Reseller Gateway")))),


    "voguepay" => array("name" => "Vogue Pay <a target='_blank' href='http://voguepay.com'>Visit Website</a>", "options" => array("merchant_id" => string2array("label=Merchant ID"), 'transaction_fee',"allow_reseller" => array("label" => "Allow Reseller's to use this gateway", "type" => "select", "options" => array("No", "Yes")), "enabled" => array("label" => "Enabled", "type" => "select", "options" => array("enabled", "disabled", "Use Reseller Gateway"))))
);