<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/26/2015
 * Time: 12:53 AM
 */

class News{
    public $news_id, $account_id, $title, $content, $written;

    public function __construct($news_id, $account_id, $title, $content, $written){
        $this->news_id = $news_id;
        $this->account_id = $account_id;
        $this->title = $title;
        $this->content = $content;
        $this->written = $written;
    }
}