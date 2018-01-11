<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 6/1/2015
 * Time: 11:48 PM
 */

class Store {
    public $store_id, $category, $item, $price;

    public function __construct($store_id, $category, $item, $price){
        $this->store_id = $store_id;
        $this->category = $category;
        $this->item = $item;
        $this->price = $price;
    }
}