<?php

namespace Model;

class Record extends ActiveRecord {

    protected static $table = 'records';
    protected static $columnsDB = ['id', 'package_id', 'pay_id', 'token', 'user_id', 'gift_id'];

    public $id;
    public $package_id;
    public $pay_id;
    PUBLIC $token;
    public $user_id;
    public $gift_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->package_id = $args['package_id'] ?? '';
        $this->pay_id = $args['pay_id'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->gift_id = $args['gift_id'] ?? 1; // 1 by default, can`t use null
    }
}