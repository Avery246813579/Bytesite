<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/15/2015
 * Time: 8:07 PM
 */

class Follow {
    public $created_at, $self_link, $notifications, $user;

    public function __construct($created_at, $links, $notifications, $user){
        $this->created_at = $created_at;
        $this->self_link = $links['self'];
        $this->notifications = $notifications;

        require_once(dirname(__FILE__) . '/../users/BasicUser.php');
        $this->user = new BasicUser($user['_links'], $user['type'], $user['bio'], $user['logo'], $user['display_name'], $user['created_at'], $user['updated_at'], $user['_id'], $user['name']);
    }
}