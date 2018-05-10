<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-09-21 12:14:29 --> Query error: Table 'bulksms.document' doesn't exist - Invalid query: SELECT *
FROM `document`
WHERE `document_type` = ''
AND `document_type_id` = -1
ERROR - 2017-09-21 12:35:52 --> Query error: Table 'bulksms.document' doesn't exist - Invalid query: SELECT *
FROM `document`
WHERE `document_type` = ''
AND `document_type_id` = -1
ERROR - 2017-09-21 11:50:50 --> Query error: Unknown column 'deleted' in 'where clause' - Invalid query: SELECT *
FROM `users`
WHERE `password` = 'admin'
AND `email` = 'admin@admin.com'
AND `deleted` =0
