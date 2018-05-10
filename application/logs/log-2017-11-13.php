<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-11-13 02:30:48 --> Query error: Unknown column 'user_id' in 'where clause' - Invalid query: UPDATE `users` SET `access` = 2
WHERE `user_id` = '2'
AND `owner` = '1'
ERROR - 2017-11-13 02:31:05 --> Query error: Unknown column 'user_id' in 'where clause' - Invalid query: UPDATE `users` SET `access` = 0
WHERE `user_id` = '2'
AND `owner` = '1'
ERROR - 2017-11-13 02:51:05 --> Query error: Duplicate column name 'last_login2' - Invalid query: ALTER TABLE users ADD last_login2 INT DEFAULT 0 NOT NULL after last_login;
ERROR - 2017-11-13 02:51:05 --> Query error: Duplicate column name 'last_ip' - Invalid query: ALTER TABLE users ADD last_ip VARCHAR(20) DEFAULT "" NOT NULL after last_login2;
ERROR - 2017-11-13 02:51:05 --> Query error: Duplicate column name 'last_ip2' - Invalid query: ALTER TABLE users ADD last_ip2 VARCHAR(20) DEFAULT "" NOT NULL after last_ip;
ERROR - 2017-11-13 02:51:05 --> Query error: Duplicate column name 'route' - Invalid query: ALTER TABLE recipient ADD route TINYINT DEFAULT 0 NOT NULL after cost;
ERROR - 2017-11-13 02:51:05 --> Query error: Unknown column 'is_staff' in 'users' - Invalid query: ALTER TABLE users CHANGE is_staff is_admin TINYINT DEFAULT 0;
ERROR - 2017-11-13 02:51:05 --> Query error: Can't DROP 'settings_id'; check that column/key exists - Invalid query: ALTER TABLE settings DROP settings_id;
ERROR - 2017-11-13 02:51:05 --> Query error: Table 'draft' already exists - Invalid query: CREATE TABLE draft(  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,  owner INT DEFAULT 0 NOT NULL,  user_id INT DEFAULT 0 NOT NULL,  sender VARCHAR(15) DEFAULT "" NOT NULL,  message TEXT NOT NULL,  recipient TEXT NOT NULL,  date INT DEFAULT 0 NOT NULL);
