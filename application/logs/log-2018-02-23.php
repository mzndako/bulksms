<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-02-23 00:00:47 --> Query error: Table 'bulksms.sentd' doesn't exist - Invalid query: SELECT SUM(`cost`) AS `cost`
FROM `sentd`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
ERROR - 2018-02-23 00:01:16 --> Query error: Table 'bulksms.sentd' doesn't exist - Invalid query: SELECT SUM(`cost`) AS `cost`
FROM `sentd`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
