<?php
if(isset($_GET['times'])) {
    require_once(dirname(__FILE__) . '../../../SqlHandler.php');
    require_once(dirname(__FILE__) . '../../../twitch/TwitchHandler.php');
    $twitch_handler = new TwitchHandler();
    $sql_handler = new SqlHandler();

    if (strpos($actual_link, '?')) {
        $user_split = explode('?', $actual_link);

        $unknown_account = $sql_handler->get_account($user_split[1]);
        if ($unknown_account != null) {
            $account = $unknown_account;
        }
    } else {
        if (isset($_COOKIE['USER'])) {
            $unknown_account = $sql_handler->get_account($_COOKIE['USER']);
            if ($unknown_account != null) {
                $account = $unknown_account;
            }
        }
    }

    if ($account != null) {

        $posts = $sql_handler->get_post_on_wall($account->account_id);
        if (is_array($posts)) {
            $i = 0;
            $times = $_GET['times'];
            foreach ($posts as $values) {
                if ($values instanceof Posts) {
                    if($times > 0){
                        $times--;
                    }else {
                        if ($i < 4) {
                            $i++;

                            $post_byte = $sql_handler->get_byte_user($values->account_id);
                            $post_user = $twitch_handler->get_user_using_token($post_byte->access_token);

                            $date = explode('-', explode(' ', $values->posted)[0]);
                            $time = explode(':', explode(' ', $values->posted)[1]);
                            $post_time = $time[0] . ':' . $time[1] . ' on ' . $date[1] . '.' . $date[2] . '.' . $date[0];
                            echo '<hr>
                                <a href="" class="pull-left">
                                    <img src="' . $post_user->logo . '" class="img-circle" alt="User Image" width="42" height="42" href="user.php?' . $post_user->name . '" />
                                </a>
                                <strong>' . $post_user->display_name . '</strong>
                                <small class="pull-right">2h ago</small><br>
                                <small class="text-muted">Posted at: ' . $post_time . '</small> <br>
                                <p style="word-wrap: break-word;"> ' . $values->message . '<br></p>
                                <small class="text-muted">' . $values->likes . ' people have liked this!</small>
                                <div class="actions">
                                    <a class="btn btn-xs btn-white disabled"><i class="fa fa-thumbs-up"></i> Like </a>
                                    <a class="btn btn-xs btn-danger disabled"><i class="fa fa-heart"></i> Comment</a>
                                </div>';
                        } else if ($i == 4) {
                            echo '<div id="more_posts' . ($_GET['times']/4) . '"><br><input id="showmore' . ($_GET['times']/4) . '" type="button" value="Show More" class="btn btn-primary btn-block m" /></div>
                                <script>
                                    var times = <? print $_GET[\'times\']; ?>;

                                    $(function() {
                                        $(\'#showmore\' + (times/4)).click(function() {
                                            $(\'#more_posts\' + (times/4)).load("/presets/profiles/ShowMore.php?times=" + (times + 4));
                                        });
                                    });
                                </script>';
                            $i++;
                        }
                    }
                }
            }
        } else {

        }
    }
}