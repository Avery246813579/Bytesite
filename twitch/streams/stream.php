<?php

/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 8:21 PM
 */
class stream
{
    public $game, $viewers, $average_fps, $video_height, $created_at, $_id, $channel, $preview, $_links;

    public function __construct($game, $viewers, $average_fps, $video_height, $created_at, $_id, $channel, $preview, $_links)
    {
        $this->game = $game;
        $this->viewers = $viewers;
        $this->average_fps = $average_fps;
        $this->video_height = $video_height;
        $this->created_at = $created_at;
        $this->_id = $_id;
        $this->preview = $preview;
        $this->_links = $_links;

        if (is_array($channel)) {
            require_once(dirname(__FILE__) . '/channel.php');
            $this->channel = new channel($channel['mature'], $channel['status'], $channel['broadcaster_language'], $channel['display_name'], $channel['game'], $channel['delay'], $channel['language'], $channel['_id'], $channel['name'], $channel['created_at'], $channel['updated_at'], $channel['logo'], $channel['banner'], $channel['video_banner'], $channel['background'], $channel['profile_banner'], $channel['profile_banner_background_color'], $channel['partner'], $channel['url'], $channel['views'], $channel['followers'], $channel['_links']);
        } else {
            $this->channel = $channel;
        }
    }
}