<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/15/2015
 * Time: 1:14 AM
 */

class Alerts {
    public $alert_id, $alert_type, $alert_content;

    public function __construct($alert_id, $alert_type, $alert_content){
        $this->alert_id = $alert_id;
        $this->alert_type = $alert_type;
        $this->alert_content = $alert_content;
    }
}