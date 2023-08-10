<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Model\Speaker;
use Intervention\Image\ImageManagerStatic as Image;

class SpeakersController {

    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $current_page = filter_var($_GET['page'], FILTER_VALIDATE_INT); //Pagination

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/speakers?page=1');
        }

        $records_by_pages = 10;
        $total = Speaker::total(); 
        $pagination = new Pagination($current_page, $records_by_pages, $total);

        if($pagination->total_pages() < $current_page) {
            header('Location: /admin/speakers?page=1');
        }

        $speakers = Speaker::paginate($records_by_pages, $pagination->offset());

        $router->render('admin/speakers/index', [
            'tittle' => 'Conference Speakers',
            'speakers' => $speakers,
            'pagination' => $pagination->pagination()
        ]);
    }

    public static function create(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alerts = [];
        $speaker = new Speaker;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
        //read img

            if(!empty($_FILES['image']['tmp_name'])) {
                $image_folder = '../public/img/speakers';
            
                
                if(!is_dir($image_folder)) {
                    mkdir($image_folder, 0755, true);
                }

                $png_image = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $webp_image = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $image_name = md5(uniqid(rand(), true));

                $_POST['image'] = $image_name;

            }
            
            $_POST['networks'] = json_encode($_POST['networks'], JSON_UNESCAPED_SLASHES);

            $speaker->sync($_POST);

            $alerts = $speaker->validate();

            if(empty($alerts)) { 
                
                $png_image->save($image_folder . '/' . $image_name . '.png');
                $webp_image->save($image_folder . '/' . $image_name . '.webp');
            
                $result = $speaker->save();
                
                if($result) {
                    header('Location: /admin/speakers');
                }
            }
            
        }

        $router->render('admin/speakers/create', [
            'tittle' => 'Register Speaker',
            'alerts' => $alerts,
            'speaker' => $speaker ,
            'networks' => json_decode($speaker->networks) 
        ]);
    }

    public static function edit(Router $router) { 

        if(!is_admin()) {
            header('Location: /login');
        }

        $alerts = [];

        //Validate Id;
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT); 

        if(!$id) {
            header('Location: /admin/speakers');
        }

        $speaker = Speaker::find($id);

        if(!$speaker) {
            header('Location: /admin/speakers');
        }

        $speaker->current_image = $speaker->image; 

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if(!is_admin()) {
                header('Location: /login');
            }

            if(!empty($_FILES['image']['tmp_name'])) { 
                $image_folder = '../public/img/speakers';
            
                if(!is_dir($image_folder)) {
                    mkdir($image_folder, 0755, true);
                }

                $png_image = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $webp_image = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $image_name = md5(uniqid(rand(), true));

                $_POST['image'] = $image_name;

            } else { 
                $_POST['image'] = $speaker->current_image;
            }

            $_POST['networks'] = json_encode($_POST['networks'], JSON_UNESCAPED_SLASHES);
            $speaker->sync($_POST);

            $alerts = $speaker->validate();

            if(empty($alerts)) {
                if(isset($image_name)) {
                    $png_image->save($image_folder . '/' . $image_name . '.png');
                    $webp_image->save($image_folder . '/' . $image_name . '.webp');
                }

                $result = $speaker->save();

                if($result) {
                    header('Location: /admin/speakers');
                }
            }
        }

        $router->render('admin/speakers/edit', [
            'tittle' => 'Edit Speaker',
            'alerts' => $alerts,
            'speaker' => $speaker,
            'networks' => json_decode($speaker->networks)
        ]);
    }
    
    public static function delete(Router $router) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $speaker = Speaker::find($id);
            
            if(!isset($speaker)){
                header('Location: /admin/speakers');
            }

            $result = $speaker->delete();

            if($result) {
                header('Location: /admin/speakers');
            }
        }
    }
}