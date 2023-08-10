<?php 

namespace Model;

use Model\ActiveRecord;

class Category extends ActiveRecord {
    protected static $table = 'category';
    protected static $columnsDB = ['id', 'name'];
    
    public $id;
    public $name;

}