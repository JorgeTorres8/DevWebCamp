<?php

namespace Model;

use Model\ActiveRecord;

class Event extends ActiveRecord {
    protected static $table = 'events';
    protected static $columnsDB = ['id', 'name', 'description', 'available', 'category_id', 'day_id', 'hour_id', 'speaker_id'];
    
    public $id;
    public $name;
    public $description;
    public $available;
    public $category_id;
    public $day_id;
    public $hour_id;
    public $speaker_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->available = $args['available'] ?? '';
        $this->category_id = $args['category_id'] ?? '';
        $this->day_id = $args['day_id'] ?? '';
        $this->hour_id = $args['hour_id'] ?? '';
        $this->speaker_id = $args['speaker_id'] ?? '';
    }

    // Validation messages for creating an event
    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Name is Required';
        }
        if(!$this->description) {
            self::$alerts['error'][] = 'Descripción is Required';
        }
        if(!$this->category_id  || !filter_var($this->category_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Choose a Category';
        }
        if(!$this->day_id  || !filter_var($this->day_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Choose the day of the event';
        }
        if(!$this->hour_id  || !filter_var($this->hour_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Choose the time of the event';
        }
        if(!$this->available  || !filter_var($this->available, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Add a number of Available Places';
        }
        if(!$this->speaker_id || !filter_var($this->speaker_id, FILTER_VALIDATE_INT) ) {
            self::$alerts['error'][] = 'Select the person in charge of the event';
        }

        return self::$alerts;
    }
}