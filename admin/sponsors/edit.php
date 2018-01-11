<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminAuthentication.php'); ?>
<?php
if (isset($_GET['id'])) {
    $sql_handler = new SqlHandler();
    if ($sql_handler->get_sponsor($_GET['id']) == null) {
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
                Sponsors
                <small>Bytesite v1.0.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../dashboard/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="view.php"> Sponsors</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Sponsors</h3>
                </div>

                <form action="SponsorAction.php" role="form" method="post">
                    <div class="box-body">
                        <?php
                        $sponsors = $sql_handler->get_sponsor($_GET['id']);

                        echo '
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="' . $sponsors->name . '">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="text" class="form-control" name="image" value="' . $sponsors->image . '">
                        </div>

                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" name="link" value="' . $sponsors->link . '">
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control" name="facebook" value="' . $sponsors->facebook . '">
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" class="form-control" name="twitter" value="' . $sponsors->twitter . '">
                        </div>


                        <input type="hidden" name="ID" value="' . $sponsors->sponsor_id . '">
                        <input type="hidden" name="ActionType" value="Edit">
                        <input type="hidden" name="ReturnPage" value="view.php">
                        ';
                        ?>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Edit Sponsor</button>
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