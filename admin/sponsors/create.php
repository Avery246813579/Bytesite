<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminAuthentication.php'); ?>

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
                <li class="active">Create</li>
            </ol>
        </section>

        <section class="content">
            <?php
            if (isset($_COOKIE['SPONSORS_RESULT'])) {
                $response = $_COOKIE['SPONSORS_RESULT'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sponsor created successfully!</h4>
                    Sponsor was created successfully and will be on displayed.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error creating sponsor!</h4>
                    For some reason, the sponsor was unable to be created!
                  </div>
                ';
                }
            }

            ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Sponsor</h3>
                </div>

                <form action="SponsorAction.php" role="form" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="text" class="form-control" name="image" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" name="link" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control" name="facebook" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" class="form-control" name="twitter" placeholder="Name">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Create Sponsor</button>
                    </div>
                    <input type="hidden" name="ActionType" value="Create">
                    <input type="hidden" name="ReturnPage" value="create.php">
                </form>
            </div>
        </section>
    </div>

    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooter.php'); ?>
</div>


<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooterLinks.php'); ?>
</body>
</html>