<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-02-22 23:04:38 --> Query error: Column 'owner' in where clause is ambiguous - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
AND `owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC
 LIMIT 25
ERROR - 2018-02-22 23:04:54 --> Query error: Column 'owner' in where clause is ambiguous - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
AND `owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC
 LIMIT 25
ERROR - 2018-02-22 23:10:00 --> Query error: Unknown column 'recipient.sent' in 'order clause' - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC, `recipient`.`sent` ASC
 LIMIT 25, 25
ERROR - 2018-02-22 23:10:38 --> Query error: Unknown column 'recipient.sent' in 'order clause' - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC, `recipient`.`sent` ASC
 LIMIT 50, 25
ERROR - 2018-02-22 23:12:58 --> Query error: Unknown column 'recipient.date' in 'order clause' - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC, `recipient`.`date` ASC
 LIMIT 75, 25
ERROR - 2018-02-22 23:19:29 --> Query error: Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `date` >= 1516659480
AND `date` <= 1519337880
AND `recipient`.`user_id` = '1'
AND   (
`phone` LIKE '%’á†%' ESCAPE '!'
OR  `message` LIKE '%’á†%' ESCAPE '!'
OR  `sender_id` LIKE '%’á†%' ESCAPE '!'
OR  `sender_id_dnd` LIKE '%’á†%' ESCAPE '!'
 )
AND `recipient`.`owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC, `sent`.`date` DESC
 LIMIT 25
ERROR - 2018-02-22 23:20:33 --> Query error: Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT `sent_id`, `user_id`, `sender_id`, `sender_id_dnd`, `message`, `date`, `method`, group_concat(concat(phone)) as numbers, sum(cost) as totalcost
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `date` >= 1516659480
AND `date` <= 1519337880
AND `recipient`.`user_id` = '1'
AND   (
`phone` LIKE '%Â’Ã¡Â†%' ESCAPE '!'
OR  `message` LIKE '%Â’Ã¡Â†%' ESCAPE '!'
OR  `sender_id` LIKE '%Â’Ã¡Â†%' ESCAPE '!'
OR  `sender_id_dnd` LIKE '%Â’Ã¡Â†%' ESCAPE '!'
 )
AND `recipient`.`owner` = '1'
GROUP BY `sent_id`
ORDER BY `date` DESC, `sent`.`date` DESC
 LIMIT 25
ERROR - 2018-02-22 23:53:24 --> Query error: Not unique table/alias: 'recipient' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`user_id` = '1'
AND `recipient`.`owner` = '1'
AND `date` >= 1519254000
AND `date` <= 1519340399
AND `recipient`.`user_id` = '1'
AND `recipient`.`owner` = '1'
GROUP BY `sent_id`, `sent_id`
) CI_count_all_results
ERROR - 2018-02-22 23:53:37 --> Query error: Duplicate column name 'id' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
) CI_count_all_results
ERROR - 2018-02-22 23:53:47 --> Query error: Duplicate column name 'id' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `sent`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
GROUP BY `sent_id`
) CI_count_all_results
ERROR - 2018-02-22 23:56:22 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\bulksms\server\application\views\backend\templates\message\history.php 93
ERROR - 2018-02-22 23:57:46 --> Query error: Not unique table/alias: 'recipient' - Invalid query: SELECT SUM(`cost`) AS `cost`
FROM `recipient`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
AND `date` >= 1519254000
AND `date` <= 1519340399
GROUP BY `sent_id`
ERROR - 2018-02-22 23:57:49 --> Query error: Not unique table/alias: 'recipient' - Invalid query: SELECT SUM(`cost`) AS `cost`
FROM `recipient`
JOIN `recipient` ON `recipient`.`sent_id` = `sent`.`id`
WHERE `recipient`.`owner` = '1'
AND `date` >= 1519254000
AND `date` <= 1519340399
GROUP BY `sent_id`
ERROR - 2018-02-22 23:58:24 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\bulksms\server\application\views\backend\templates\message\history.php 93
ERROR - 2018-02-22 23:59:31 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\bulksms\server\application\views\backend\templates\message\history.php 93
ERROR - 2018-02-22 23:59:53 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\bulksms\server\application\views\backend\templates\message\history.php 93
ERROR - 2018-02-22 23:59:57 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\bulksms\server\application\views\backend\templates\message\history.php 93
