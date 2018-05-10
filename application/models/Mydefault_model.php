<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Runner
 * @property Mydefault_model $mydefault_model Runner module
 * @property Mydefault $mydefault Send SMS
 */
class Mydefault_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    function notifications($key){
//        REGISTRATION MAIL
        $array['registration_mail_title'] = "WELCOME";
        $array['registration_mail'] = "<b>WELCOME @@fname@@</b> TO @@site_name@@<br>
Your account registration was successful.<br>
Username: @@username@@<br>
Password: @@password@@
Thank you for your registration";
        $array['registration_mail_enabled'] = "";
//        REGISTRATION SMS
        $array['registration_sms_title'] = "WELCOME";
        $array['registration_sms'] = mail2sms($array['registration_mail']);

        //FUND WALLET MAIL
        $array['fund_wallet_mail_title'] = "ACCOUNT CREDITED";
        $array['fund_wallet_mail'] = "Dear @@fname@@,<br>Your account has been credited:<br><br>
Previous Balance: @@p_balance@@<br>
Amount Paid: @@amount@@<br>
Transaction Fee: @@transaction_fee@@<br>
<b>Amount Credited: @@amount_credited@@</b><br>
Account Balance @@balance@@<br><br>
Thank You";
        //FUND WALLET SMS
        $array['fund_wallet_sms_title'] = "ACCOUNT CREDITED";
        $array['fund_wallet_sms'] = "Dear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You";

        //PASSWORD RESET MAIL
        $array['password_reset_mail_title'] = "PASSWORD RESET";
        $array['password_reset_mail'] = "Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>
Or simply click on this link below<br>@@link@@";
        //PASSWORD RESET SMS
        $array['password_reset_sms_title'] = "PASSWORD RESET";
        $array['password_reset_sms'] = mail2sms($array['password_reset_mail']);

        //MISSED YOU MAIL
        $array['missed_you_mail_title'] = "ITS BEEN A WHILE";
        $array['missed_you_mail'] = "Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You";
        $array['missed_you_mail_day'] = 7;
        //MISSED YOU SMS
        $array['missed_you_sms_title'] = "ITS BEEN A WHILE";
        $array['missed_you_sms'] = mail2sms($array['missed_you_mail']);
        $array['missed_you_sms_day'] = 7;


        return getIndex($array, $key);
    }

    function all_defaults($key, $default = ""){
        $array['email_footer'] = "<br /><br /><br /><br /><br /><br /><br /><hr /><center><a href=\"".""."\">&copy; 2017 Quicktel Solution</a></center>";
        return getIndex($array, $key, $default);
    }


}