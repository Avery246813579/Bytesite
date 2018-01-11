<?php
if (isset($_COOKIE['USER'])) {
    $username = $_COOKIE['USER'];
    setCookie('USER', $username, (-10 + time()));
    setcookie('USER', $username, (time() + 300));
} else {
    setcookie('LAST_PAGE', 'points.php', time() + 300);
    header("location:login.php");
}

if (isset($_COOKIE['PURCHASE_RESULT'])) {
    ob_start();
    echo '<br />';
    echo '<br />';
    echo '<br />';
    echo '<br />';

    $purchase_split = explode('|', $_COOKIE['PURCHASE_RESULT']);
    $purchase_result = 'Avery failed!';

    if ($purchase_split[0] == 'ERROR') {
        if ($purchase_split[1] == 'ITEM_NOT_FOUND') {
            $purchase_result = 'Item not found in Database!';
        }

        if ($purchase_split[1] == 'ACCOUNT_NOT_FOUND') {
            $purchase_result = 'Internal error!! Please contact support ASAP!';
        }

        if ($purchase_split[1] == 'GATOR_NOT_FOUND') {
            $purchase_result = 'Internal error!! Please contact support ASAP!';
        }

        if ($purchase_split[1] == 'NOT_ENOUGH_MONEY') {
            $purchase_result = 'You don\'t have enough money to purchase this item!';
        }

        if ($purchase_split[1] == 'ITEM_ALREADY_OBTAINED') {
            $purchase_result = 'Item already obtained! You may not buy a already obtained item!';
        }

        echo '<div class="alert alert-danger" role="alert">' . $purchase_result . '</div>';
    } else {
        echo '<div class="alert alert-success" role="alert">Item has been purchased!</div>';
    }

    echo $_COOKIE['ITEM_PURCHASE'];
    setcookie('ITEM_PURCHASE', 'NULL', -10 + time());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Roflgator | Point Palace</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body class="skin-blue layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand"><b>Rofl</b>Gator</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">POINT PALACE<span class="sr-only">(current)</span></a></li>
                        <li><a href="#">ACTIVITY CENTER</a></li>
                        <li><a href="#">ACHIEVEMENT CITY</a></li>
                        <li><a href="#">ABOUT ME</a></li>
                        <li><a href="#">CONTACT US</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <?php
                        $name = $_COOKIE['USER'];

                        require_once(dirname(__FILE__) . '/SqlHandler.php');
                        require_once(dirname(__FILE__) . '/twitch/TwitchHandler.php');
                        $twitch_handler = new TwitchHandler();
                        $sql_handler = new SqlHandler();

                        $account = $sql_handler->get_account($name);
                        $user = $twitch_handler->get_user_using_token($account->access_token);

                        $requests = $sql_handler->get_requests($account->account_id);
                        echo ' <!-- Notifications Menu -->
                        <li class="dropdown notifications-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-users"></i>';

                        if (count($requests) > 0) {
                            echo '<span class="label label-warning" > ' . count($requests) . '</span>';
                        }

                        echo '</a>
                            <ul class="dropdown-menu">
                                <li class="header">You have ' . count($requests) . ' new friend requests</li>
                                <li>
                                    <!-- Inner Menu: contains the notifications -->
                                    <ul class="menu">';

                        if(count($requests) > 0) {
                            foreach ($requests as $values) {
                                if ($values instanceof Requests) {
                                    $other_account = $sql_handler->get_account_using_id($values->requester_id);
                                    $other_user = $twitch_handler->get_user_using_username($other_account->username);

                                    echo '<li>
                                    <a href="http://www.roflgator.net/user.php?' . $other_account->username . '"><img src="' . $other_user->logo . '" class="img-circle" alt="User Image" width="20" height="20" /> ' . $other_user->display_name . '</a>
                                    <a class="btn btn-block btn-success" href="http://roflgator.net/close.php" target="_blank"> Confirm</a>
                                    <a class="btn btn-block btn-default"> Delete</a>
                                    </li>';
                                }
                            }
                        }

                        echo '</ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>';

                        echo '<li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    </ul>
                                    <!-- /.menu -->
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- /.messages-menu -->

                        <!-- Tasks Menu -->
                        <li class="dropdown tasks-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- Inner menu: contains the tasks -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <!-- Task title and progress text -->
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <!-- The progress bar -->
                                                <div class="progress xs">
                                                    <!-- Change the css width attribute to simulate progress -->
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>';

                        $notes = $sql_handler->get_notes($account->account_id, 3);
                        echo ' <!-- Notifications Menu -->
                        <li class="dropdown notifications-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>';

                        if (count($notes) > 0) {
                            echo '<span class="label label-warning" > ' . count($notes) . '</span>';
                        }

                        echo '</a>
                            <ul class="dropdown-menu">
                                <li class="header">You have ' . count($notes) . ' new notifications</li>
                                <li>
                                    <!-- Inner Menu: contains the notifications -->
                                    <ul class="menu">';

                        if(count($notes) > 0) {
                            foreach ($notes as $values) {
                                if ($values instanceof Notifications) {
                                    echo '<li><a href="' . $values->link . '"><i class="fa ' . $values->icon . ' text-aqua"></i> ' . $values->content . '</a></li>';
                                }
                            }
                        }

                        echo '</ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>';

                        echo '<li class="dropdown user user-menu">';

                        echo '<a href="" class="dropdown-toggle" data-toggle="dropdown">';
                        echo '<img src="' . $user->logo . '" class="user-image" alt="User Image"/>';
                        echo '<span class="hidden-xs">' . $user->display_name . '</span>';
                        echo '</a>';

                        echo '<ul class="dropdown-menu">';
                        echo '<li class="user-header">';

                        echo '<img src="' . $user->logo . '" class="img-circle" alt="User Image" />';

                        $created_date = explode('-', explode(' ', $account->date_created)[0]);

                        echo '<p>';
                        echo $user->display_name . ' - ' . $user->type;
                        echo '<small>Member since ' . date('M', mktime(0, 0, 0, $created_date[1], 10)) . '.' . $created_date[2] . '.' . $created_date[0] . '</small>';
                        echo '</p>';

                        echo '</li>';

                        echo '<li class="user-body">';

                        echo '<div class="col-xs-4 text-center">';
                        echo '<a href="#">Followers</a>';
                        echo '</div>';

                        echo '<div class="col-xs-4 text-center">';
                        echo '<a href="#">Points</a>';
                        echo '</div>';

                        echo '<div class="col-xs-4 text-center">';
                        echo '<a href="#">Friends</a>';
                        echo '</div>';

                        echo '</li>';
                        echo '<li class="user-footer">';

                        echo '<div class="pull-left">';
                        echo '<a href="user.php?' . $name . '" class="btn btn-default btn-flat">Profile</a>';
                        echo '</div>';

                        echo '<div class="pull-right">';
                        echo '<a href="logout.php" class="btn btn-default btn-flat">Sign out</a>';
                        echo '</div>';

                        echo '</li>';
                        ?>
                    </ul>
                    </li>
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>

    <div class="content-wrapper">
        <div class="container">
            <br/>
            <br/>
            <br/>

            <div class="well well-sm">
                <?php
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $name = $_COOKIE['USER'];

                require_once(dirname(__FILE__) . '/SqlHandler.php');
                $sql_handler = new SqlHandler();

                if (strpos($actual_link, '?') === false) {
                    echo '<ul class="nav nav-pills" role="tablist">';
                    echo '<li role="presentation" class="active"><a href="points.php">Point Summary</a></li>';
                    echo '<li role="presentation"><a href="points.php?shop">Shop</a></li>';
                    echo '<li role="presentation"><a href="points.php?inventory">Inventory</a></li>';
                    echo '<li role="presentation"><a href="points.php?leaderboard">Leaderboard</a></li>';
                    echo '</ul>';

                    echo '<hr>';

                    $account = $sql_handler->get_account($name);
                    if ($account != null) {
                        $account_id = $account->account_id;

                        $byte_user = $sql_handler->get_byte_user($account_id);
                        if ($byte_user != null) {
                            $is_subbed = "Not subbed yet :(";

                            if (strcasecmp($byte_user->sub_date, "Unauthorized") != 0) {
                                $d1 = date_create(explode("T", $byte_user->sub_date)[0]);
                                $d2 = new DateTime(date("Y-m-d"));
                                $interval = date_diff($d1, $d2);

                                $is_subbed = $interval->format('%m');
                                $is_subbed = $is_subbed + 1;
                            }

                            echo '<p>Points: ' . $byte_user->points . '</p>';
                            echo '<p>Xp: ' . $byte_user->xp . '</p>';
                            echo '<p>Months Subbed: ' . $is_subbed . '</p>';
                            echo '<p>Donation Amount: ' . $byte_user->donation_amount . '</p>';

                            $inventory_items = explode(",", $byte_user->active_items);
                            $gph = 0;
                            for ($i = 0; $i < count($inventory_items); ++$i) {
                                $item_result = $sql_handler->get_item($inventory_items[$i]);
                                $gph = $gph + $item_result->gph;
                            }

                            echo '<p>Inventory: ' . substr($active_items, 1, strlen($active_items)) . '</p>';
                            echo '<p>Active items: ' . substr($active_items, 1, strlen($active_items)) . '</p>';
                            echo '<p>Current Income Per Hour: ' . $gph . '</p>';
                        }
                    }
                } else {
                    $link_split = explode("?", $actual_link);

                    if (strcasecmp($link_split[1], 'shop') == 0) {
                        echo '<ul class="nav nav-pills" role="tablist">';
                        echo '<li role="presentation"><a href="points.php">Point Summary</a></li>';
                        echo '<li role="presentation" class="active"><a href="points.php?shop">Shop</a></li>';
                        echo '<li role="presentation"><a href="points.php?inventory">Inventory</a></li>';
                        echo '<li role="presentation"><a href="points.php?leaderboard">Leaderboard</a></li>';
                        echo '</ul>';

                        echo '<hr>';

                        echo '<h1>Shop is currently under construction</h1>';
                    } else if (strcasecmp($link_split[1], 'inventory') == 0) {
                        echo '<ul class="nav nav-pills" role="tablist">';
                        echo '<li role="presentation"><a href="points.php">Point Summary</a></li>';
                        echo '<li role="presentation"><a href="points.php?shop">Shop</a></li>';
                        echo '<li role="presentation" class="active"><a href="points.php?inventory">Inventory</a></li>';
                        echo '<li role="presentation"><a href="points.php?leaderboard">Leaderboard</a></li>';
                        echo '</ul>';

                        echo '<hr>';

                        echo '<div class="row">';

                        $account = $sql_handler->get_account($name);
                        if ($account != null) {
                            $account_id = $account->account_id;

                            $byte_user = $sql_handler->get_byte_user($account_id);
                            if ($byte_user != null) {

                                $items = explode(',', $byte_user->inventory);
                                for ($i = 0; $i < count($items); ++$i) {
                                    $item_id = $items[$i];
                                    $item = $sql_handler->get_item($item_id);

                                    echo '<div class="col-sm-6 col-md-4">';
                                    echo '<div class="thumbnail">';
                                    echo '<img src="/Images/Shop_Icons/' . $item->name . '.png">';

                                    echo '<div class="caption">';
                                    echo '<h3>' . $item->name . '</h3>';
                                    echo '<p>' . $item->description . '</p>';
                                    echo '<p><a href="pitem.php?' . $item->name . '" class="btn btn-primary" type="submit" role="button">Use</a></p>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                            }
                        }
                        echo '</div>';
                    } else if (strcasecmp($link_split[1], 'leaderboard') == 0) {
                        echo '<ul class="nav nav-pills" role="tablist">';
                        echo '<li role="presentation"><a href="points.php">Point Summary</a></li>';
                        echo '<li role="presentation"><a href="points.php?shop">Shop</a></li>';
                        echo '<li role="presentation"><a href="points.php?inventory">Inventory</a></li>';
                        echo '<li role="presentation" class="active"><a href="points.php?leaderboard">Leaderboard</a></li>';
                        echo '</ul>';

                        echo '<hr>';

                        require_once(dirname(__FILE__) . '/twitch/TwitchHandler.php');
                        $twitch_handler = new TwitchHandler();

                        $followed = $twitch_handler->get_streams_followed($sql_handler->get_account($name)->access_token);
                        foreach ($followed->streams as $value) {
                            if ($value instanceof stream) {
                                if ($value->channel instanceof channel) {
                                    echo '<p>' . $value->channel->name . '</p>';
                                    echo '<p>' . $value->channel->game . '</p>';
                                }
                            }
                        }
                    } else {
                        echo 'Error';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> Alpha 1.0
            </div>
            <strong>Copyright &copy; 2014-2015 <a href="http://frostbytedev.com">Frostbyte Development</a>.</strong> All rights reserved.
        </div>
    </footer>
</div>

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src='../../plugins/fastclick/fastclick.min.js'></script>
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
<script src="../../dist/js/demo.js" type="text/javascript"></script>
</body>
</html>