<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminAuthentication.php'); ?>
<?php
if (isset($_GET['id'])) {
    $sql_handler = new SqlHandler();
    if ($sql_handler->get_new($_GET['id']) == null) {
        header("Location: view.php");
    }
} else {
    header("Location: view.php");
}

?>

<!DOCTYPE html>
<html>

<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminHeaderLinks.php'); ?>

<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminTopNav.php'); ?>
    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminNav.php'); ?>


    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                News Posts
                <small>Bytesite v1.0.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../dashboard/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="view.php"> News Posts</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit News Post</h3>
                </div>

                <form action="NewsAction.php" role="form" method="post">
                    <div class="box-body">
                        <?php
                        $news = $sql_handler->get_new($_GET['id']);

                        echo '<div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Name" value="' . $news->title . '">
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="textarea" name="content" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">' . $news->content . '</textarea>
                        </div>

                        <input type="hidden" name="ID" value="' . $news->news_id . '">
                        <input type="hidden" name="ActionType" value="Edit">
                        <input type="hidden" name="ReturnPage" value="view.php">
                        ';
                        ?>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Edit News Post</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooter.php'); ?>
</div>


<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooterLinks.php'); ?>
</body>
</html>