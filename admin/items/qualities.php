<?php
require_once(substr(dirname(__FILE__), 0, strlen(dirname(__FILE__)) - 5) . '/SqlHandler.php');
require_once(substr(dirname(__FILE__), 0, strlen(dirname(__FILE__)) - 5) . '/twitch/TwitchHandler.php');
$sql_handler = new SqlHandler();
$twitch_handler = new TwitchHandler();

if (isset($_COOKIE['LAST_PAGE'])) {
    setcookie('LAST_PAGE', '', -10 + time());
}

setcookie('LAST_PAGE', 'http://www.roflgator.net/admin/qualities.php', time() + 60 * 60 * 24 * 365 * 2);

if (isset($_COOKIE['USER'])) {
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);
    $byte_user = $sql_handler->get_byte_user($account->account_id);
    $rank = $sql_handler->get_rank($byte_user->rank_id);

    if ($rank->rank_index < 10) {
        header("Location:http://www.roflgator.net/index.php");
    }
} else {
    //header("Location:http://www.roflgator.net/login.php");
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Roflgator | Qualities</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <?php
            $name = $_COOKIE['USER'];

            $twitch_handler = new TwitchHandler();
            $sql_handler = new SqlHandler();

            $account = $sql_handler->get_account($name);

            if ($account != null) {
                $user = $twitch_handler->get_user_using_token($account->access_token);

                $requests = $sql_handler->get_requests($account->account_id);
                echo ' <!-- Notifications Menu -->
                         <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
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

                if (count($requests) > 0) {
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

                if (count($notes) > 0) {
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

                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
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
            } else {
                echo '<div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                                    <ul class="nav navbar-nav">
                                        <li><a href="../../login.php">LOGIN / REGISTER</a></li>
                                    </ul>
                                </div>';
            }
            ?>
            </ul>
            </li>
            </ul>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <?php
                $twitch_handler = new TwitchHandler();
                $sql_handler = new SqlHandler();

                $account = $sql_handler->get_account($name);

                echo '<div class="pull-left image">
                    <img src="' . $account->logo . '" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>' . $account->display_name . '</p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>'
                ?>

            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active treeview">
                    <a href="http://www.roflgator.net/admin/dashboard.php">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Store</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i> Items</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Store</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/purchases.php"><i class="fa fa-circle-o"></i>
                                Purchases</a></li>
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i>
                                Qualities</a></li>
                        <li><a href="http://www.roflgator.net/admin/item_types.php"><i class="fa fa-circle-o"></i> Item
                                Types</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-newspaper-o"></i>
                        <span>News</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i> Items</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Store</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/purchases.php"><i class="fa fa-circle-o"></i>
                                Purchases</a></li>
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i>
                                Qualities</a></li>
                        <li><a href="http://www.roflgator.net/admin/item_types.php"><i class="fa fa-circle-o"></i> Item
                                Types</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-newspaper-o"></i>
                        <span>Achievements</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i> Items</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Store</a>
                        </li>
                        <li><a href="http://www.roflgator.net/admin/purchases.php"><i class="fa fa-circle-o"></i>
                                Purchases</a></li>
                        <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i>
                                Qualities</a></li>
                        <li><a href="http://www.roflgator.net/admin/item_types.php"><i class="fa fa-circle-o"></i> Item
                                Types</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Forums</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>Accounts</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> Byte Users</a></li>
                        <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Rank Types</a></li>
                        <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Settings</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i>
                        <span>Tickets</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a>
                        </li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Qualities
                <small>Bytesite Version Alpha 1.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="http://www.roflgator.net/index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="http://www.roflgator.net/store.php"> Store</a></li>
                <li class="active">Qualities</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">New Quality</h3>
                        </div>

                        <form action="../AdminAction.php" role="form" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Quality Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Perk Name">
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" name="description"
                                           placeholder="Description">
                                </div>
                            </div>

                            <input type="hidden" name="ActionType" value="NewQuality">
                            <input type="hidden" name="ReturnPage" value="http://www.roflgator.net/admin/qualities.php">

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Qualities</h3>

                            <div class="box-tools pull-right">
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <?php
                            $sql_handler = new SqlHandler();
                            $qualities = $sql_handler->get_qualities();

                            echo '
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>';

                            if (is_array($qualities)) {
                                foreach ($qualities as $values) {
                                    if ($values instanceof Qualities) {
                                        echo ' <tr >
                                            <td><a href="../AdminAction.php?id=' . $values->quality_id . '&type=DeleteQuality&back=qualities.php"><button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></a></td>
                                            <td class="mailbox-name" > ' . $values->name . ' </td >
                                            <td class="mailbox-subject" >' . $values->description . '</td >
                                        </tr >';
                                    }
                                }
                            }

                            echo '</tbody>
                                </table><!-- /.table -->
                            </div><!-- /.mail-box-messages -->
                        </div>';
                            ?>
                        </div>
                        <!-- /. box -->
                    </div>
                    <!-- /.col -->
                </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Byte Site Version</b> Alpha 1.0
            </div>
            <strong>Copyright &copy; 2014-2015 <a href="http://frostbytedev.com">Frostbyte Development</a>.</strong> All
            rights reserved.
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="../../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- ChartJS 1.0.1 -->
<script src="../../plugins/chartjs/Chart.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard2.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js" type="text/javascript"></script>
</body>
</html>