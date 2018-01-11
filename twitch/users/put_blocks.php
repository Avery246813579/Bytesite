<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 6:37 PM
 */

class put_blocks {
    public $_links, $updated_at, $user, $_id;

    public function __construct($_links, $updated_at, $user, $_id){
        $this->_links = $_links;
        $this->updated_at = $updated_at;
        $this->user = $user;
        $this->_id = $_id;
    }
}