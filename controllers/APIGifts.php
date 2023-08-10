<?php 

namespace Controllers;

use Model\EventsSchedules;
use Model\Gift;
use Model\Record;

Class APIGifts {
    public static function index() {
        if(!is_admin()) {
            echo json_encode([]);
            return;
        }

        $gifts = Gift::all();
        
        foreach($gifts as $gift) {
            $gift->total =  Record::totalArray(['gift_id' =>$gift->id, 'package_id' => "1"]);
        }

        echo json_encode($gifts);
        return;
    }
} 