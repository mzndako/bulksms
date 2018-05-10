<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
	'class'    => 'postconstructor',
	'function' => 'get_owner',
	'filename' => 'postconstructor.php',
	'filepath' => 'hooks',
	'params'   => array()
);
$hook['pre_controller'] = array(
	'class'    => 'postconstructor',
	'function' => 'session',
	'filename' => 'postconstructor.php',
	'filepath' => 'hooks',
	'params'   => array()
);