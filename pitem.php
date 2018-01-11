<?php
ob_start();
if(isset($_COOKIE['USER'])) {
    $username = $_COOKIE['USER'];
    setCookie('USER', $username, (-10 + time()));
    setcookie('USER', $username, (time() + 300));
}else{
    setcookie('LAST_PAGE', 'points.php', time() + 300);
    header("location:login.php");
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (strpos($actual_link, '?')) {
    $item_list = explode('?', $actual_link);
    $item_name = str_replace('%20', ' ', $item_list[1]);

    $username = "malecki_gsite";
    $password = "3456sdfg78654g34x6r";
    $hostname = "127.0.0.1";

    $dbh = mysql_connect($hostname, $username, $password) or die("Could not connect to database");
    $selected = mysql_select_db("malecki_roflgator", $dbh);

    $item_query = mysql_query("SELECT * FROM Items WHERE name = '$item_name'");
    if(mysql_num_rows($item_query) > 0){
        $name = $_COOKIE['USER'];
        $item_id = mysql_result($item_query, 0, 'item_id');
        $account_query = mysql_query("SELECT * FROM Accounts WHERE username = '$name'");

        if(mysql_num_rows($account_query) > 0){
            $gator_query = mysql_query("SELECT * FROM Gators WHERE account_id = " . mysql_result($account_query, 0, 'account_id'));

            if(mysql_num_rows($gator_query) > 0){
                $item_string = mysql_result($gator_query, 0, 'inventory');

                if(strpos($item_string, ',')){
                    $items = explode(',', $item_string);

                    if(!in_array($item_id, $items)){
                        $player_points = mysql_result($gator_query, 0, 'points');
                        $item_cost = mysql_result($item_query, 0, 'price');

                        if($player_points >= $item_cost){
                            $updated_points = $player_points - $item_cost;
                            $new_inventory = $item_string . ',' . $item_id;

                            mysql_query("UPDATE Gators SET points = '$updated_points', inventory = '$new_inventory' WHERE gator_id = " . mysql_result($gator_query, 0, 'gator_id'));
                            setcookie('PURCHASE_RESULT', 'DONE|' . $item_name, time() + 300);
                        }else{
                            setcookie('PURCHASE_RESULT', 'ERROR|NOT_ENOUGH_MONEY' . $player_points . ' ' . $item_cost, time() + 300);
                        }
                    }else{
                        setcookie('PURCHASE_RESULT', 'ERROR|ITEM_ALREADY_OBTAINED', time() + 300);
                    }
                }else{
                    $item_length = strlen($item_string);

                    if($item_length > 0){
                        if($item_string != $item_id) {
                            $player_points = mysql_result($gator_query, 0, 'points');
                            $item_cost = mysql_result($item_query, 0, 'price');

                            if($player_points >= $item_cost){
                                $updated_points = $player_points - $item_cost;
                                $new_inventory = $item_string . ',' . $item_id;

                                mysql_query("UPDATE Gators SET points = '$updated_points', inventory = '$new_inventory' WHERE gator_id = " . mysql_result($gator_query, 0, 'gator_id'));
                                setcookie('PURCHASE_RESULT', 'DONE|' . $item_name, time() + 300);
                            }else{
                                setcookie('PURCHASE_RESULT', 'ERROR|NOT_ENOUGH_MONEY' . $player_points . ' ' . $item_cost, time() + 300);
                            }
                        }else{
                            setcookie('PURCHASE_RESULT', 'ERROR|ITEM_ALREADY_OBTAINED', time() + 300);
                        }
                    }else{
                        $player_points = mysql_result($gator_query, 0, 'points');
                        $item_cost = mysql_result($item_query, 0, 'price');

                        if($player_points >= $item_cost){
                            $updated_points = $player_points - $item_cost;
                            $new_inventory = $item_string . ',' . $item_id;

                            mysql_query("UPDATE Gators SET points = '$updated_points', inventory = '$new_inventory' WHERE gator_id = " . mysql_result($gator_query, 0, 'gator_id'));
                            setcookie('PURCHASE_RESULT', 'DONE|' . $item_name, time() + 300);
                        }else{
                            setcookie('PURCHASE_RESULT', 'ERROR|NOT_ENOUGH_MONEY' . $player_points . ' ' . $item_cost, time() + 300);
                        }
                    }
                }
            }else{
                setcookie('PURCHASE_RESULT', 'ERROR|GATOR_NOT_FOUND', time() + 300);
            }
        }else{
            setcookie('PURCHASE_RESULT', 'ERROR|ACCOUNT_NOT_FOUND', time() + 300);
        }
    }else{
        setcookie('PURCHASE_RESULT', 'ERROR|ITEM_NOT_FOUND|' . $item_name, time() + 300);
    }

    ob_start();
    header("location:points.php");
}else{
    echo 'MITTEN';
}
?>

<html>
<head>
    <title>Roflgator | Purchase</title>
</head>
</html>