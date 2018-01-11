<?php
require_once(dirname(__FILE__) . '../../../SqlHandler.php');
$sql_handler = new SqlHandler();

$account = $sql_handler->get_account($_COOKIE['USER']);
if ($account != null) {
    $notes = $sql_handler->get_notes($account->account_id, 3);

    if (count($notes) > 0) {
        foreach ($notes as $values) {
            if ($values instanceof Notifications) {
                echo '<li><a href="../../../AccountAction.php?type=Note&id=' . $values->notification_id . '"><i class="fa ' . $values->icon . ' text-aqua"></i> ' . $values->content . '</a></li>';
            }
        }
    }
}