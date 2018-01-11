<?php
require_once(dirname(__FILE__) . '../../SqlHandler.php');
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$sql_handler = new SqlHandler();

$back_url = "http://www.roflgator.net/admin/dashboard.php";
if (isset($_POST['ReturnPage'])) {
    $back_url = $_POST['ReturnPage'];
}

if (isset($_GET['back'])) {
    $back_url = $_GET['back'];
}

if (!isset($_COOKIE['USER'])) {
    header("Location: " . $back_url);
} else {
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);
    $byte_user = $sql_handler->get_byte_user($account->account_id);
    $rank = $sql_handler->get_rank($byte_user->rank_id);

    if ($rank->rank_index < 10) {
        header("Location: " . $back_url);
    } else {
        if (isset($_POST['ActionType'])) {
            $action_type = $_POST['ActionType'];

            if ($action_type == "NewItem") {
                if ($_POST['name']) {
                    $name = $_POST['name'];
                }

                if ($_POST['description']) {
                    $description = $_POST['description'];
                }

                if ($_POST['gph']) {
                    $gph = $_POST['gph'];
                }

                if ($_POST['image']) {
                    $item_url = $_POST['image'];
                }

                if ($_POST['perks']) {
                    $perks = $_POST['perks'];
                }

                if ($_POST['quality']) {
                    $quality = $_POST['quality'];
                }

                if ($_POST['type']) {
                    $type = $_POST['type'];
                }

                $sql_handler->add_item($name, $description, $gph, $perks, $quality, $type, $item_url);
            }

            if ($action_type == "NewPerk") {
                if ($_POST['name']) {
                    $name = $_POST['name'];
                }

                if ($_POST['description']) {
                    $description = $_POST['description'];
                }

                $sql_handler->add_perks($name, $description);
            }

            if ($action_type == "NewQuality") {
                if ($_POST['name']) {
                    $name = $_POST['name'];
                }

                if ($_POST['description']) {
                    $description = $_POST['description'];
                }

                $sql_handler->add_quality($name, $description);
            }

            if ($action_type == "NewItemType") {
                if ($_POST['name']) {
                    $name = $_POST['name'];
                }

                if ($_POST['description']) {
                    $description = $_POST['description'];
                }

                if ($_POST['can_use']) {
                    $can_use = $_POST['can_use'];
                }

                $sql_handler->add_item_type($name, $description, $can_use);
            }

            if ($action_type == "NewStoreCategory") {
                if ($_POST['name']) {
                    $name = $_POST['name'];
                }

                if ($_POST['description']) {
                    $description = $_POST['description'];
                }

                $sql_handler->add_category($name, $description, 0);
            }

            if ($action_type == "NewStore") {
                if ($_POST['item']) {
                    $item = $_POST['item'];
                }

                if ($_POST['category']) {
                    $category = $_POST['category'];
                }

                if ($_POST['price']) {
                    $price = $_POST['price'];
                }

                $sql_handler->add_store($category, $item, $price);
            }
        }

        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type == "DeleteItem") {
                $id = $_GET['id'];

                $item = $sql_handler->get_item($id);
                $sql_handler->delete_item($item);
            }

            if ($type == "DeletePerk") {
                $id = $_GET['id'];

                $perk = $sql_handler->get_perk($id);
                $sql_handler->delete_perk($perk);
            }

            if ($type == "DeleteQuality") {
                $id = $_GET['id'];

                $quality = $sql_handler->get_quality($id);
                $sql_handler->delete_quality($quality);
            }

            if ($type == "DeleteItemType") {
                $id = $_GET['id'];
                $item_type = $sql_handler->get_item_type($id);
                $sql_handler->delete_item_type($item_type);
            }

            if ($type == "DeleteStoreCategory") {
                $id = $_GET['id'];
                $category = $sql_handler->get_category($id);
                $sql_handler->delete_category($category);
            }

            if ($type == "DeleteStore") {
                $id = $_GET['id'];
                $store = $sql_handler->get_store($id);
                $sql_handler->delete_store($store);
            }
        }

        header("Location: " . $back_url);
    }
}

