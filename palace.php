<?php
ob_start();
setcookie('LAST_PAGE', 'palace.php', time() + 3000);

if (!isset($_COOKIE['USER'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    require_once(dirname(__FILE__) . '/FileHandler.php');
    $file_handler = new FileHandler();

    echo '<title>' . $file_handler->getValue('info.txt', 'FIRST_PART') . $file_handler->getValue('info.txt', 'SECOND_PART') . ' | Palace</title>';
    ?>

    <link rel="shortcut icon" href="icon.png">
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
    <?php require_once(dirname(__FILE__) . '/presets/GlobalNav.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <br/>
            <br/>
            <br/>


            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#tab_1" data-toggle="tab">Inventory</a></li>
                    <li class="active"><a href="#tab_0" data-toggle="tab">Dashboard</a></li>
                    <li class="pull-left header"><i class="fa fa-institution"></i> Point Palace</li>
                </ul>
                <div class="tab-content">
                    <?php
                    $sql_handler = new SqlHandler();
                    $account = $sql_handler->get_account($_COOKIE['USER']);
                    $user = $sql_handler->get_byte_user($account->account_id);

                    echo '<div class="tab-pane active" id="tab_0">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Points</span>
                                        <span class="info-box-number">' . $user->points . '</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-diamond"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">XP</span>
                                        <span class="info-box-number">' . $user->xp . '</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-diamond"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Rank</span>
                                        <span class="info-box-number">Coming to a website near you</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-diamond"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Division</span>
                                        <span class="info-box-number">Coming to a website near you</span>
                                    </div>
                                </div>
                            </div>

                            <b>Welcome to the shop!</b>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_1">
                        <div class="row">';

                    $items = $user->inventory;
                    $active = $user->active_items;
                    if(strpos($user->inventory, ',')) {
                        $items = explode(',', $user->inventory);

                        foreach($items as $values){
                            $inventory = $sql_handler->get_item($values);
                        }
                    }else{
                        $inventory = $sql_handler->get_item($items);
                    }

                    if(strpos($user->active_items, ',')) {
                        $active = explode(',', $user->active_items);
                    }

                    if(is_array($inventory)) {
                        foreach ($inventory as $values) {
                            if ($values instanceof Items) {
                                echo '<div class="col-xs-6 col-md-3" >
                                    <div class="thumbnail" >
                                        <img src = "' . $values->item_image . '" alt = "..." >

                                        <div class="caption" >
                                            <h3 > ' . $values->name . '</h3 >
                                            <p > ' . $values->description . '</p >
                                            <p >';

                                if(is_array($active)){
                                    if(in_array($values->item_id, $active)){
                                        echo '<a href = "PalaceAction.php?type=remove&item=' . $values->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Remove</a >';
                                    }else{
                                        echo '<a href = "PalaceAction.php?type=use&item=' . $values->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Use</a >';
                                    }
                                }else{
                                    if($active == $values->item_id){
                                        echo '<a href = "PalaceAction.php?type=remove&item=' . $values->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Remove</a >';
                                    }else{
                                        echo '<a href = "PalaceAction.php?type=use&item=' . $values->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Use</a >';
                                    }
                                }


                                echo '<a href = "PalaceAction.php" class="btn btn-primary btn-primary pull-right" role = "button" > Sell</a >
                                            </p >
                                        </div >
                                    </div >
                                </div > ';
                            }
                        }
                    }else if($inventory instanceof Items){
                        echo '<div class="col-xs-6 col-md-3" >
                                    <div class="thumbnail" >
                                        <img src = "' . $inventory->item_image . '" alt = "..." >

                                        <div class="caption" >
                                            <h3 > ' . $inventory->name . '</h3 >
                                            <p > ' . $inventory->description . '</p >
                                            <p >';

                        if(is_array($active)){
                            if(in_array($inventory->item_id, $active)){
                                echo '<a href = "PalaceAction.php?type=remove&item=' . $inventory->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Remove</a >';
                            }else{
                                echo '<a href = "PalaceAction.php?type=use&item=' . $inventory->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Use</a >';
                            }
                        }else{
                            if($active == $inventory->item_id){
                                echo '<a href = "PalaceAction.php?type=remove&item=' . $inventory->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Remove</a >';
                            }else{
                                echo '<a href = "PalaceAction.php?type=use&item=' . $inventory->item_id . '" class="btn btn-primary btn-success pull-left" role = "button" > Use</a >';
                            }
                        }

                                                echo '&nbsp;<a href = "PalaceAction.php?type=sell&item=' . $inventory->item_id . '" class="btn btn-primary btn-primary pull-right" role = "button" > Sell</a >
                                            </p >
                                        </div >
                                    </div >
                                </div > ';
                    }

                    echo '</div >
                    </div > ';
                    ?>
                </div>
            </div>
        </div>
    </div>


    <?php require_once(dirname(__FILE__) . '/presets/GlobalFooter.php'); ?>
</div>

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src=' ../../plugins / fastclick / fastclick . min . js'></script>
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
<script src="../../dist/js/demo.js" type="text/javascript"></script>
</body>
</html>