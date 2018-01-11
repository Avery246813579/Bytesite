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
                About Me Settings
                <small>Bytesite v1.0.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../dashboard/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="general.php"> Settings</a></li>
                <li class="active">About Me</li>
            </ol>
        </section>

        <section class="content">
            <?php
            if (isset($_COOKIE['ABOUT_ME_SETTINGS'])) {
                $response = $_COOKIE['ABOUT_ME_SETTINGS'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Settings updated successfully!</h4>
                    About me settings has been updated successfully.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error updating settings!</h4>
                    For some reason, there was an error updating the about me settings!
                  </div>
                ';
                }
            }
            ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit About Me Settings</h3>
                </div>

                <form action="SettingsAction.php" role="form" method="post">
                    <div class="box-body">
                        <?php
                        $sql_handler = new SqlHandler();

                        echo '
                        <div class="form-group">
                            <label for="aboutme">About me</label>
                            <textarea class="textarea" name="aboutme" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">' . $sql_handler->get_property('ABOUT_ME')->value . '</textarea>
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control" name="facebook" placeholder="Name" value="' . $sql_handler->get_property('FACEBOOK')->value . '">
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" class="form-control" name="twitter" placeholder="Name" value="' . $sql_handler->get_property('TWITTER')->value . '">
                        </div>

                        <div class="form-group">
                            <label for="youtube">Youtube</label>
                            <input type="text" class="form-control" name="youtube" placeholder="Name" value="' . $sql_handler->get_property('YOUTUBE')->value . '">
                        </div>

                        <div class="form-group">
                            <label for="twitch">Twitch</label>
                            <input type="text" class="form-control" name="twitch" placeholder="Name" value="' . $sql_handler->get_property('TWITCH')->value . '">
                        </div>

                        <input type="hidden" name="ActionType" value="AboutMe">
                        <input type="hidden" name="ReturnPage" value="aboutme.php">
                        ';
                        ?>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Edit About Me Settings</button>
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