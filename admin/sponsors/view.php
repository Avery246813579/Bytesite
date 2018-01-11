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
                <li class="active">View</li>
            </ol>
        </section>

        <section class="content">
            <?php
            if (isset($_COOKIE['SPONSOR_RESULT'])) {
                $response = $_COOKIE['SPONSOR_RESULT'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sponsor deleted successfully!</h4>
                    Sponsor was deleted successfully.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error deleting sponsor!</h4>
                    For some reason, the sponsor was unable to be deleted!
                  </div>
                ';
                }
            }

            if (isset($_COOKIE['EDIT_SPONSOR_RESULT'])) {
                $response = $_COOKIE['EDIT_SPONSOR_RESULT'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sponsor edited successfully!</h4>
                    Sponsor was edited successfully.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error editing sponsor!</h4>
                    For some reason, the sponsor was unable to be edited!
                  </div>
                ';
                }
            }


            ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">View Posts</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Link</th>
                            <th>Facebook</th>
                            <th>Twitter</th>
                        </tr>

                        <tbody>
                        <?php
                        $sql_handler = new SqlHandler();
                        $sponsors = $sql_handler->get_sponsors();


                        if (is_array($sponsors)) {
                            if (count($sponsors) > 0) {
                                $sponsors = array_reverse($sponsors);

                                foreach ($sponsors as $values) {
                                    if ($values instanceof Sponsors) {
                                        echo ' <tr >
                                            <td><a href="SponsorAction.php?id=' . $values->sponsor_id . '&type=Delete&back=view.php"><button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></a>
                                            <a href="edit.php?id=' . $values->sponsor_id . '"><button class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button></a></td>
                                            <td> ' . $values->name . ' </td >
                                            <td>' . $values->image . '</td >
                                            <td>' . $values->link . '</td >
                                            <td>' . $values->facebook . '</td >
                                            <td>' . $values->twitter . '</td >
                                        </tr >';
                                    }
                                }
                            }
                        } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooter.php'); ?>
</div>


<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooterLinks.php'); ?>
</body>
</html>