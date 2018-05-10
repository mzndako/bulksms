<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-03-14 02:01:01 --> Query error: Duplicate entry '1-1' for key 'notification_user' - Invalid query: INSERT INTO `notification_read` (`notification_id`, `user_id`, `owner`) VALUES ('1', '1', '1')
ERROR - 2018-03-14 02:05:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'id not in (select notification_id from notification_read where user_id = 1 and n' at line 1 - Invalid query: select * from notification whered id not in (select notification_id from notification_read where user_id = 1 and n.id = notification_id)
ERROR - 2018-03-14 02:05:39 --> Query error: Unknown column 'n.id' in 'where clause' - Invalid query: select * from notification where id not in (select notification_id from notification_read where user_id = 1 and n.id = notification_id)
