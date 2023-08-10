<?php

namespace Model;

use Model\ActiveRecord;

class Hour extends ActiveRecord {
    protected static $table = 'hours';
    protected static $columnsDB = ['id', 'hour'];
    
    public $id;
    public $hour;
}