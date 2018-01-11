<?php
require_once('SqlHandler.php');
$sql_handler = new SqlHandler();

if (isset($_COOKIE['USER'])) {
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);
    $byte_user = $sql_handler->get_byte_user($account->account_id);
    $rank = $sql_handler->get_rank($byte_user->rank_id);

    if ($rank->rank_index >= 10) {
        $start = $sql_handler->get_property('DJ_START');
        if($start != null){
            $sql_handler->delete_property($start);
        }

        $video = $sql_handler->get_property('DJ_VIDEO');
        if($video != null){
            $sql_handler->delete_property($video);
        }

        $end = $sql_handler->get_property('DJ_STOP');
        if($end != null){
            $sql_handler->delete_property($end);
        }

        $requester = $sql_handler->get_property('DJ_REQUESTER');
        if($requester != null){
            $sql_handler->delete_property($requester);
        }

        $name = $sql_handler->get_property('DJ_NAME');
        if($name != null){
            $sql_handler->delete_property($name);
        }
    }
}

header("Location: dj.php");