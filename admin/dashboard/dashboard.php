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
                Dashboard
                <small>Bytesite v1.0.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a><i class="fa fa-dashboard"></i> Dashboard</a></li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Follows</span>
                            <div id="follow_amount">
                                <span class="info-box-number"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Subscribers</span>
                            <div id="sub_amount">
                                <span class="info-box-number"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Revenue</span>
                            <span class="info-box-number">Nada</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <div id="user_amount">
                                <span class="info-box-number"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooter.php'); ?>
</div>

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#follow_amount').load("/../../presets/admin/dashboard/Follows.php");
        $('#sub_amount').load("/../../presets/admin/dashboard/Subscribers.php");
        $('#user_amount').load("/../../presets/admin/dashboard/Users.php");
    });
</script>

<?php require_once(dirname(__FILE__) . '/../../presets/admin/general/AdminFooterLinks.php'); ?>
</body>
</html>