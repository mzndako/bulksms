<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 22-11-17
 * Time: 3:09 AM
 */


function network_id($ntw){
	$ntwk['mtn'] = 23;
	$ntwk['9mobile'] = 11;
	$ntwk['airtel'] = 21;

	getIndex($ntwk, $ntw);
}

function airtime_post(){
	$post['amount'] = $this->options['amount'];
	$post['pan'] = $this->options['number'];
	$post['providerId'] = network_id($this->options['network']);
	$post['depositTypeId'] = 0;
}

function authenthicate($post){
	$post['authGuid'] = $this->get_mysetting("token");
	$post['userGuid'] = $this->get_mysetting("user_id");
}