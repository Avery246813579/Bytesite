<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/18/2015
 * Time: 7:31 PM
 */

class channel {
    public $mature, $status, $broadcaster_language, $display_name, $game, $delay, $language, $_id, $name, $created_at, $updated_at, $logo, $banner, $video_banner, $background, $profile_banner, $profile_banner_background_color, $partner, $url, $views, $followers, $_links;

    public function __construct($mature, $status, $broadcaster_language, $display_name, $game, $delay, $language, $_id, $name, $created_at, $updated_at, $logo, $banner, $video_banner, $background, $profile_banner, $profile_banner_background_color, $partner, $url, $views, $followers, $_links){
        $this->mature = $mature;
        $this->status = $status;
        $this->broadcaster_language = $broadcaster_language;
        $this->display_name = $display_name;
        $this->game = $game;
        $this->delay = $delay;
        $this->language = $language;
        $this->_id = $_id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->logo = $logo;
        $this->banner = $banner;
        $this->video_banner = $video_banner;
        $this->background = $background;
        $this->profile_banner = $profile_banner;
        $this->profile_banner_background_color = $profile_banner_background_color;
        $this->partner = $partner;
        $this->url = $url;
        $this->views = $views;
        $this->followers = $followers;
        $this->_links = $_links;
    }
}