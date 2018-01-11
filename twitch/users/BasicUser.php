<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/15/2015
 * Time: 8:04 PM
 */

class BasicUser {
    public $self_link, $type, $bio, $logo, $display_name, $created_at, $updated_at, $_id, $name;

    public function __construct($links, $type, $bio, $logo, $display_name, $created_at, $updated_at, $_id, $name){
        $this->self_link = $links['self'];
        $this->type = $type;
        $this->bio = $bio;
        $this->logo = $logo;
        $this->display_name = $display_name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->_id = $_id;
        $this->name = $name;
    }

}