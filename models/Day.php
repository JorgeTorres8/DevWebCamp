<?php 

namespace Model;

use Model\ActiveRecord;

class Day extends ActiveRecord {
    protected static $table = 'days';
    protected static $columnsDB = ['id', 'name'];
    
    public $id;
    public $name;
}