<?php

class Byte_Users {
    public $user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements;

    public function __construct($user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements){
        $this->user_id = $user_id;
        $this->account_id = $account_id;
        $this->access_token = $access_token;
        $this->sub_date = $sub_date;
        $this->donation_amount = $donation_amount;
        $this->points = $points;
        $this->rank_id = $rank_id;
        $this->inventory = $inventory;
        $this->active_items = $active_items;
        $this->xp = $xp;
        $this->achievements = $achievements;
    }
}