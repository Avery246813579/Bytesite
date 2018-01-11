<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/22/2015
 * Time: 8:17 PM
 */

class Accounts {
    public $account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation;

    public function __construct($account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation){
        $this->account_id = $account_id;
        $this->username = $username;
        $this->date_created = $date_created;
        $this->last_log = $last_log;
        $this->rank_id = $rank_id;
        $this->online = $online;
        $this->reputation = $reputation;
    }
}