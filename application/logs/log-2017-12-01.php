<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-01 00:35:22 --> Severity: Notice --> Undefined variable: id C:\xampp\htdocs\bulksms\server\application\controllers\Wallet.php 75
ERROR - 2017-12-01 00:35:51 --> Severity: Error --> Class 'payment_voguepay' not found C:\xampp\htdocs\bulksms\server\application\controllers\Wallet.php 89
ERROR - 2017-12-01 00:41:18 --> Severity: Warning --> file_get_contents(https://voguepay.com/?v_transaction_id=1111&amp;type=json&amp;demo=true ): failed to open stream: A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\atm\voguepay.php 151
ERROR - 2017-12-01 01:05:53 --> Severity: Error --> Class 'payment_bitcoin' not found C:\xampp\htdocs\bulksms\server\application\views\backend\templates\wallet\fund.php 61
ERROR - 2017-12-01 01:36:02 --> Severity: Compile Error --> Cannot redeclare class payment_paystack C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 175
ERROR - 2017-12-01 01:36:11 --> Severity: Compile Error --> Cannot redeclare class payment_paystack C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 175
ERROR - 2017-12-01 12:17:04 --> Severity: Warning --> file_get_contents(): SSL: The operation completed successfully.
 C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 89
ERROR - 2017-12-01 12:17:04 --> Severity: Warning --> file_get_contents(): Failed to enable crypto C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 89
ERROR - 2017-12-01 12:17:04 --> Severity: Warning --> file_get_contents(https://api.blockchain.info/v2/receive?key=c1bdfd4a-4fe5-4acc-8c80-bc6f27986da4&amp;xpub=xpub6CJUfm8fAK58mCiRy6meHiYG9tMyhGw6MDVNQTaGtvEHmkCX954R3KKwqc5uhTQc9Diq7ChXWMCX7JMwcrMZo7TuKzkjd3YbNgqUXG1JxJB&amp;callback=http%3A%2F%2Flocalhost%2Fwallet%2Fnotify%2Fcrytocurrency%2Fbitcoin&amp;gap_limit=11): failed to open stream: operation failed C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 89
ERROR - 2017-12-01 12:20:22 --> Severity: Warning --> file_get_contents(https://api.blockchain.info/v2/receive?key=c1bdfd4a-4fe5-4acc-8c80-bc6f27986da4&amp;xpub=xpub6CJUfm8fAK58mCiRy6meHiYG9tMyhGw6MDVNQTaGtvEHmkCX954R3KKwqc5uhTQc9Diq7ChXWMCX7JMwcrMZo7TuKzkjd3YbNgqUXG1JxJB&amp;callback=http%3A%2F%2Flocalhost%2Fwallet%2Fnotify%2Fcrytocurrency%2Fbitcoin&amp;gap_limit=11): failed to open stream: HTTP request failed! HTTP/1.1 400 Bad Request
 C:\xampp\htdocs\bulksms\server\application\libraries\payment_methods\bitcoin\bitcoin.php 89
