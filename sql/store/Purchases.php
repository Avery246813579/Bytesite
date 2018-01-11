<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 6/21/2015
 * Time: 5:59 PM
 */

class Purchases {
    public $purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id;

    public function __construct($purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id){
        $this->purchase_id = $purchase_id;
        $this->account_id = $account_id;
        $this->item_bought = $item_bought;
        $this->cost = $cost;
        $this->time = $time;
        $this->email = $email;
        $this->paypal_id = $paypal_id;
    }
}