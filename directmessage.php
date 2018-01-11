<!-- DIRECT CHAT -->
<div class="col-md-6">
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Direct Chat</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="3 New Messages" class='badge bg-yellow'>3</span>
                <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
            </div>
        </div>
        <!-- /.box-header -->

        <?php

        if (isset($_COOKIE['USER'])) {

            echo '<div class="box-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">';
            $name = $_COOKIE['USER'];
            $account = $sql_handler->get_account($name);
            $instants = $sql_handler->get_instants($account->account_id);
            $user = $twitch_handler->get_user_using_token($account->access_token);

            if(is_array($instants)) {
                foreach ($instants as $values) {
                    if ($values instanceof Instants) {
                        $account_user = $sql_handler->get_account_using_id($values->account_id);
                        $user = $twitch_handler->get_user_using_token($account_user->access_token);

                        $date_split = explode('-', explode(' ', $values->sent)[0]);
                        $time_split = explode(':', explode(' ', $values->sent)[1]);

                        $side = "";
                        $opposite = "right";
                        $pull_side = "left";

                        if ($values->account_id == $account->account_id) {
                            $side = "right";
                            $opposite = "left";
                            $pull_side = "right";
                        }

                        echo '<div class="direct-chat-msg ' . $side . '">
                                    <div class="direct-chat-info clearfix">

                                        <span class="direct-chat-name pull-' . $pull_side . '">' . $user->display_name . '</span>
                                        <span class="direct-chat-timestamp pull-' . $opposite . '">' . $date_split[0]. ' ' . date('M', mktime(0, 0, 0, $date_split[1], 10)) . ' ' . $time_split[0] . ':' . $time_split[1] . '</span>
                                    </div><!-- /.direct-chat-info -->
                                    <img class="direct-chat-img" src="' . $user->logo . '" width="128" height="128" alt="message user image" /><!-- /.direct-chat-img -->
                                    <div class="direct-chat-text">
                                    ' . $values->message . '
                                    </div><!-- /.direct-chat-text -->
                                </div>';
                    }
                }
            }

            echo '
                            </div><!--/.direct-chat-messages-->


                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                                <ul class="contacts-list">
                                    <li>
                                        <a href="#">
                                            <img class="contacts-list-img" src="dist/img/user1-128x128.jpg"/>
                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Count Dracula
                                  <small class="contacts-list-date pull-right">2/28/2015</small>
                                </span>
                                                <span class="contacts-list-msg">How have you been? I was...</span>
                                            </div><!-- /.contacts-list-info -->
                                        </a>
                                    </li><!-- End Contact Item -->
                                    <li>
                                        <a href="#">
                                            <img class="contacts-list-img" src="dist/img/user7-128x128.jpg"/>
                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Sarah Doe
                                  <small class="contacts-list-date pull-right">2/23/2015</small>
                                </span>
                                                <span class="contacts-list-msg">I will be waiting for...</span>
                                            </div><!-- /.contacts-list-info -->
                                        </a>
                                    </li><!-- End Contact Item -->
                                </ul><!-- /.contatcts-list -->
                            </div><!-- /.direct-chat-pane -->
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="text" name="message" placeholder="Type Message ..." class="form-control"/>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                                </div>
                            </form>
                        </div><!-- /.box-footer-->
                    </div><!--/.direct-chat -->
                </div><!-- /.col -->';
        }
        ?>
