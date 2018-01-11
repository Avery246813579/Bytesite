<?php
require_once('../../../SqlHandler.php');
$sql_handler = new SqlHandler();

if (isset($_COOKIE['USER'])) {
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);
    $byte_user = $sql_handler->get_byte_user($account->account_id);
    $rank = $sql_handler->get_rank($byte_user->rank_id);

    if ($rank->rank_index < 10) {
        header("Location: ../../../index.php");
    }
} else {
    header("Location: ../../../login.php");
}
