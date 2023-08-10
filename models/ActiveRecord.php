<?php
namespace Model;
class ActiveRecord {

    public $id;

    // Data Base
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

    // Alerts and Messages
    protected static $alerts = [];
    
    // Define the connection to the DB - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Set a type of Alert
    public static function setAlert($type, $message) {
        static::$alerts[$type][] = $message;
    }

    // Get the alerts
    public static function getAlerts() {
        return static::$alerts;
    }

    //Validation inheriting in models (Validación que se hereda en modelos)
    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // SQL query to create an object in Memory (Active Record)
    public static function querySQL($query) {
        // Query the database
        $result = self::$db->query($query);

        // Iterate the results
        $array = [];
        while($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // release memory
        $result->free();

        // return the results
        return $array;
    }

    // Creates the object in memory that is equal to the one in the database (Crea el objeto en memoria que es igual al de la BD)
    protected static function createObject($record) {
        $object = new static;

        foreach($record as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identify and join the attributes of the DB
    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitize the data before saving it to the DB
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitize = [];
        foreach($attributes as $key => $value ) {
            $sanitize[$key] = self::$db->escape_string($value);
        }
        return $sanitize;
    }

    // Synchronize DB with Objects in memory

    public function sync($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Record - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creating a new record
            $result = $this->create();
        }
        return $result;
    }

    // Get All Records
    public static function all( $order = 'DESC' ) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id ${order}";
        $result = self::querySQL($query);
        return $result;
    }

    // Search for a record by its id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = ${id}";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    //paginate the records 726
    public static function paginate($by_page, $offset) {
        $query = "SELECT * FROM " . static::$table. " ORDER BY id DESC LIMIT ${by_page} OFFSET ${offset} ";
        $result = self::querySQL($query);
        return $result;
    }

    // Get Records with certain amount  
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT ${limit} ";
        $result = self::querySQL($query);
        return $result;
    }

    // "Where" Search with Column
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Return records in order
    public static function order($column, $order) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY ${column} ${order}";
        $result = self::querySQL($query);
        return $result;
    }

    // Return by order and with limit
    public static function orderLimit($column, $order, $limit) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY ${column} ${order} LIMIT ${limit}";
        $result = self::querySQL($query);
        return $result;
    }

    // "Where" Search with Multiple choises
    public static function whereArray($array= []) {
        $query = "SELECT * FROM " . static::$table . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }

        }
        $result = self::querySQL($query);
        return $result;
    }

    //Get a total of records 
    public static function total($column = '', $value = '') {
        $query = "SELECT COUNT(*) FROM " .static::$table;
        if($column) {
            $query .= " WHERE ${column} = ${value}";
        }
        $result = self::$db->query($query); 
        $total = $result->fetch_array();
        
        return array_shift($total);
    }

    //"where "search with multiple options
    public static function totalArray($array = []) {
        $query = "SELECT COUNT(*) FROM " .static::$table . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }

        }
        $result = self::$db->query($query); 
        $total = $result->fetch_array();
        
        return array_shift($total);
    }

    // create a new record
    public function create() {
        // sanitize data
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // debug($query); // Uncomment if something doesn't work for you

        // Query Result
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    // update record
    public function update() {
        // sanitize data
        $attributes = $this->sanitizeAttributes();

        // Iterate to add each field of the database
        $values = [];
        foreach($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // Query SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Update BD
        $result = self::$db->query($query);
        return $result;
    }

    //Delete a Record by its ID
    public function delete() {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}