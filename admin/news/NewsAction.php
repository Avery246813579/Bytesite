<?php
require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminAuthentication.php');
require_once('../../SqlHandler.php');
$sql_handler = new SqlHandler();

$return = "view.php";
if (isset($_POST['ReturnPage'])) {
    $return = $_POST['ReturnPage'];
}

if (isset($_GET['back'])) {
    $return = $_GET['back'];
}

if (isset($_POST['ActionType'])) {
    $type = $_POST['ActionType'];

    if ($type == 'Create') {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $time = new DateTime($date, new DateTimeZone('America/Los_Angeles'));
            $time->setTimezone(new DateTimeZone('America/New_York'));
            $time_result = $time->format('Y-m-d H:i:s');

            $account = $sql_handler->get_account($_COOKIE['USER']);

            if ($account != null) {
                $sql_handler->add_news($account->account_id, $_POST['title'], $_POST['content'], $time_result);
                setcookie('NEWS_RESULT', 'SUCCESS', time() + 10);
            }
        } else {
            setcookie('NEWS_RESULT', 'ERROR', time() + 10);
        }
    }

    if ($type == 'Edit') {
        if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['ID'])) {
            $news = $sql_handler->get_new($_POST['ID']);

            setcookie('EDIT_NEWS_RESULT', 'SUCCESS', time() + 10);
            $news->content = $_POST['content'];
            $news->title = $_POST['title'];
            $sql_handler->update_news($news);
        }else{
            setcookie('EDIT_NEWS_RESULT', 'ERROR', time() + 10);
        }
    }
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type == 'Delete') {
        if (isset($_GET['id'])) {
            $news = $sql_handler->get_new($_GET['id']);
            $sql_handler->delete_news($news);
            setcookie('NEWS_RESULT', 'SUCCESS', time() + 10);
        } else {
            setcookie('NEWS_RESULT', 'ERROR', time() + 10);
        }
    }
}

header("Location: " . $return);