<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/15/2015
 * Time: 8:01 PM
 */

class Follows {
    public $_total, $next_link, $self_link, $follows;

    public function __construct($_total, $_links, $follows){
        $this->_total = $_total;
        $this->next_link = $_links['next'];
        $this->self_link = $_links['self'];

        if (is_array($follows)) {
            $follow_list = array();

            foreach ($follows as $value) {
                require_once(dirname(__FILE__) . '/Follow.php');
                array_push($follow_list, new Follow($value['created_at'], $value['_links'], $value['notifications'], $value['user']));
            }

            $this->follows = $follow_list;
        } else {
            $this->follows = $follows;
        }

    }
}