<?php
require_once(dirname(__FILE__) . '../../../SqlHandler.php');
require_once(dirname(__FILE__) . '../../../twitch/TwitchHandler.php');
$twitch_handler = new TwitchHandler();
$sql_handler = new SqlHandler();

$account = $sql_handler->get_account($_COOKIE['USER']);

if ($account != null) {
    $byte = $sql_handler->get_byte_user($account->account_id);

    if ($byte != null) {
        $user = $twitch_handler->get_user_using_token($byte->access_token);
        $requests = $sql_handler->get_requests($account->account_id);

        if (count($requests) > 0) {
            foreach ($requests as $values) {
                if ($values instanceof Requests) {
                    if ($values->requested_id == $account) {
                        $other_account = $values->requester_id;
                    } else {
                        $other_account = $values->requested_id;
                    }

                    $other_account = $sql_handler->get_account_using_id($other_account);

                    if ($other_account != null) {
                        $other_byte = $sql_handler->get_byte_user($other_account->account_id);

                        if ($other_byte != null) {
                            $other_user = $twitch_handler->get_user_using_token($other_byte->access_token);

                            if ($other_byte != null) {
                                echo '<li>
                                    <a href="http://www.roflgator.net/user.php?' . $other_account->username . '"><img src="' . $other_user->logo . '" class="img-circle" alt="User Image" width="20" height="20" /> ' . $other_user->display_name . '</a>
                                    <a class="btn btn-block btn-success" href="http://roflgator.net/close.php" target="_blank"> Confirm</a>
                                    <a class="btn btn-block btn-default"> Delete</a>
                                </li>';
                            }
                        }
                    }
                }
            }
        }
    }
}