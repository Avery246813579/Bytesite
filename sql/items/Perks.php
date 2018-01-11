<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/31/2015
 * Time: 10:08 AM
 */

class Perks {
    public $perk_id, $name, $description;

    public function __construct($perk_id, $name, $description){
        $this->perk_id = $perk_id;
        $this->name = $name;
        $this->description = $description;
    }
}