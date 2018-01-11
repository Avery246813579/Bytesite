<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/20/2015
 * Time: 6:17 PM
 */

class videos {
    public $title, $description, $broadcast_id, $status, $_id, $tag_list, $recorded_at, $game, $length, $preview, $url, $views, $broadcast_type, $self_link, $channel_link, $channel_name, $display_name;

    public function __construct($title, $description, $broadcast_id, $status, $_id, $tag_list, $recorded_at, $game, $length, $preview, $url, $views, $broadcast_type, $_links, $channel){
        $this->title = $title;
        $this->description = $description;
        $this->broadcast_id = $broadcast_id;
        $this->status = $status;
        $this->_id = $_id;
        $this->tag_list = $tag_list;
        $this->recorded_at = $recorded_at;
        $this->game = $game;
        $this->length = $length;
        $this->preview = $preview;
        $this->url = $url;
        $this->views = $views;
        $this->broadcast_type = $broadcast_type;
        $this->self_link = $_links['self'];
        $this->channel_link = $_links['channel'];
        $this->channel_name = $channel['name'];
        $this->channel_name = $channel['display_name'];
    }
}