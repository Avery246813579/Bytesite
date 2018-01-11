<?php
require_once(dirname(__FILE__) . '/SqlHandler.php');
$sql_handler = new SqlHandler();

if(!isset($_COOKIE['USER'])){
    header("Location: login.php");
}

if(isset($_GET['type']) && isset($_GET['item'])){
    $type = $_GET['type'];
    $item = $sql_handler->get_item($_GET['item']);
    $account = $sql_handler->get_account($_COOKIE['USER']);
    $user = $sql_handler->get_byte_user($account->account_id);

    //Check if player actually has item.
    //Response messages
    //Check if there is a item type
    if($item != null) {
        if ($type == "use") {
            if(strpos($user->active_items, ',')){
                $user->active_items = $user->active_items + ',' + $item->item_id;
            }else{
                $user->active_items = $item->item_id;
            }
        }

        if ($type == "remove") {
            if(strpos($user->active_items, ',')){
                if(($key = array_search($item->item_id, $user->active_items)) !== false) {
                    unset($user->active_items[$key]);
                }
            }else{
                $user->active_items = '';
            }
        }

        if ($type == "sell") {

        }

        $sql_handler->update_byte_user($user);
    }
}

header("Location: palace.php");
