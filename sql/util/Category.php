<?php
/**
 * Created by PhpStorm.
 * User: 17durranta
 * Date: 6/4/2015
 * Time: 9:46 AM
 */

class Category {
    public $category_id, $name, $description, $type;

    /** Type = 0 - Store */

    public function __construct($category_id, $name, $description, $type){
        $this->category_id = $category_id;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
    }
}