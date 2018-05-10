<?php

class postconstructor{
	function get_owner(){
		function exception_error_handler($severity, $message, $file, $line) {
			if (!(error_reporting() & $severity)) {
				// This error code is not included in error_reporting
				return;
			}
			throw new ErrorException($message, 0, $severity, $file, $line);
		}
//		set_error_handler("exception_error_handler");
		check_domain();

		if(!empty($_SERVER['REQUEST_URI'])) {
			$xx = explode('?', $_SERVER['REQUEST_URI'], 2);
			$array = array_pop($xx);
			parse_str($array, $_GET);
		}

		if(empty($_SESSION))
			return;

		reload_permission();

		$expireAfter = getIndex($_SESSION, "session_expires_on", 0);

		if(isset($_SESSION['session_last_update'])){
			$secondsInactive = time() - $_SESSION['session_last_update'];
			$expireAfterSeconds = $expireAfter;
			if($secondsInactive >= $expireAfterSeconds){
				@session_unset();
				@session_destroy();
			}
			$_SESSION['session_last_update'] = time();
		}

	}

	function load_session(){
		if(empty($_SESSION) || empty($_SESSION['login_user_id'])){
			if(empty(this()->input->cookie("username"))){
				return;
			}
			$user = this()->input->cookie("username");
			$x = explode(":",$user);
			if(count($x) != 2)
				return;
			this()->load->library("encryption");
			$username = this()->encryption->decrypt($x[0]);
			$password = this()->encryption->decrypt($x[1]);
			perform_login($username, $password, true);
		}
	}

	function session(){
//		ini_set('session.cookie_lifetime', 86400);
//		ini_set('session.gc_maxlifetime', 86400);
	}
}