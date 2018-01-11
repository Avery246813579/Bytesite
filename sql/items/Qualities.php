<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 6/1/2015
 * Time: 11:48 PM
 */

class Qualities {
    public $quality_id, $name, $description;

    public function __construct($quality_id, $name, $description){
        $this->quality_id = $quality_id;
        $this->name = $name;
        $this->description = $description;
    }
}