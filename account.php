<?php
ob_start();
echo '<br ><br ><br >';

if(isset($_COOKIE['USER'])) {
    $username = $_COOKIE['USER'];
    setCookie('USER', $username, (-10 + time()));
    setcookie('USER', $username, (time() + 300));
}else{
    ob_start();
    setcookie('LAST_PAGE', 'account.php', time() + 120);
    header('location:login.php');
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>Roflgator | Account</title>
</head>

<body>
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
    if(isset($_COOKIE['USER'])) {
        $username = "malecki_gsite";
        $password = "3456sdfg78654g34x6r";
        $hostname = "127.0.0.1";

        $dbh = mysql_connect($hostname, $username, $password) or die("Could not connect to database");
        $selected = mysql_select_db("malecki_roflgator", $dbh);

        $user = $_COOKIE['USER'];
        $result = mysql_query("SELECT * FROM Accounts WHERE username = '$user'");

        $created = mysql_result($result, 0, 'date_created');
        $last = mysql_result($result, 0, 'last_log');

        echo '<br >';
        echo '<p>Username:</p>';
        echo '<p>' . $_COOKIE['USER'] . '</p>';

        echo '<br >';
        echo '<p>Date Created:</p>';
        echo '<p>' . $created . '</p>';

        echo '<br >';
        echo '<p>Last Login:</p>';
        echo '<p>' . $last . '</p>';

        mysql_close();
    }
    ?>

    <br >
    <a href="logout.php">Logout</a>
</div>
</body>
</html>