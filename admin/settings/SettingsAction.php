<?php
require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminAuthentication.php');
require_once('../../SqlHandler.php');
$sql_handler = new SqlHandler();

$return = "general.php";
if (isset($_POST['ReturnPage'])) {
    $return = $_POST['ReturnPage'];
}

if (isset($_GET['back'])) {
    $return = $_GET['back'];
}

if (isset($_POST['ActionType'])) {
    $type = $_POST['ActionType'];

    if ($type == 'AboutMe') {
        if (isset($_POST['aboutme']) && isset($_POST['facebook']) && isset($_POST['twitter']) && isset($_POST['youtube']) && isset($_POST['twitch'])) {
            $about_me = $sql_handler->get_property('ABOUT_ME');
            $facebook = $sql_handler->get_property('FACEBOOK');
            $twitter = $sql_handler->get_property('TWITTER');
            $youtube = $sql_handler->get_property('YOUTUBE');
            $twitch = $sql_handler->get_property('TWITCH');

            if($about_me->value != $_POST['aboutme']){
                $about_me->value = $_POST['aboutme'];
                $sql_handler->update_property($about_me);
            }

            if($facebook->value != $_POST['facebook']){
                $facebook->value = $_POST['facebook'];
                $sql_handler->update_property($facebook);
            }

            if($twitter->value != $_POST['twitter']){
                $twitter->value = $_POST['twitter'];
                $sql_handler->update_property($twitter);
            }

            if($youtube->value != $_POST['youtube']){
                $youtube->value = $_POST['youtube'];
                $sql_handler->update_property($youtube);
            }

            if($twitch->value != $_POST['twitch']){
                $twitch->value = $_POST['twitch'];
                $sql_handler->update_property($twitch);
            }

            setcookie('ABOUT_ME_SETTINGS', 'SUCCESS', time() + 10);
        } else {
            setcookie('ABOUT_ME_SETTINGS', 'ERROR', time() + 10);
        }
    }
}

header("Location: " . $return);