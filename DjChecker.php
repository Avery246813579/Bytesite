<?php
require_once(dirname(__FILE__) . '/SqlHandler.php');
$sql_handler = new SqlHandler();

$stop = $sql_handler->get_property('DJ_STOP');
/** Alert Types
 *
 * 0 - Follow
 * 1 - Donation
 * 2 - Host
 * 3 - Subscription
 *
 *  */
ob_start();

$time = round(microtime(true));
if($stop != null){
    if($time > $stop->value){
        $sql_handler->delete_property($stop);
        $video = $sql_handler->get_property('DJ_VIDEO');
        $start = $sql_handler->get_property('DJ_START');

        $sql_handler->delete_property($video);
        $sql_handler->delete_property($start);

        $requester = $sql_handler->get_property('DJ_REQUESTER');
        if($requester != null){
            $sql_handler->delete_property($requester);
        }

        $name = $sql_handler->get_property('DJ_NAME');
        if($name != null){
            $sql_handler->delete_property($name);
        }

        echo "<p>Test</p>";
    }else{
        $video = $sql_handler->get_property('DJ_VIDEO');

        if(isset($_COOKIE['DJ_VID'])){
            $vid = $_COOKIE['DJ_VID'];

            if($vid != $video->value){
                $start = $sql_handler->get_property('DJ_START');
                $current = round(microtime(true));
                $time = $current - $start->value;
                $echo = '';

                $name = $sql_handler->get_property('DJ_NAME');
                if($name != null){
                    $echo = $echo . '<b> Video Title: ' . $name->value . '</b>';
                }

                $requester = $sql_handler->get_property('DJ_REQUESTER');
                if($requester != null){
                    $echo = $echo . '<b> Requested by:'  . $requester->value . '</b><br>';
                }

                $echo = $echo . '<iframe width = "560" height = "315" src = "https://www.youtube-nocookie.com/embed/' . $video->value . '?start=' . $time . '&amp;rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder = "0" allowfullscreen ></iframe >';
                echo $echo;

                if(isset($_COOKIE['DJ_VID'])){
                    setcookie('DJ_VID', null, time() - 10);
                }

                setcookie('DJ_VID', $video->value, time() + (60 * 60));
            }
        }else{
            $start = $sql_handler->get_property('DJ_START');
            $current = round(microtime(true));
            $time = $current - $start->value;
            $echo = '';

            $name = $sql_handler->get_property('DJ_NAME');
            if($name != null){
                $echo = $echo . '<b> Video Title: ' . $name->value . '</b>';
            }

            $requester = $sql_handler->get_property('DJ_REQUESTER');
            if($requester != null){
                $echo = $echo . '<b> Requested by:'  . $requester->value . '</b><br>';
            }

            $echo = $echo . '<iframe width = "560" height = "315" src = "https://www.youtube-nocookie.com/embed/' . $video->value . '?start=' . $time . '&amp;rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder = "0" allowfullscreen ></iframe >';
            echo $echo;
            setcookie('DJ_VID', $video->value, time() + (60 * 60));
        }
    }
}else{
    $djs = $sql_handler->get_djs();

    if(is_array($djs)){
        if(count($djs) > 0){
            include('sql/activity/DJ.php');
            $dj = $djs[0];

            if($dj instanceof DJ){
                $start = $sql_handler->get_property('DJ_START');
                if($start != null){
                    $sql_handler->delete_property($start);
                }

                $video = $sql_handler->get_property('DJ_VIDEO');
                if($video != null){
                    $sql_handler->delete_property($video);
                }

                $requester = $sql_handler->get_property('DJ_REQUESTER');
                if($requester != null){
                    $sql_handler->delete_property($requester);
                }

                $name = $sql_handler->get_property('DJ_NAME');
                if($name != null){
                    $sql_handler->delete_property($name);
                }

                parse_str(parse_url($dj->video_link, PHP_URL_QUERY), $get_parameters);
                $video_id = $get_parameters['v'];

                $sql_handler->delete_dj($dj);
                $sql_handler->add_property('DJ_VIDEO', $video_id);
                $sql_handler->add_property('DJ_START', $time);
                $sql_handler->add_property('DJ_STOP', $time + youtubeVideoDuration($video_id, 'AIzaSyAo4yg-Ix7iJxzFSMT8yxJuoF_McL9PZkw'));
                $sql_handler->add_property('DJ_REQUESTER', $sql_handler->get_account_using_id($dj->account_id)->username);

                $title = youtubeVideoTitle($video_id, 'AIzaSyAo4yg-Ix7iJxzFSMT8yxJuoF_McL9PZkw');
                if($title != null){
                    $sql_handler->add_property('DJ_NAME', $title);
                }

                $echo = '';

                $name = $sql_handler->get_property('DJ_NAME');
                if($name != null){
                    $echo = $echo . '<b> Video Title: ' . $name->value . '</b>';
                }

                $requester = $sql_handler->get_property('DJ_REQUESTER');
                if($requester != null){
                    $echo = $echo . '<b> Requested by:'  . $requester->value . '</b><br>';
                }

                $echo = $echo . '<iframe width = "560" height = "315" src = "https://www.youtube-nocookie.com/embed/' . $video_id . '?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder = "0" allowfullscreen ></iframe >';
                echo $echo;

                if(isset($_COOKIE['DJ_VID'])){
                    setcookie('DJ_VID', null, time() - 10);
                }

                setcookie('DJ_VID', $video->value, time() + (60 * 60));
            }
        }else{
            if(isset($_COOKIE['DJ_VID'])) {
                $video = $sql_handler->get_property('DJ_VIDEO');

                if($video == null){
                    echo '<p>Done</p>';
                    setcookie('DJ_VID', null, time() - 10);
                }
            }
        }
    }
}



function youtubeVideoDuration($video_id, $api_key)
{
    // video json data
    $json_result = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$video_id&key=$api_key");
    $result = json_decode($json_result, true);

    // video duration data
    if (!count($result['items'])) {
        return null;
    }
    $duration_encoded = $result['items'][0]['contentDetails']['duration'];

    // duration
    $interval = new DateInterval($duration_encoded);
    $seconds = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

    return $seconds;
}

function youtubeVideoTitle($video_id, $api_key)
{
    // video json data
    $json_result = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$video_id&key=$api_key");
    $result = json_decode($json_result, true);

    $title = $result['title'];

    return $title;
}
