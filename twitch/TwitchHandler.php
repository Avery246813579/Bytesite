<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/17/2015
 * Time: 11:41 PM
 */

class TwitchHandler {
    var $base_url = "https://api.twitch.tv/kraken/"; //Don't touch this value
    var $client_id = ''; //Change this to your client id
    var $client_secret = ""; //Change this to your client secret
    var $redirect_url = ''; //Change this to your redirect link

    //Description: Gets a user using their access token
    //Parameters: User's Access Token
    //Scope needed: user_read
    //Returns: user.php with (type, name, created_at, updated_at, _links, logo, _id, display_name, bio)
    function get_user_using_token($access_token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "user");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $access_token
        ));
        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/user.php');

            $user = new user($response['type'], $response['name'], $response['created_at'], $response['updated_at'], $response['_links'], $response['logo'], $response['_id'],
                $response['display_name'], $response['email'], $response['partnered'], $response['bio'], $response['notifications']);
            return $user;
        }
    }

    //Description: Gets a user using their access token
    //Parameters: User's Username
    //Returns: user.php with (type, name, created_at, updated_at, _links, logo, _id, display_name, email, partnered, bio, notifications)
    function get_user_using_username($name){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "users/" . $name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/user.php');

            $user = new user($response['type'], $response['name'], $response['created_at'], $response['updated_at'], $response['_links'], $response['logo'], $response['_id'],
                $response['display_name'], $response['email'], $response['partnered'], $response['bio'], $response['notifications']);
            return $user;
        }
    }

    function get_follows($channel){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base_url . "channels/" . $channel . "/follows");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            echo 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/channel/Follows.php');

            $follows = new Follows($response['_total'], $response['_links'], $response['follows']);
            return $follows;
        }
    }

    function get_subscribers($channel, $token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "channels/" . $channel . "/subscriptions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $token
        ));

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/channel/Subscriptions.php');

            $subscription = new Subscriptions($response['_total'], $response['_links'], $response['subscriptions']);
            return $subscription;
        }
    }

    //ONLINE STREAMS
    function get_streams_followed($access_token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "streams/followed");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $access_token
        ));

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/streams/followed.php');

            $followed = new followed($response['_links'], $response['_total'], $response['streams']);
            return $followed;
        }
    }

    function get_videos_followed($access_token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "videos/followed");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $access_token
        ));

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            if (!defined(dirname(__FILE__) . '/videos/videos_followed.php')) {
                require(dirname(__FILE__) . '/videos/videos_followed.php');

                $followed = new videos_followed($response['_links'], $response['videos']);
                return $followed;
            }else{
                return 'Error | Could not find /videos/videos_followed.php';
            }
        }
    }

    function get_blocks($username, $access_token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "/users/" . $username . "/blocks");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $access_token
        ));

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            if (!defined(dirname(__FILE__) . '/users/blocks.php')) {
                require(dirname(__FILE__) . '/videos/blocks.php');

                $blocks = new blocks($response['_links'], $response['blocks']);
                return $blocks;
            }else{
                return 'Error | Could not find /users/blocks.php';
            }
        }
    }

    function put_blocks($user, $access_token, $target){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . '/users/' . $user . '/blocks/' . $target);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $access_token
        ));

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            if (!defined(dirname(__FILE__) . '/users/put_blocks.php')) {
                require(dirname(__FILE__) . '/users/put_blocks.php');

                $put_blocks = new put_blocks($response['_links'], $response['updated_at'], $response['user'], $response['_id']);
                return $put_blocks;
            }else{
                return 'Error | Could not find /users/put_blocks.php';
            }
        }
    }

    function get_video($video_id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . "videos/" . $video_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);

        if (isset($response['error'])) {
            return 'Unauthorized | You have used the wrong Access Token or don\'t have the correct scope';
        } else {
            require_once(dirname(__FILE__) . '/videos/videos.php');

            $video = new videos($response['title'], $response['description'], $response['broadcast_id'], $response['status'], $response['_id'], $response['tag_list'], $response['recorded_at'], $response['game'], $response['length'], $response['preview'], $response['url'], $response['views'], $response['broadcast_type'], $response['_links'], $response['channel']);
            return $video;
        }
    }
}