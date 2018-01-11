<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/24/2015
 * Time: 1:37 PM
 */

class Requests {
    public $request_id, $requester_id, $requested_id;

    public function __construct($request_id, $requester_id, $requested_id){
        $this->request_id = $request_id;
        $this->requester_id = $requester_id;
        $this->requested_id = $requested_id;
    }
}