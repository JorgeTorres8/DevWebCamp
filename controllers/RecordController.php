<?php

namespace Controllers;

use Model\Day;
use Model\Hour;
use Model\User;
use MVC\Router;
use Model\Event;
use Model\Record;
use Model\Package;
use Model\Speaker;
use Model\Category;
use Classes\Pagination;
use Model\Gift;
use Model\RegisteredEvents;

class RecordController {
    public static function create(Router $router) {
        
        if(!is_auth()) {
            header('Location: /');
            return;
        }

        //check if the user is already registered
        $registered = Record::where('user_id', $_SESSION['id']);
        
        if(isset($registered) && ($registered->package_id === "3" || $registered->package_id === "2")) {
            header('Location: /ticket?id=' . urlencode($registered->token));
            return;
        }
        
        if(isset($registered) && $registered->package_id === "1") {
            header('Location: /finish-registration/conferences');
            return;
        }

        $router->render('record/create', [
            'tittle' => 'Finish Registration'
        ]);
    }

    public static function free(Router $router) {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            //check if the user is already registered
            $registered = Record::where('user_id', $_SESSION['id']);
            
            if(isset($registered) && $registered->package_id === "3") {
                header('Location: /ticket?id=' . urlencode($registered->token));
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Create record
            $data = [
                'package_id' => 3,
                'pay_id' => '',
                'token' => $token,
                'user_id' => $_SESSION['id']
            ];

            $registration = new Record($data);
            $result = $registration->save();

            if($result) {
                header('Location: /ticket?id=' . urlencode($registration->token)); //urlencode para evitar caracteres especiales
                return;
            }
        }
    }

    public static function ticket(Router $router) { 
        
        // Validate URL

        $id = $_GET['id'];

        if(!$id || !strlen($id) === 8) {
            header('Location: /');
            return;
        }

        //look up the token in the DB
        $registration = Record::where('token', $id);
        if(!$registration) {
            header('Location: /');
            return;
        }

        //Fill in the reference tables
        $registration->user = User::find($registration->user_id);
        $registration->package = Package::find($registration->package_id);

        
        $router->render('record/ticket', [
            'tittle' => 'DevWebCamp Assistance',
            'registration' => $registration 
        ]);
    }

    public static function pay(Router $router) { 
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            //Create record
            $data = $_POST;
            $data['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $data['user_id'] = $_SESSION['id'];

            try {
                $registration = new Record($data);
                $result = $registration->save();
                echo json_encode($result);
            } catch (\Throwable $th) {
                echo json_encode([
                    'result' => 'eror'
                ]);
            }
        }
    }

    public static function conferences(Router $router) { 
        
        if(!is_auth()) {
            header('Location: /login');
            return;
        }

        //Validate that the user has the in-person plan
        $user_id = $_SESSION['id'];
        $record =  Record::where('user_id', $user_id);
        $recordFinished = RegisteredEvents::where('record_id', $record->id);

        if(isset($record) && $record->package_id === "2") { //Virtual Pass
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }

        //Redirect to virtual ticket in case the user has completed their registration
        if(isset($recordFinished)) {
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }

        if($record->package_id !== "1") {
            header('Location: /');
            return;
        }

        $events = Event::order('hour_id', 'ASC'); //From PagesController
        $formatted_events = [];

        foreach($events as $event) {
            $event->category = Category::find($event->category_id);
            $event->day = Day::find($event->day_id);
            $event->hour = Hour::find($event->hour_id);
            $event->speaker = Speaker::find($event->speaker_id);

            if($event->day_id === '1' && $event->category_id === '1') {
                $formatted_events['f_conferences'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '1') {
                $formatted_events['s_conferences'][] = $event;
            }

            if($event->day_id === '1' && $event->category_id === '2') {
                $formatted_events['f_workshops'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '2') {
                $formatted_events['s_workshops'][] = $event;
            }
        }

        $gifts = Gift::all('ASC');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_auth()) {
                header('Location: /');
                return;
            }

            $events = explode(',', $_POST['events']);
            if(empty($events)) {
                echo json_encode(['result' => false]);
                return;
            }

            //get user record
            $record = Record::where('user_id', $_SESSION['id']);
            if(!isset($record) || $record->package_id !== "1") {
                echo json_encode(['result' => false]);
                return;
            }

            $events_array = [];

            //Validate the availability of the selected events
            foreach($events as $event_id){
                $event = Event::find($event_id);

                //check if event exists
                if(!isset($event) || $event->available === "0") {
                    echo json_encode(['result' => false]);
                    return;
                }
                $events_array[] = $event; 
                //debug($events_array);
                //$event->available -= 1; //OJO POR FALTA DE TIEMPO... SE TIENE QUE HACER EN DB (TRANSACCCIONES)
            }

            foreach($events_array as $event) { 
                $event->available -= 1;
                $event->save();

                //Store record
                $data = [
                    'event_id' => (int) $event->id,
                    'record_id' => (int) $record->id
                ];

                $record_user = new RegisteredEvents($data);
                $record_user->save();
            }
            //Store Gift

            $record->sync(['gift_id' => $_POST['gift_id']]);
            $result = $record->save();

            if($result) {
                echo json_encode([
                    'result' => $result,
                    'token' => $record->token
                ]);
            } else { 
                echo json_encode(['result' => false]);
            }

            return;
        }
        
        $router->render('record/conferences', [
            'tittle' => 'Choose Workshops and Conferences',
            'events' => $formatted_events,
            'gifts' => $gifts
        ]);
    }
}