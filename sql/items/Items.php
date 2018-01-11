<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/16/2015
 * Time: 7:25 PM
 */

class Items {
    public $item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image;

    public function __construct($item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image){
        $this->item_id = $item_id;
        $this->name = $name;
        $this->description = $description;
        $this->gph = $gph;
        $this->perk_ids = $perk_ids;
        $this->quality = $quality;
        $this->item_type = $item_type;
        $this->item_image = $item_image;
    }
}