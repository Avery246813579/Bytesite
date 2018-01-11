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
                News Posts
                <small>Bytesite v1.0.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../dashboard/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="view.php"> News Posts</a></li>
                <li class="active">View</li>
            </ol>
        </section>

        <section class="content">
            <?php
            if (isset($_COOKIE['NEWS_RESULT'])) {
                $response = $_COOKIE['NEWS_RESULT'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> News post deleted successfully!</h4>
                    The news post was deleted successfully.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error deleting news post!</h4>
                    For some reason, the news post was unable to be deleted!
                  </div>
                ';
                }
            }

            if (isset($_COOKIE['EDIT_NEWS_RESULT'])) {
                $response = $_COOKIE['EDIT_NEWS_RESULT'];

                if ($response == "SUCCESS") {
                    echo '
                <div class="alert alert-success  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> News post edited successfully!</h4>
                    The news post was edited successfully.
                </div>
                ';
                }

                if ($response == "ERROR") {
                    echo '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error editing news post!</h4>
                    For some reason, the news post was unable to be edited!
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
                            <th>Title</th>
                            <th>Content</th>
                        </tr>

                        <tbody>
                        <?php
                        $sql_handler = new SqlHandler();
                        $news = $sql_handler->get_news();


                        if (is_array($news)) {
                            if(count($news) > 0) {
                                $news = array_reverse($news);

                                foreach ($news as $values) {
                                    if ($values instanceof News) {
                                        echo ' <tr >
                                            <td><a href="NewsAction.php?id=' . $values->news_id . '&type=Delete&back=view.php"><button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></a>
                                            <a href="edit.php?id=' . $values->news_id . '"><button class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button></a></td>
                                            <td> ' . $values->title . ' </td >
                                            <td>' . $values->content . '</td >
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