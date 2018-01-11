<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 1:33 PM
 */

class Notifications {
    public $notification_id, $account_id, $content, $link, $icon, $notified, $type;

    // 0. Friends 1. Message 2. Instants 3. Regular
    public function __construct($notification_id, $account_id, $content, $link, $icon, $notified, $type){
        $this->notification_id = $notification_id;
        $this->account_id = $account_id;
        $this->content = $content;
        $this->link = $link;
        $this->icon = $icon;
        $this->notified = $notified;
        $this->type = $type;
    }
}