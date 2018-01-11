<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 1:21 AM
 */

class blocks {
    public $_links, $blocks;

    public function __construct($_links, $blocks){
        $this->_links = $_links;
        $this->blocks = $blocks;
    }
}