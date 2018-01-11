<?php

class Subscriptions{
    public $_total, $self_link, $next_link, $subscriptions;

    public function __construct($_total, $_links, $subscriptions){
        $this->_total = $_total;
        $this->self_link = $_links['self'];
        $this->next_link = $_links['next'];
        $this->subscriptions = $subscriptions;
    }
}