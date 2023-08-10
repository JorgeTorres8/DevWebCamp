<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIEvents;
use Controllers\APIGifts;
use Controllers\APISpeakers;
use Controllers\AuthController;
use Controllers\GiftsController;
use Controllers\PagesController;
use Controllers\EventsController;
use Controllers\SpeakersController;
use Controllers\DashboardController;
use Controllers\RecordController;
use Controllers\RegisteredController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Create Account
$router->get('/signup', [AuthController::class, 'signup']);
$router->post('/signup', [AuthController::class, 'signup']);

// Forgot my password form
$router->get('/forgot', [AuthController::class, 'forgot']);
$router->post('/forgot', [AuthController::class, 'forgot']);

// Enter the new password
$router->get('/reset', [AuthController::class, 'reset']);
$router->post('/reset', [AuthController::class, 'reset']);

// Account Confirmation
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirm']);

//Administration area
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/speakers', [SpeakersController::class, 'index']);
$router->get('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->post('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->get('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/delete', [SpeakersController::class, 'delete']);

$router->get('/admin/events', [EventsController::class, 'index']);
$router->get('/admin/events/create', [EventsController::class, 'create']);
$router->post('/admin/events/create', [EventsController::class, 'create']);
$router->get('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/delete', [EventsController::class, 'delete']);

$router->get('/api/events-schedules',[APIEvents::class, 'index']);
$router->get('/api/speakers',[APISpeakers::class, 'index']);
$router->get('/api/speaker',[APISpeakers::class, 'speaker']);
$router->get('/api/gifts',[APIGifts::class, 'index']);

$router->get('/admin/registered', [RegisteredController::class, 'index']);

$router->get('/admin/gifts', [GiftsController::class, 'index']);

//User Register 
$router->get('/finish-registration', [RecordController::class, 'create']);
$router->post('/finish-registration/free', [RecordController::class, 'free']);
$router->post('/finish-registration/pay', [RecordController::class, 'pay']);
$router->get('/finish-registration/conferences', [RecordController::class, 'conferences']);
$router->post('/finish-registration/conferences', [RecordController::class, 'conferences']);

// Virtual Ticket
$router->get('/ticket', [RecordController::class, 'ticket']);

//Public Area 
$router->get('/', [PagesController::class, 'index']);
$router->get('/devwebcamp', [PagesController::class, 'event']);
$router->get('/packages', [PagesController::class, 'packages']);
$router->get('/workshops-conferences', [PagesController::class, 'conferences']);
$router->get('/404', [PagesController::class, 'error']);

$router->checkRoutes();