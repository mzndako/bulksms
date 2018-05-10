<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-03-12 00:29:58 --> Severity: Notice --> Undefined index: content C:\xampp\htdocs\bulksms\server\application\views\backend\templates\admin\notification.php 52
ERROR - 2018-03-12 00:29:58 --> Severity: Notice --> Undefined index: disabled C:\xampp\htdocs\bulksms\server\application\views\backend\templates\admin\notification.php 57
ERROR - 2018-03-12 01:10:22 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813422, NULL, '1', '1')
ERROR - 2018-03-12 01:12:14 --> Severity: Notice --> Undefined index: notification.id C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 121
ERROR - 2018-03-12 01:12:14 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813534, NULL, '1', '1')
ERROR - 2018-03-12 01:12:43 --> Severity: Notice --> Undefined index: notification.id C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 121
ERROR - 2018-03-12 01:12:43 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813563, NULL, '1', '1')
ERROR - 2018-03-12 01:13:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*
FROM `notification`
LEFT JOIN `notification_read` ON `notification`.`id` = `no' at line 1 - Invalid query: SELECT `notification`.`id`, *
FROM `notification`
LEFT JOIN `notification_read` ON `notification`.`id` = `notification_read`.`notification_id`
WHERE `notification`.`type` = 1
AND `notification`.`owner` = '1'
AND   (
   (
`notification`.`new_user_can_see` =0
AND `notification`.`date` > '1507494952'
  )
OR    (
`notification`.`new_user_can_see` = 1
  )
 )
AND `location` = 'all'
AND `active` = 1
AND   (
`expires` =0
OR `expires` > 1520813638
 )
AND   (
   (
`show_once` = 1
AND `notification_read`.`user_id` != '1'
  )
OR    (
`show_once` =0
  )
 )
ORDER BY `date` ASC
ERROR - 2018-03-12 01:14:12 --> Severity: Notice --> Undefined index: notification.id C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 121
ERROR - 2018-03-12 01:14:12 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813652, NULL, '1', '1')
ERROR - 2018-03-12 01:14:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*
FROM `notification`
LEFT JOIN `notification_read` ON `notification`.`id` = `no' at line 1 - Invalid query: SELECT `notification`.`id` as `myid`, *
FROM `notification`
LEFT JOIN `notification_read` ON `notification`.`id` = `notification_read`.`notification_id`
WHERE `notification`.`type` = 1
AND `notification`.`owner` = '1'
AND   (
   (
`notification`.`new_user_can_see` =0
AND `notification`.`date` > '1507494952'
  )
OR    (
`notification`.`new_user_can_see` = 1
  )
 )
AND `location` = 'all'
AND `active` = 1
AND   (
`expires` =0
OR `expires` > 1520813671
 )
AND   (
   (
`show_once` = 1
AND `notification_read`.`user_id` != '1'
  )
OR    (
`show_once` =0
  )
 )
ORDER BY `date` ASC
ERROR - 2018-03-12 01:14:41 --> Severity: Notice --> Undefined index: notification.id C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 121
ERROR - 2018-03-12 01:14:41 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813681, NULL, '1', '1')
ERROR - 2018-03-12 01:14:56 --> Severity: Notice --> Undefined index: notification.id C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 121
ERROR - 2018-03-12 01:14:56 --> Query error: Column 'notification_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520813696, NULL, '1', '1')
ERROR - 2018-03-12 02:14:51 --> Severity: Notice --> Undefined variable: notify C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 62
ERROR - 2018-03-12 02:14:51 --> Severity: Notice --> Undefined variable: notify_ C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 63
ERROR - 2018-03-12 02:15:04 --> Severity: Notice --> Undefined variable: notify C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 62
ERROR - 2018-03-12 02:15:04 --> Severity: Notice --> Undefined variable: notify_ C:\xampp\htdocs\bulksms\server\application\views\backend\default\index.php 63
ERROR - 2018-03-12 02:58:46 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520819926, '1', NULL, '1')
ERROR - 2018-03-12 02:58:47 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520819927, '1', NULL, '1')
ERROR - 2018-03-12 02:59:00 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520819940, '1', NULL, '1')
ERROR - 2018-03-12 02:59:01 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520819941, '1', NULL, '1')
ERROR - 2018-03-12 03:01:07 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820067, '1', NULL, '1')
ERROR - 2018-03-12 03:01:08 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820068, '1', NULL, '1')
ERROR - 2018-03-12 03:01:27 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820087, '1', NULL, '1')
ERROR - 2018-03-12 03:01:28 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820088, '1', NULL, '1')
ERROR - 2018-03-12 03:01:35 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820095, '1', NULL, '1')
ERROR - 2018-03-12 03:01:36 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820096, '1', NULL, '1')
ERROR - 2018-03-12 03:01:40 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `notification_read` (`view_date`, `notification_id`, `user_id`, `owner`) VALUES (1520820100, '1', NULL, '1')
ERROR - 2018-03-12 03:22:08 --> Severity: Notice --> Undefined variable: notify_dialog C:\xampp\htdocs\bulksms\server\application\views\frontend\corlate\footer.php 128
ERROR - 2018-03-12 03:22:08 --> Severity: Notice --> Undefined variable: notify_dialog C:\xampp\htdocs\bulksms\server\application\views\frontend\corlate\footer.php 131
ERROR - 2018-03-12 03:22:09 --> Severity: Notice --> Undefined variable: notify_dialog C:\xampp\htdocs\bulksms\server\application\views\frontend\corlate\footer.php 128
ERROR - 2018-03-12 03:22:09 --> Severity: Notice --> Undefined variable: notify_dialog C:\xampp\htdocs\bulksms\server\application\views\frontend\corlate\footer.php 131
