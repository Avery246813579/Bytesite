<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 6/1/2015
 * Time: 11:48 PM
 */

class Item_Type {
    public $type_id, $name, $description, $can_use;

    public function __construct($type_id, $name, $description, $can_use){
        $this->type_id = $type_id;
        $this->name = $name;
        $this->description = $description;
        $this->can_use = $can_use;
    }
}