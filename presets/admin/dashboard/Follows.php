<?php
require_once(dirname(__FILE__) . '/../../../twitch/TwitchHandler.php');
require_once(dirname(__FILE__) . '/../../../SqlHandler.php');
$twitch_handler = new TwitchHandler();
$sql_handler = new SqlHandler();

$follows = $twitch_handler->get_follows($sql_handler->get_property('CHANNEL')->value);
echo '<span class="info-box-number">' . $follows->_total . '</span>';
