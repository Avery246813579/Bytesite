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
        if (isset($_POST['name']) && isset($_POST['image']) && isset($_POST['link']) && isset($_POST['facebook']) && isset($_POST['twitter'])) {
            $sql_handler->add_sponsor($_POST['name'], $_POST['image'], $_POST['link'], $_POST['facebook'], $_POST['twitter']);
            setcookie('SPONSORS_RESULT', 'SUCCESS', time() + 10);
        } else {
            setcookie('SPONSORS_RESULT', 'ERROR', time() + 10);
        }
    }

    if ($type == 'Edit') {
        if (isset($_POST['name']) && isset($_POST['image']) && isset($_POST['link']) && isset($_POST['facebook']) && isset($_POST['twitter']) && isset($_POST['ID'])) {
            $sponsor = $sql_handler->get_sponsor($_POST['ID']);

            setcookie('EDIT_SPONSOR_RESULT', 'SUCCESS', time() + 10);
            $sponsor->name = $_POST['name'];
            $sponsor->image = $_POST['image'];
            $sponsor->link = $_POST['link'];
            $sponsor->facebook = $_POST['facebook'];
            $sponsor->twitter = $_POST['twitter'];

            $sql_handler->update_sponsor($sponsor);
        } else {
            setcookie('EDIT_SPONSOR_RESULT', 'ERROR', time() + 10);
        }
    }
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type == 'Delete') {
        if (isset($_GET['id'])) {
            $sponsor = $sql_handler->get_sponsor($_GET['id']);
            $sql_handler->delete_sponsor($sponsor);
            setcookie('SPONSOR_RESULT', 'SUCCESS', time() + 10);
        } else {
            setcookie('SPONSOR_RESULT', 'ERROR', time() + 10);
        }
    }
}

header("Location: " . $return);