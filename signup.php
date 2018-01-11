<?php
if(isset($_COOKIE['USER'])) {
    ob_start();
    header("location:index.php");
}

if($count > 0){
    ob_start();
    echo '<h1> Your account has been registered with twitch! Redirecting you to homepage in 3 seconds!!</h1>';
    echo '<a href="index.php">Click here if redirect does not happen</a>';
    header('Refresh: 3; URL=http://roflgator.net/index.php');
}else{
    ob_start();
    header("location:https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=j4q2a1pk7jwtfnvg0rqyl1rcy9le56n&redirect_uri=http://roflgator.net/authorize.php&scope=user_read+channel_subscriptions");
}
?>