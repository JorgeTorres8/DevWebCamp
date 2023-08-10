<?php

namespace Controllers;

use Model\Event;
use Model\User;
use MVC\Router;
use Model\Record;

class DashboardController {

    public static function index(Router $router) {

        // Get last records
        $records = Record::get(5);
        foreach($records as $record) {
            $record->user = User::find($record->user_id);
        }

        //Calculate the revenue 
        $virtual =  Record::total('package_id', 2);
        $inperson =  Record::total('package_id', 1);

        $revenue = ($virtual * 46.41) + ($inperson * 189.54);

        //get events with less and more places available
        $fewer_available = Event::orderLimit('available', 'ASC', 5); 
        $more_available = Event::orderLimit('available', 'DESC', 5); 


        $router->render('admin/dashboard/index', [
            'tittle' => 'Administration Panel',
            'records' => $records,
            'revenue' => $revenue,
            'fewer_available' => $fewer_available,
            'more_available' => $more_available
        ]);
    }

}