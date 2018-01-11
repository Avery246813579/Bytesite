<?php

/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 12:34 AM
 */
class followed
{
    public $_links, $_total, $streams;

    public function __construct($_links, $_total, $streams)
    {
        $this->_links = $_links;
        $this->_total = $_total;

        if (is_array($streams)) {
            $steam_list = array();

            foreach ($streams as $value) {
                require_once(dirname(__FILE__) . '/stream.php');
                array_push($steam_list, new stream($value['game'], $value['viewers'], $value['average_fps'], $value['video_height'], $value['created_at'], $value['_id'], $value['channel'], $value['preview'], $value['_links']));
            }

            $this->streams = $steam_list;
        } else {
            $this->streams = $streams;
        }
    }
}