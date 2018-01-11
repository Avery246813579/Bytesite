<?php
require_once(dirname(__FILE__) . '/SqlHandler.php');
if(isset($_COOKIE['PAGE_LAST'])){
    setcookie('PAGE_LAST', 'dj.php', time() - 10);
}

setcookie('PAGE_LAST', 'dj.php', time() + 60 * 60 * 24 * 7)
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
<?php
if (isset($_COOKIE['DJ_RESULT'])) {
    $response = $_COOKIE['DJ_RESULT'];

    if ($response == "SUCCESS") {
        echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Request has been successful!</h4>
                    You have requested a song!
                </div>
                ';
    }

    if ($response == "ALREADY") {
        echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error requesting song!</h4>
                    You were not able to request a song because you have already requested one! Please wait for your song to play.
                  </div>
                ';
    }

        if ($response == "ERROR") {
            echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error requesting song!</h4>
                    You were not able to request a song because your link was not one from youtube! Please retry with a youtube link.
                  </div>
                ';
    }
}
?>
<div id="loading">
    <?php
    $sql_handler = new SqlHandler();
    $video = $sql_handler->get_property('DJ_VIDEO');

    if ($video != null) {
        ob_start();
        $start = $sql_handler->get_property('DJ_START');
        $current = round(microtime(true));
        $time = $current - $start->value;

        $echo = '';

        $name = $sql_handler->get_property('DJ_NAME');
        if($name != null){
            $echo = $echo . '<b> Video Title: ' . $name->value . '</b>';
        }

        $requester = $sql_handler->get_property('DJ_REQUESTER');
        if($requester != null){
            $echo = $echo . '<b> Requested by:'  . $requester->value . '</b><br>';
        }

        $echo = $echo . '<iframe width = "560" height = "315" src = "https://www.youtube-nocookie.com/embed/' . $video->value . '?start=' . $time . '&amp;rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder = "0" allowfullscreen ></iframe >';
        echo $echo;
    }
    ?>
</div>

<?php

if(isset($_COOKIE['USER'])) {
    echo '
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    Request Video
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <form action="DJRequest.php" role="form" method="post">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="video">Video Link</label>
                            <input type="url" class="form-control" name="video" placeholder="https://www.youtube.com/watch?v=2HQaBWziYvY">
                            <p>Full Youtube link please!! Not a share link!! Has to start with https://www.youtube.com</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request Song</button>
                </div>
            </form>
        </div>
    </div>
</div>';
}else{
    echo '
    <a href="login.php"><button type="button" class="btn btn-primary btn-lg" >
        Login to request a video
    </button></a>
    ';
}

$sql_handler = new SqlHandler();

if (isset($_COOKIE['USER'])) {
    $name = $_COOKIE['USER'];
    $account = $sql_handler->get_account($name);
    $byte_user = $sql_handler->get_byte_user($account->account_id);
    $rank = $sql_handler->get_rank($byte_user->rank_id);

    if ($rank->rank_index >= 10) {
        echo '
        <a href="DJSkip.php"><button type="button" class="btn btn-primary btn-lg" >
        Skip Video
        </button></a>
        ';
    }
}

?>
                </section>
            </div>
        </div>
    </div>
</body>
<?php require_once(dirname(__FILE__) . '/presets/GlobalFooter.php'); ?>

<script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src='plugins/fastclick/fastclick.min.js'></script>
<script src="dist/js/app.min.js" type="text/javascript"></script>
<script src="dist/js/demo.js" type="text/javascript"></script>
<script>
    (function Forever() {
        $.ajax({
            url: 'DjChecker.php',
            success: function (response) {
                if (response.indexOf("<") > -1) {
                    $('#loading').html(response);
                }
            }
        });

        setTimeout(Forever, 1000);
    })();


</script>
</html>