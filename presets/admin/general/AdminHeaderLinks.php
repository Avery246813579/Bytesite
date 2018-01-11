<head>
    <meta charset="UTF-8">

    <?php
    require_once(dirname(__FILE__) . '/../../../FileHandler.php');
    $file_handler = new FileHandler();

    echo '<title>' . $file_handler->getValue('/../../../info.txt', 'FIRST_PART') . $file_handler->getValue('/../../../info.txt', 'SECOND_PART') . '</title>';
    ?>

    <link rel="shortcut icon" href="../../../icon.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <link href="../../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <link href="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
</head>