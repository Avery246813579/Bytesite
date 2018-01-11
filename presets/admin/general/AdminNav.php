<html>
<body>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <?php
            require_once(dirname(__FILE__) . '/../../../SqlHandler.php');
            require_once(dirname(__FILE__) . '/../../../twitch/TwitchHandler.php');

            $twitch_handler = new TwitchHandler();
            $sql_handler = new SqlHandler();

            $account = $sql_handler->get_account($name);

            if ($account != null) {
                $byte = $sql_handler->get_byte_user($account->account_id);

                if ($byte != null) {
                    $user = $twitch_handler->get_user_using_token($byte->access_token);

                    echo '
                <div class="pull-left image">
                    <img src="' . $user->logo . '" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>' . $user->display_name . '</p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
                ';
                }
            }
            ?>
        </div>

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="../../../admin/dashboard/dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-suitcase"></i>
                    <span>Items</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="http://www.roflgator.net/admin/items.php"><i class="fa fa-circle-o"></i> Lists</a></li>
                    <ul class="treeview-menu">
                        <a href="#">
                            <span>Items</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            <a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Qualities</a>
                        </a>
                        <a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Qualities</a>
                    </ul>
                    <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i> Perks</a></li>
                    <li><a href="http://www.roflgator.net/admin/item_types.php"><i class="fa fa-circle-o"></i> Types</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa-newspaper-o"></i>
                    <span>Store</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="http://www.roflgator.net/admin/items.php"><i class="fa fa-circle-o"></i> Items</a></li>
                    <li><a href="http://www.roflgator.net/admin/store.php"><i class="fa fa-circle-o"></i> Store</a></li>
                    <li><a href="http://www.roflgator.net/admin/purchases.php"><i class="fa fa-circle-o"></i> Types</a></li>
                    <li><a href="http://www.roflgator.net/admin/qualities.php"><i class="fa fa-circle-o"></i> Qualities</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="../../../admin/news/view.php"><i class="fa fa-circle-o"></i> View</a></li>
                    <li><a href="../../../admin/news/create.php"><i class="fa fa-circle-o"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Achievements</span>
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
                    <span>Forums</span>
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
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../../admin/users/view.php"><i class="fa fa-circle-o"></i> Users</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Ranks</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
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
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Donations</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Alerts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-child"></i>
                    <span>Sponsors</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../../admin/sponsors/view.php"><i class="fa fa-circle-o"></i> View</a></li>
                    <li><a href="../../../admin/sponsors/create.php"><i class="fa fa-circle-o"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Bot</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>Settings</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../../admin/settings/general.php"><i class="fa fa-circle-o"></i> General</a></li>
                    <li><a href="../../../admin/settings/aboutme.php"><i class="fa fa-circle-o"></i> About me</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
</body>
</html>


/**
* Created by PhpStorm.
* User: Avery
* Date: 6/13/2015
* Time: 9:49 PM
*
* Items:
* - Items
* - Qualities
* - Item Types
* - Perks
*
* Store:
* - Store
* - Category
* - Purchases
*
* News:
* - News
*
* Achievements:
*
* Forums:
*
* Accounts:
* - Byte Users
*
* Tickets:
*
* Donations:
* - Dashboard
* - Donations
*
* Alerts:
* - Sub
*   - Train
* - Follow
*
* Sponsers:
*
* Ranks:
*
*
*
*
*
*
*
*
*/