<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-01-05 00:51:22 --> Severity: Notice --> Undefined variable: all_user_count C:\xampp\htdocs\bulksms\server\application\views\backend\templates\users\view.php 106
ERROR - 2018-01-05 01:10:31 --> Severity: Notice --> Undefined variable: all_user_count C:\xampp\htdocs\bulksms\server\application\views\backend\templates\users\view.php 106
ERROR - 2018-01-05 01:11:51 --> Query error: Unknown column 'date' in 'order clause' - Invalid query: SELECT *
FROM `users`
WHERE `owner` = '1'
ORDER BY `date` ASC
 LIMIT 10
ERROR - 2018-01-05 01:15:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`credited` ASC
 LIMIT 25' at line 4 - Invalid query: SELECT *
FROM `users`
WHERE `owner` = '1'
ORDER BY `total` `credited` ASC
 LIMIT 25
ERROR - 2018-01-05 01:15:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`credited` DESC
 LIMIT 25' at line 4 - Invalid query: SELECT *
FROM `users`
WHERE `owner` = '1'
ORDER BY `total` `credited` DESC
 LIMIT 25
ERROR - 2018-01-05 01:16:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`login` ASC
 LIMIT 25' at line 4 - Invalid query: SELECT *
FROM `users`
WHERE `owner` = '1'
ORDER BY `last` `login` ASC
 LIMIT 25
ERROR - 2018-01-05 01:26:32 --> Query error: Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `users`
WHERE   (
`fname` LIKE '%›%' ESCAPE '!'
OR  `surname` LIKE '%›%' ESCAPE '!'
OR  `username` LIKE '%›%' ESCAPE '!'
OR  `phone` LIKE '%›%' ESCAPE '!'
OR  `email` LIKE '%›%' ESCAPE '!'
 )
AND `owner` = '1'
ERROR - 2018-01-05 01:26:44 --> Query error: Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `users`
WHERE   (
`fname` LIKE '%›%' ESCAPE '!'
OR  `surname` LIKE '%›%' ESCAPE '!'
OR  `username` LIKE '%›%' ESCAPE '!'
OR  `phone` LIKE '%›%' ESCAPE '!'
OR  `email` LIKE '%›%' ESCAPE '!'
 )
AND `owner` = '1'
ERROR - 2018-01-05 01:27:20 --> Query error: Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `users`
WHERE   (
`fname` LIKE '%›%' ESCAPE '!'
OR  `surname` LIKE '%›%' ESCAPE '!'
OR  `username` LIKE '%›%' ESCAPE '!'
OR  `phone` LIKE '%›%' ESCAPE '!'
OR  `email` LIKE '%›%' ESCAPE '!'
 )
AND `owner` = '1'
ERROR - 2018-01-05 02:29:15 --> Severity: Warning --> fsockopen(): unable to connect to localhost:25 (No connection could be made because the target machine actively refused it.
) C:\xampp\htdocs\bulksms\server\system\libraries\Email.php 2063
ERROR - 2018-01-05 02:32:31 --> Severity: Warning --> fsockopen(): unable to connect to localhost:25 (No connection could be made because the target machine actively refused it.
) C:\xampp\htdocs\bulksms\server\system\libraries\Email.php 2063
ERROR - 2018-01-05 02:33:18 --> Severity: Warning --> fsockopen(): unable to connect to localhost:25 (No connection could be made because the target machine actively refused it.
) C:\xampp\htdocs\bulksms\server\system\libraries\Email.php 2063
ERROR - 2018-01-05 02:35:37 --> Severity: Warning --> fsockopen(): unable to connect to localhost:25 (No connection could be made because the target machine actively refused it.
) C:\xampp\htdocs\bulksms\server\system\libraries\Email.php 2063
ERROR - 2018-01-05 02:37:46 --> Severity: Warning --> fsockopen(): unable to connect to localhost:25 (No connection could be made because the target machine actively refused it.
) C:\xampp\htdocs\bulksms\server\system\libraries\Email.php 2063
