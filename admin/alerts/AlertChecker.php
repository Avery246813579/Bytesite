<?php
require_once(dirname(__FILE__) . '/../../SqlHandler.php');
require_once(dirname(__FILE__) . '/../../twitch/TwitchHandler.php');
$sql_handler = new SqlHandler();
$twitch_handler = new TwitchHandler();

$alerts = $sql_handler->get_alerts();

/** Alert Types
 *
 * 0 - Follow
 * 1 - Donation
 * 2 - Host
 * 3 - Subscription
 *
 *  */
if (is_array($alerts)) {
    if (count($alerts) > 0) {
        $alert = $alerts[0];

        if ($alert instanceof Alerts) {
            if($alert->alert_type == 0){
                $follow_image = $sql_handler->get_property('FOLLOW_IMAGE');
                echo "$('#loading').html('<img src=\"/Follow/" . $follow_image->value . "\"> <p>" . $alert->alert_content . "</p>').fadeIn();";
            }

            if($alert->alert_type == 1){
                $donation_image = $sql_handler->get_property('DONATION_IMAGE');
                echo "$('#loading').html('<img src=\"/Donation/" . $donation_image->value . "\"> <p>" . $alert->alert_content . "</p>').fadeIn();";
            }

            if($alert->alert_type == 2){
                $host_image = $sql_handler->get_property('HOST_IMAGE');
                echo "$('#loading').html('<img src=\"/Host/" . $host_image->value . "\"> <p>" . $alert->alert_content . "</p>').fadeIn();";
            }

            if($alert->alert_type == 3){
                $sub_image = $sql_handler->get_property('SUB_IMAGE');
                echo "$('#loading').html('<img src=\"/Sub/" . $sub_image->value . "\"> <p>" . $alert->alert_content . "</p>').fadeIn();";
            }

            $sql_handler->delete_alert($alert);
        }
    }
}
