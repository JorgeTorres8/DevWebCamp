<?php 

namespace Model;

use Model\ActiveRecord;

class RegisteredEvents extends ActiveRecord {
    protected static $table = 'registered_events';
    protected static $columnsDB = ['id', 'event_id', 'record_id'];
    
    public $id;
    public $event_id;
    public $record_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->event_id = $args['event_id'] ?? '';
        $this->record_id = $args['record_id'] ?? '';
    }
}