<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 6/30/2015
 * Time: 1:59 PM
 */

class Sponsors {
    public $sponsor_id, $name, $image, $link, $facebook, $twitter;

    public function __construct($sponsor_id, $name, $image, $link, $facebook, $twitter){
        $this->sponsor_id = $sponsor_id;
        $this->name = $name;
        $this->image = $image;
        $this->link = $link;
        $this->facebook = $facebook;
        $this->twitter = $twitter;
    }
}