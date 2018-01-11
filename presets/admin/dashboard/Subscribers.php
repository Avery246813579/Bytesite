<?php
require_once(dirname(__FILE__) . '/../../../twitch/TwitchHandler.php');
require_once(dirname(__FILE__) . '/../../../SqlHandler.php');
$twitch_handler = new TwitchHandler();
$sql_handler = new SqlHandler();

$account = $sql_handler->get_account($sql_handler->get_property('CHANNEL')->value);
if ($account != null) {
    $byte = $sql_handler->get_byte_user($account->account_id);

    if ($byte != null) {
        $subs = $twitch_handler->get_subscribers($account->username, $byte->access_token);
        echo '<span class="info-box-number">' . $subs->_total . '</span>';
    }
}
