<?php
require_once(dirname(__FILE__) . '/../../SqlHandler.php');
require_once(dirname(__FILE__) . '/../../twitch/TwitchHandler.php');
$sql_handler = new SqlHandler();
$twitch_handler = new TwitchHandler();

$alerts = $sql_handler->get_alerts();
$follows = $twitch_handler->get_follows('mahyar121');

if(is_array($follows->follows)){
    $latest = $follows->follows[0];

    if($latest instanceof Follow){
        $user = $latest->user;

        echo $user->name;
    }
}
?>

<html>
<body>
<div id="loading">
</div>
</body>

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
    (function Forever(){
        $('#loading').fadeOut();

        $.ajax({
            url: 'AlertChecker.php',
            success: function (response) {
                eval(response);
            }
        });

        setTimeout(Forever, 10000);
    })();


</script>
</html>