<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 1:30 PM
 */

class Messages {
    public $message_id, $type, $account_id, $friend_id, $subject, $message, $sent;

    public function __construct($message_id, $type, $account_id, $friend_id, $subject, $message, $sent){
        $this->message_id = $message_id;
        $this->type = $type;
        $this->account_id = $account_id;
        $this->friend_id = $friend_id;
        $this->subject = $subject;
        $this->message = $message;
        $this->sent = $sent;
    }
}