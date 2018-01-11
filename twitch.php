<?php
if(isset($_COOKIE['USER'])){
    if(isset($_COOKIE['LAST_PAGE'])){
        header("Location: " . $_COOKIE['LAST_PAGE']);
    } else{
        header("Location: http://www.roflgator.net/index.php");
    }
}
require_once(dirname(__FILE__) . '/FileHandler.php');
$file_handler = new FileHandler();

header("Location: https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=" . $file_handler->getValue('info.txt', 'CLIENT_ID') . "&redirect_uri=http://" . $file_handler->getValue('info.txt', 'REDIRECT_URI') . "&scope=user_read+channel_check_subscription+channel_read+channel_subscriptions");
?>
