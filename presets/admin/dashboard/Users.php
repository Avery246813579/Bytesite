<?php
require_once(dirname(__FILE__) . '/../../../SqlHandler.php');
$sql_handler = new SqlHandler();
$users = $sql_handler->get_byte_users();
echo '<span class="info-box-number">' . count($users) . '</span>';
