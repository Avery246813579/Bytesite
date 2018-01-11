<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 8/7/2015
 * Time: 3:21 PM
 */
if (!isset($_COOKIE['USER'])) {
    header("Location: login.php");
} else {
    require_once('SqlHandler.php');
    $sql_handler = new SqlHandler();
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);

    setcookie('DJ_RESULT', null, time() - 5);
    if ($sql_handler->get_dj_id($account->account_id) != null) {
        setcookie('DJ_RESULT', 'ALREADY', time() + 5);
    } else {
        if (strpos($_POST['video'], 'www.youtube.com') !== false) {
            $sql_handler->add_dj($account->account_id, $_POST['video']);
            setcookie('DJ_RESULT', 'SUCCESS', time() + 5);
        } else {
            setcookie('DJ_RESULT', 'ERROR', time() + 5);
        }
    }
}

header("Location: dj.php");