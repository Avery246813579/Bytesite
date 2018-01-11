<?php
require_once(dirname(__FILE__) . '/SqlHandler.php');
$sql_handler = new SqlHandler();

$back_location = "user.php";
if (isset($_POST['ReturnPage'])) {
    $back_location = $_POST['ReturnPage'];
}

if (isset($_COOKIE['USER'])) {
    $account = $sql_handler->get_account($_COOKIE['USER']);

    if ($account != null) {
        if (isset($_POST['Type'])) {
            $type = $_POST['Type'];

            if ($type == "NewPost") {
                $user = $_POST['User'];
                $wall = $_POST['Wall'];
                $post = $_POST['Post'];
                $time = new DateTime();
                $time->setTimezone(new DateTimeZone('America/New_York'));
                $time_result = $time->format('Y-m-d H:i:s');

                if ($account->account_id == $user) {
                    $sql_handler->add_post($user, $wall, $post, 0, $time_result);
                }
            }
        }

        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type == "Note") {
                $id = $_GET['id'];

                $note = $sql_handler->get_note($id);

                $sql_handler->delete_note($note);
                $back_location = $note->link;
            }
        }
    }
}


header("Location: " . $back_location);