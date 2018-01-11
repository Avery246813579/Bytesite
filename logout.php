<?php
    $seconds = -10 + time();
    setCookie('USER', date("F jS - g:i a"), $seconds);

    if(isset($_COOKIE['PAGE_LAST'])) {
        header("Location: " . $_COOKIE['PAGE_LAST']);
    }else{
        header("Location: index.php");
    }
?>