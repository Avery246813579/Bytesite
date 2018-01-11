<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 8/5/2015
 * Time: 9:14 PM
 */

class DJ {
    public $dj_id, $account_id, $video_link;

    public function __construct($dj_id, $account_id, $video_link){
        $this->dj_id = $dj_id;
        $this->account_id = $account_id;
        $this->video_link = $video_link;
    }
}