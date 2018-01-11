<?php
setcookie('LAST_PAGE', 'index.php', time() + 3000);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    require_once('SqlHandler.php');
    $sql_handler = new SqlHandler();

    echo '<title>' . $sql_handler->get_property('TITLE_PART_1')->value . $sql_handler->get_property('TITLE_PART_2')->value . '</title>';
    ?>

    <link rel="shortcut icon" href="icon.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
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

            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">About me</h3>
                            </div>

                            <div class="box-body">
                                <?php
                                $sql_handler = new SqlHandler();

                                echo $sql_handler->get_property('ABOUT_ME')->value;
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Social Media</h3>
                            </div>
                            <div class="box-body">
                                <?php
                                $sql_handler = new SqlHandler();

                                $widget = explode('|', $sql_handler->get_property('TWITTER_WIDGET')->value);

                                echo '
                                <a class="btn btn-block btn-social btn-facebook" href="http://' . $sql_handler->get_property('FACEBOOK')->value . '" target="_blank">
                                    <i class="fa fa-facebook"></i> Like me on Facebook
                                </a>
                                <a class="btn btn-block btn-social btn-twitter" href="http://' . $sql_handler->get_property('TWITTER')->value . '" target="_blank">
                                    <i class="fa fa-twitter"></i> Follow me on Twitter
                                </a>
                                <a class="btn btn-block btn-social btn-google-plus" href="http://' . $sql_handler->get_property('YOUTUBE')->value . '" target="_blank">
                                    <i class="fa fa-youtube"></i> Subscribe to me on Youtube
                                </a>
                                <a class="btn btn-block btn-social bg-purple" href="http://' . $sql_handler->get_property('TWITCH')->value . '" target="_blank">
                                    <i class="fa fa-twitch"></i> Check me out on twitch
                                </a>


                                <a class="twitter-timeline" href="https://twitter.com/' . $widget[0] . '" data-widget-id="' . $widget[1] . '">Tweets by @' . $widget[0] . '</a>
                                <script>!function (d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? \'http\' : \'https\';
                                        if (!d.getElementById(id)) {
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = p + "://platform.twitter.com/widgets.js";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }
                                    }(document, "script", "twitter-wjs");</script>
                                    ';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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