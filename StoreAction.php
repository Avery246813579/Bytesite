<?php

if(!isset($_COOKIE['USER'])){
    header("Location: login.php");
}

$back = "store.php";
if(isset($_GET['back'])){
    $back = $_GET['back'];
}

if(isset($_GET['item']) && isset($_GET['price'])){
    require_once(dirname(__FILE__) . '/SqlHandler.php');
    $sql_handler = new SqlHandler();
    $price = $sql_handler->get_store($_GET['price'])->price;
    $item = $sql_handler->get_item($_GET['item']);

    if($item != null) {
        $user = $sql_handler->get_account($_COOKIE['USER']);
        $byte = $sql_handler->get_byte_user($user->account_id);

        if ($price <= $byte->points) {
            $inventory = $byte->inventory;

            if(strpos($inventory, ',')){
                $inventory = $inventory + ',';
            }

            $inventory = $inventory + $item->item_id;
            $byte->points = $byte->points - $price;
            $byte->inventory = $inventory;
            $sql_handler->update_byte_user($byte);
            setcookie('RESULT', 'SUCCESS|' . $item->name . '|' . $price, time() + 60, '/');
        } else {
            setcookie('RESULT', 'MONEY|' . $item->name . '|' . $price . '|' . $byte->points, time() + 60, '/');
        }
    }else{
        setcookie('RESULT', 'ITEM', time() + 60, '/');
    }
}

header('Location: store.php#tab_' . $back);
