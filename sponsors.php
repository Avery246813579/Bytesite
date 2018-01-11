<?php
setcookie('LAST_PAGE', 'index.php', time() + 3000);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    require_once(dirname(__FILE__) . '/FileHandler.php');
    $file_handler = new FileHandler();

    echo '<title>' . $file_handler->getValue('info.txt', 'FIRST_PART') . $file_handler->getValue('info.txt', 'SECOND_PART') . ' | Sponsors</title>';
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

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Sponsors</h3>
                </div>

                <div class="box-body">
                    <?php
                    $sql_handler = new SqlHandler();
                    $sponsors = $sql_handler->get_sponsors();

                    if (is_array($sponsors)) {
                        foreach ($sponsors as $values) {
                            if ($values instanceof Sponsors) {
                                echo '<div class="col-xs-6 col-md-3" >
                                <div class="thumbnail">
                                    <img src="' . $values->image . '" alt="...">

                                    <div class="caption">
                                        <h3>' . $values->name . '</h3>
                                        <p>
                                            <div class="text-center">
                                                <a class="btn btn-social-icon btn-facebook" href="' . $values->facebook . '"><i class="fa fa-facebook"></i></a>
                                                <a href="' . $values->link . '" class="btn btn-primary btn-success pull-left" role="button">Link me</a>&nbsp;
                                                <a class="btn btn-social-icon btn-twitter" href="' . $values->twitter . '"><i class="fa fa-twitter"></i></a>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                        </div>';
                            }
                        }
                    }
                    ?>
                    &nbsp;
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