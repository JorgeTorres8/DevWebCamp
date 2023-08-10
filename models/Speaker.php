<?php

namespace Model;

class Speaker extends ActiveRecord { //708

    protected static $table = 'speakers';
    protected static $columnsDB = ['id', 'name', 'lastname', 'city', 'country', 'image', 'tags', 'networks'];
    
    public $id;
    public $name;
    public $lastname;
    public $city;
    public $country;
    public $image;
    PUBLIC $tags;
    public $networks;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->city = $args['city'] ?? '';
        $this->country = $args['country'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->networks = $args['networks'] ?? '';
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Name is Required';
        }
        if(!$this->lastname) {
            self::$alerts['error'][] = 'Lastname is Required';
        }
        if(!$this->city) {
            self::$alerts['error'][] = 'The City Field is Required';
        }
        if(!$this->country) {
            self::$alerts['error'][] = 'The Country Field is Required';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'Image is required';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'The tags field is required';
        }
    
        return self::$alerts;
    }
}