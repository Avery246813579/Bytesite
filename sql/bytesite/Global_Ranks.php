<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/22/2015
 * Time: 1:54 AM
 */

class Global_Ranks {
    public $rank_id, $name, $rank_index, $tag_image;

    public function  __construct($rank_id, $name, $rank_index, $tag_image){
        $this->rank_id = $rank_id;
        $this->name = $name;
        $this->rank_index = $rank_index;
        $this->tag_image = $tag_image;
    }
}