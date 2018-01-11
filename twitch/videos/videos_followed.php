<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 12:59 AM
 */

class videos_followed {
    public $_links, $videos;

    public function __construct($_links, $videos){
        $this->_links = $_links;

        if(is_array($videos)){
            $video_list = array();

            require_once(dirname(__FILE__) . '/videos.php');
            foreach($videos as $value){
                array_push($video_list ,new videos($value['title'], $value['description'], $value['broadcast_id'], $value['status'], $value['_id'], $value['tag_list'], $value['recorded_at'], $value['game'], $value['length'], $value['preview'], $value['url'], $value['views'], $value['broadcast_type'], $value['_links'], $value['channel']));

            }

            $this->videos = $video_list;
        }else{
            $this->videos = $videos;
        }
    }
}