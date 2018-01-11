<?php
/**if(!empty($_POST['title'])){
    if(!empty($_POST['content'])){
        $title = $_POST['title'];
        $content = $_POST['content'];

        $username = "malecki_gsite";
        $password = "3456sdfg78654g34x6r";
        $hostname = "127.0.0.1";

        $dbh = mysql_connect($hostname, $username, $password) or die("Could not connect to database");
        $selected = mysql_select_db("malecki_roflgator", $dbh);

        mysql_query("INSERT INTO News (title, content) VALUES ('$title', '$content')");
        mysql_close();

        ob_start();
        echo '<h1> You have created a new news post! Redirecting you to the homepage in 3 seconds!</h1>';
        echo '<a href="index.php">Click here if redirect does not happen</a>';
        header('Refresh: 3; URL=http://roflgator.net/index.php');
    }else{
        echo 'Please fill out post content';
    }
}else{
    echo 'Please fill out post title';
}**/
?>

<html>

<head>
    <title>Roflgator | News Post</title>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
</head>

<body>
    <br />
    <br />
    <br />
    <br />

    <div id="login">
        <?php

        if(isset($_COOKIE['USER'])) {
            $username = $_COOKIE['USER'];

            echo '<a href="account.php">' . $username . '</a>';
        }else{
            echo "<a href='login.php'>Login / Register</a>";
        }

        require_once(dirname(__FILE__) . '/SqlHandler.php');
        $sql_handler = new SqlHandler();

        $accounts = $sql_handler->get_account_mysqli('avery246813579');
        echo $accounts->username;
        ?>
    </div>

    <div id="nav">
        <div id="icon">
            <a href="index.php">Roflgator</a>
        </div>

        <div id="boxl">
            <a href="contact.php">CONTACT US</a>
        </div>

        <div id="box">
            <a href="about.php">ABOUT ME</a>
        </div>

        <div id="box">
            <a href="activity.php">ACTIVITY CENTER</a>
        </div>

        <div id="box">
            <a href="points.php">POINT PALACE</a>
        </div>

        <div id="box">
            <a href="index.php">HOME</a>
        </div>

    </div>

    <div id="content">
        <?php
        echo '<form action = "newspost.php" method = "POST" > <p > Title:</p ><input type = "text" name = "title" /> <p > Content:</p ><textarea name="content"></textarea> <br /> <input type = "submit" value = "create" ></form >';
        ?>
    </div>
</body>
</html>