<?php

namespace Controllers;

use Classes\Pagination;
use Model\Category;
use Model\Day;
use Model\Event;
use Model\Hour;
use Model\Speaker;
use MVC\Router;

class EventsController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location : /login');
        }
        $current_page = $_GET['page'];
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/events?page=1');
        }

        $by_page=10;
        $total = Event::total();
        $pagination = new Pagination($current_page, $by_page, $total);

        $events = Event::paginate($by_page, $pagination->offset());

        foreach($events as $event) {
            $event->category = Category::find($event->category_id);
            $event->day = Day::find($event->day_id);
            $event->hour = Hour::find($event->hour_id);
            $event->speaker = Speaker::find($event->speaker_id);
        }

        $router->render('admin/events/index', [
            'tittle' => 'Conferences and Workshops',
            'events' => $events,
            'pagination' => $pagination->pagination()
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location : /login');
        }
        $alerts = [];

        $categories = Category::all('ASC');
        $days = Day::all('ASC');
        $hours = Hour::all('ASC');

        $event = new Event;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location : /login');
            }
            $event->sync($_POST);
            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();   
                if($result) {
                    header('Location: /admin/events');
                }
            }
        }

        $router->render('admin/events/create', [
            'tittle' => 'Register Event',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'hours' => $hours,
            'event' => $event
        ]);
    }

    public static function edit(Router $router) {
        $alerts = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /admin/events');
        }
    
        $categories = Category::all('ASC');
        $days = Day::all('ASC');
        $hours = Hour::all('ASC');

        $event = Event::find($id);
        if(!$event) {
            header('Location: /admin/events');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location : /login');
            }
            $event->sync($_POST);
            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();   
                if($result) {
                    header('Location: /admin/events');
                }
            }
        }

        $router->render('admin/events/edit', [
            'tittle' => 'Edit Event',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'hours' => $hours,
            'event' => $event
        ]);
    }

    public static function delete(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location : /login');
            }

            $id = $_POST['id'];
            $event = Event::find($id);

            if(!isset($event)) {
                header('Location : /admin/events');
            }
            $result = $event->delete();
            if($result) {
                header('Location: /admin/events');
            }
        }
    }

}