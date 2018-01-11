<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/17/2015
 * Time: 11:31 PM
 */

class user {
    public $type, $name, $created_at, $updated_at, $_links, $logo, $_id, $display_name, $email, $partnered, $bio, $notifications;

    public function __construct($type, $name, $created_at, $updated_at, $_links, $logo, $_id, $display_name, $email, $partnered, $bio, $notifications){
        $this->type = $type;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->_links = $_links;
        $this->logo = $logo;
        $this->_id = $_id;
        $this->display_name = $display_name;
        $this->email = $email;
        $this->partnered = $partnered;
        $this->bio = $bio;
        $this->notifications = $notifications;
    }
}