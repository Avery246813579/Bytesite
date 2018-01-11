<?php
if (isset($_COOKIE['USER'])) {
    header('Location: index.php');
}

require_once(dirname(__FILE__) . '/FileHandler.php');
require_once(dirname(__FILE__) . '/SqlHandler.php');
require_once(dirname(__FILE__) . '/TwitchTv.php');
$file_handler = new FileHandler();
$sql_handler = new SqlHandler();
$twitch_tv = new TwitchTV();

$ttv_code = $_GET['code'];
$access_token = $twitch_tv->get_access_token($ttv_code);
$name = $twitch_tv->authenticated_user($access_token);
$back_page = 'index.php';
if(isset($_COOKIE['PAGE_LAST'])){
    $back_page = $_COOKIE['PAGE_LAST'];
}


if ($name != "Unauthorized") {
    $account = $sql_handler->get_account($name);

    $time = new DateTime($date, new DateTimeZone('America/Los_Angeles'));
    $time->setTimezone(new DateTimeZone('America/New_York'));
    $time_result = $time->format('Y-m-d H:i:s');

    if ($account == null) {
        $sql_handler->add_account($name, $time_result, $time_result, 0, 1, 0);
        $account = $sql_handler->get_account($name);
        $sql_handler->add_friend(1, $account->account_id, $time_result);
    }

    $account->last_log = $time_result;
    $sql_handler->update_account($account);

    $user = $sql_handler->get_byte_user($account->account_id);
    if ($user == null) {
        $sql_handler->add_byte_user($account->account_id, $access_token, '', 0, 0, 0, '', '', 0, '');

        $user = $sql_handler->get_byte_user($account->account_id);
    }else{
        $user->access_token = $access_token;
        $sql_handler->update_byte_user($user);
    }

    $streamer_account = $sql_handler->get_account($file_handler->getValue('info.txt', 'CHANNEL'));
    if ($streamer_account != null) {
        $streamer_user = $sql_handler->get_byte_user($streamer_account->account_id);

        if ($streamer_user != null) {
            if ($streamer_user->access_token != null) {
                $sub_date = $twitch_tv->sub_length($streamer_user->access_token, $streamer_account->username, $name);
                $user->sub_date = $sub_date;
                $sql_handler->update_byte_user($user);
            }
        }
    }

    setcookie('USER', $name, time() + 63072000, '/');
    header("location: " . $back_page);
} else {
    echo 'Error finding name!';
}
?>