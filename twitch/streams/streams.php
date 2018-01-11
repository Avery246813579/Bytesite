<?php

/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 7:22 PM
 */
class streams
{
    public $stream, $_links;

    public function __construct($stream, $_links)
    {
        $this->_links = $_links;

        if (is_array($stream)) {
            $this->stream = new stream($stream['game'], $stream['viewers'], $stream['average_fps'], $stream['video_height'], $stream['created_at'], $stream['_id'], $stream['channel'], $stream['preview'], $stream['_links']);
        } else {
            $this->stream = $stream;
        }
    }

    public function is_online()
    {
        if ($this->stream == null) {
            return false;
        } else {
            return false;
        }
    }
}