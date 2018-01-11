<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 1:29 AM
 */

class User_Blocks {
    public $block_id, $blocker_id, $blocked_id;

    public function __construct($block_id, $blocker_id, $blocked_id){
        $this->block_id = $block_id;
        $this->blocker_id = $blocker_id;
        $this->blocked_id = $blocked_id;
    }
}