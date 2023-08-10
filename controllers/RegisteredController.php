<?php

namespace Controllers;

use Model\User;
use MVC\Router;
use Model\Record;
use Model\Package;
use Classes\Pagination;

class RegisteredController {

    public static function index(Router $router) { 

        if(!is_admin()) {
            header('Location: /login');
        }

        $current_page = filter_var($_GET['page'], FILTER_VALIDATE_INT);
        
        if(!$current_page || $current_page < 1 ) {
            header('Location: /admin/registered?page=1');
        }

        $records_by_pages = 10;
        $total = Record::total();
        $pagination = new Pagination($current_page, $records_by_pages, $total);

        if($pagination->total_pages() < $current_page) {
            header('Location: /admin/speakers?page=1');
        }

        $registered = Record::paginate($records_by_pages, $pagination->offset()); 
        foreach($registered as $record) {
            $record->user = User::find($record->user_id);
            $record->package = Package::find($record->package_id);
        }
       // debug($record);
        $router->render('admin/registered/index', [
            'tittle' => 'Registered Users',
            'registered' => $registered,
            'pagination' => $pagination->pagination()
        ]);
    }

}