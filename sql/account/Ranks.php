<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/25/2015
 * Time: 10:29 PM
 */

class Ranks {
    public $rank_id, $rank, $rank_index, $tag_image;

    public function __construct($rank_id, $rank, $rank_index, $tag_image){
        $this->rank_id = $rank_id;
        $this->rank = $rank;
        $this->rank_index = $rank_index;
        $this->tag_image = $tag_image;
    }
}