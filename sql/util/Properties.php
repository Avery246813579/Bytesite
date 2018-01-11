<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/15/2015
 * Time: 5:22 PM
 */

class Properties {
    public $property_id, $key, $value;

    public function __construct($property_id, $key, $value){
        $this->property_id = $property_id;
        $this->key = $key;
        $this->value = $value;
    }
}