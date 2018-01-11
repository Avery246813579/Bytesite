<?php
ob_start();
setcookie('LAST_PAGE', 'index.php', time() + 3000);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    require_once(dirname(__FILE__) . '/FileHandler.php');
    $file_handler = new FileHandler();

    echo '<title>' . $file_handler->getValue('info.txt', 'FIRST_PART') . $file_handler->getValue('info.txt', 'SECOND_PART') . ' | Store</title>';
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

            <?php
            if(isset($_COOKIE['RESULT'])){
                $result = $_COOKIE['RESULT'];
                $split = explode('|', $result);

                if($split[0] == "ITEM"){
                    echo'
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4> Error purchasing item!</h4>
                    Item was not found in database!
                </div>
                ';
                }

                if($split[0] == "MONEY"){
                    echo'
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4> Error purchasing item!</h4>
                    You have unsuccessfully purchased the \'' . $split[1] . '\'! You don\'t have enough money! You <b>need</b> ' . $split[2] . ' points while <b>you only have</b> ' . $split[3] . ' points!
                </div>
                ';
                }

                if($split[0] == "SUCCESS"){
                    echo'
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4> Item Purchased Successfully!</h4>
                    You have successfully purchased the \'' . $split[1] . '\' for ' . $split[2] . ' points!
                </div>
                ';
                }

                ob_start();
                setcookie('RESULT', 'NULL', 10 - time());
            }
            ?>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <?php
                    $sql_handler = new SqlHandler();
                    $category = $sql_handler->get_categories(0);

                    if (is_array($category)) {
                        foreach ($category as $values) {
                            if ($values instanceof Category) {
                                echo '<li><a href="#tab_' . $values->category_id . '" data-toggle="tab">' . $values->name . '</a></li>';
                            }
                        }
                    }
                    ?>

                    <li class="active"><a href="#tab_0" data-toggle="tab">Home</a></li>
                    <li class="pull-left header"><i class="fa fa-shopping-cart"></i> Store</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">
                        <b>Welcome to the shop!</b>

                        <p>Enjoy</p>
                    </div>

                    <?php
                    $sql_handler = new SqlHandler();
                    $category = $sql_handler->get_categories(0);

                    if (is_array($category)) {
                        foreach ($category as $values) {
                            if ($values instanceof Category) {
                                $items = $sql_handler->get_stores_using_category($values->category_id);

                                echo '
                                   <div class="tab-pane" id="tab_' . $values->category_id . '">
                                   <div class="row">
                                   ';
                                if (is_array($items)) {
                                    foreach ($items as $val) {
                                        if ($val instanceof Store) {
                                            $item = $sql_handler->get_item($val->item);

                                            echo '
                                            <div class="col-xs-6 col-md-3">
                                                <div class="thumbnail">
                                                    <img src="' . $item->item_image . '" alt="...">

                                                    <div class="caption">
                                                        <h3>' . $item->name . '</h3>
                                                        <p>' . $item->description . '</p>
                                                        <p>
                                                            <a href="StoreAction.php?item=' . $item->item_id . '&price=' . $val->store_id . '&back=' . $values->category_id . '" class="btn btn-primary btn-success pull-left" role="button">Purchase</a>
                                                            <span style="display:inline-block; vertical-align:middle;"> ' . $val->price . ' Credits</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                    }
                                }
                                echo '</div> </div>';
                            }
                        }
                    }

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
<script src='../../plugins/fastclick/fastclick.min.js'></script>
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
<script src="../../dist/js/demo.js" type="text/javascript"></script>
</body>
</html>