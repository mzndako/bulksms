<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Runner
 * @property Setting_model $setting_model Runner module
 * @property Setting $setting Send SMS
 */
class Setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }



    public function save_notification($key, $value, $prefix = "notifications"){
        return save_setting("{$prefix}_$key", $value);
    }

    public function get_notification($key, $default = "", $prefix = "notifications"){
        $xx = get_setting("{$prefix}_$key", $default);
        if($xx == ""){
            return mydefault()->notifications($key);
        }
        return $xx;
    }

}