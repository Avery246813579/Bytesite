<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 12:35 PM
 */

class Wall_Comment {
    public $comment_id, $post_id, $account_id, $message, $likes, $posted;

    public function __construct($comment_id, $post_id, $account_id, $message, $likes, $posted){
        $this->comment_id = $comment_id;
        $this->post_id = $post_id;
        $this->account_id = $account_id;
        $this->message = $message;
        $this->likes = $likes;
        $this->posted = $posted;
    }
}