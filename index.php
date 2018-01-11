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

    echo '<title>' . $file_handler->getValue('info.txt', 'FIRST_PART') . $file_handler->getValue('info.txt', 'SECOND_PART') . '</title>';
    ?>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="shortcut icon" href="icon.png">
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
                    <h3 class="box-title">News</h3>

                    <?php
                    $sql_handler = new SqlHandler();

                    if (isset($_COOKIE['USER'])) {
                        $account = $sql_handler->get_account($_COOKIE['USER']);

                        if ($account != null) {
                            $byte_user = $sql_handler->get_byte_user($account->account_id);

                            if ($byte_user != null) {
                                $rank = $sql_handler->get_rank($byte_user->rank_id);

                                if ($rank != null) {
                                    if ($rank->rank_index >= 10) {
                                        echo '<a href="admin/news/create.php"><small class="text-muted pull-right">New Post</small></a>';
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>

                <div id="news">

                </div>
            </div>
        </div>
    </div>


    <?php require_once(dirname(__FILE__) . '/presets/GlobalFooter.php'); ?>
</div>

<?php require_once(dirname(__FILE__) . '/presets/ExternalLinking.php'); ?>
</body>
</html>