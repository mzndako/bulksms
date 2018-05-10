<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-19 13:48:50 --> Severity: Error --> Class 'User' not found C:\xampp\htdocs\bulksms\server\application\controllers\Login.php 69
ERROR - 2017-12-19 13:53:50 --> Severity: Notice --> Undefined variable: user_id C:\xampp\htdocs\bulksms\server\application\views\backend\default\login.php 245
ERROR - 2017-12-19 13:56:12 --> Severity: Notice --> Undefined variable: user_id C:\xampp\htdocs\bulksms\server\application\views\backend\default\login.php 245
ERROR - 2017-12-19 13:59:35 --> Severity: Notice --> Undefined variable: code C:\xampp\htdocs\bulksms\server\application\views\backend\default\login.php 259
ERROR - 2017-12-19 14:03:15 --> Query error: Unknown column 'user_id' in 'field list' - Invalid query: UPDATE `users` SET `user_id` = '7', `code` = '5zpxW', `password` = '$2y$10$57bzE6nXeePo1GVZgG2t1ud3EMLkMXHxrC61GQzaxtqN4YN.2OcNK', `previous_password` = ''
WHERE `id` = '7'
AND `owner` = '1'
