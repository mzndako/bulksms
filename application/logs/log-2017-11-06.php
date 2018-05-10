<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-11-06 06:38:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\bulksms\server\application\helpers\mysms_helper.php 347
ERROR - 2017-11-06 06:44:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\bulksms\server\application\helpers\mysms_helper.php 347
ERROR - 2017-11-06 06:44:57 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\bulksms\server\application\helpers\mysms_helper.php 347
ERROR - 2017-11-06 06:57:08 --> Query error: Unknown column 'price' in 'field list' - Invalid query: UPDATE `gateway` SET `name` = 'Me', `send_api` = 'http://www.quicksms1.com/api/sendsms.php?username=mzdnako&password=password&message=@@message@@&send', `success_word` = 'OK', `balance_api` = '', `method` = 'GET', `unicode_api` = 'this is unicode', `flash_api` = '', `delivery_api` = '', `batch` = 0, `route` = '', `price` = ''
WHERE `id` = '2'
AND `owner` = '1'
ERROR - 2017-11-06 06:57:19 --> Query error: Unknown column 'price' in 'field list' - Invalid query: UPDATE `gateway` SET `name` = 'Me', `send_api` = 'http://www.quicksms1.com/api/sendsms.php?username=mzdnako&password=password&message=@@message@@&send', `success_word` = 'OK', `balance_api` = '', `method` = 'GET', `unicode_api` = 'this is unicode', `flash_api` = '', `delivery_api` = '', `batch` = 0, `route` = '', `price` = ''
WHERE `id` = '2'
AND `owner` = '1'
ERROR - 2017-11-06 07:22:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `id` = '1' LIMIT 1' at line 2 - Invalid query: UPDATE `users` SET balance = balance - 1.5 = 
WHERE `id` = '1' LIMIT 1
ERROR - 2017-11-06 08:14:07 --> Query error: Unknown column 'route' in 'field list' - Invalid query: INSERT INTO `recipient` (`cost`, `msg_id`, `owner`, `route`, `sent_id`, `status`, `user_id`) VALUES (1.5,'','1',0,'1',-1,'1')
ERROR - 2017-11-06 11:23:57 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF) xdebug://debug-eval 1
ERROR - 2017-11-06 11:27:39 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF) xdebug://debug-eval 1
ERROR - 2017-11-06 11:32:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `id` = '1' LIMIT 1' at line 2 - Invalid query: UPDATE `users` SET balance = balance + 
WHERE `id` = '1' LIMIT 1
ERROR - 2017-11-06 11:37:20 --> Severity: Notice --> Undefined property: CI_DB_pdo_mysql_driver::$user_id Unknown 0
ERROR - 2017-11-06 11:37:20 --> Severity: Warning --> Cannot modify header information - headers already sent C:\xampp\htdocs\bulksms\server\system\core\Common.php 578
ERROR - 2017-11-06 11:37:20 --> Severity: Error --> Call to undefined method CI_DB_pdo_mysql_driver::cost() Unknown 0
