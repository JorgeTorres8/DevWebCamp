<?php

namespace Controllers;

use Model\Day;
use Model\Hour;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;

class PagesController {
    public static function index(Router $router) {

        $events = Event::order('hour_id', 'ASC');
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

        $total_speakers = Speaker::total();
        $total_conferences = Event::total('category_id', 1);
        $total_workshops = Event::total('category_id', 2);

        $speakers = Speaker::all();

        $router->render('pages/index', [
            'tittle' => 'Start',
            'events' => $formatted_events,
            'total_speakers' => $total_speakers,
            'total_conferences' => $total_conferences,
            'total_workshops' => $total_workshops,
            'speakers' => $speakers
        ]);
    }

    public static function event(Router $router) {
        $router->render('pages/devwebcamp', [
            'tittle' => 'About DevWebCamp'
        ]);
    }

    public static function packages(Router $router) {
        $router->render('pages/packages', [
            'tittle' => 'DevWebCamp Packages'
        ]);
    }

    public static function conferences(Router $router) {

        $events = Event::order('hour_id', 'ASC');
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

        $router->render('pages/conferences', [
            'tittle' => 'Conferences & Workshops',
            'events' => $formatted_events
        ]);
    }

    public static function error(Router $router) {
        $router->render('pages/error', [
            'tittle' => 'Page not found'
        ]);
    }
}