<!DOCTYPE html>
<html>
<body>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src='../../plugins/fastclick/fastclick.min.js'></script>
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
<script src="../../dist/js/demo.js" type="text/javascript"></script>
<script>
    $(function () {
        $('#nav_friend').load("/presets/nav/Requests.php");
        $('#nav_notification').load("/presets/nav/Notifications.php");
        $('#news').load("/presets/news/news.php");
        $('#user_posts').load("/presets/profiles/Posts.php?url=" + window.location.href);
    });
</script>
</body>
</html>