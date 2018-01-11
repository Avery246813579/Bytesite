<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 1:27 PM
 */

class Instants {
    public $instant_id, $account_id, $friend_id, $message, $sent;

    public function __construct($instant_id, $account_id, $friend_id, $message, $sent){
        $this->instant_id = $instant_id;
        $this->account_id = $account_id;
        $this->friend_id = $friend_id;
        $this->message = $message;
        $this->sent = $sent;
    }
}