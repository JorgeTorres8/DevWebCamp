<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController {
    public static function login(Router $router) {

        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $user = new User($_POST);

            $alerts = $user->validateLogin();
            
            if(empty($alerts)) {
                // Verify that the user exists
                $user = User::where('email', $user->email);
                if(!$user || !$user->confirm ) {
                    User::setAlert('error', 'The user does not exist or is not confirmed');
                } else {
                    // The user exists
                    if( password_verify($_POST['password'], $user->password) ) {
                        
                        // Log in
                        session_start();    
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['lastname'] = $user->lastname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;

                        //Redirect
                        if($user->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /finish-registration');
                        }
                    } else {
                        User::setAlert('error', 'Incorrect Password');
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Render to the vew 
        $router->render('auth/login', [
            'tittle' => 'Log In',
            'alerts' => $alerts
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
       
    }

    public static function signup(Router $router) {
        $alerts = [];
        $user = new User;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->sync($_POST);
            
            $alerts = $user->validateAccount();

            if(empty($alerts)) {
                $existsUser = User::where('email', $user->email);

                if($existsUser) {
                    User::setAlert('error', 'User is already registered');
                    $alerts = User::getAlerts();
                } else {
                    // Hash password
                    $user->hashPassword();

                    // Delete password2
                    unset($user->password2);

                    // Generate Token
                    $user->createToken();

                    // Create a new user
                    $result =  $user->save();

                    // send email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();
                    

                    if($result) {
                        header('Location: /message');
                    }
                }
            }
        }

        // Render to the vew
        $router->render('auth/signup', [
            'tittle' => 'Create your account on DevWebcamp',
            'user' => $user, 
            'alerts' => $alerts
        ]);
    }

    public static function forgot(Router $router) {
        $alerts = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail();

            if(empty($alerts)) {
                // Search user
                $user = User::where('email', $user->email);

                if($user && $user->confirm) {

                    // Generate a new token
                    $user->createToken();
                    unset($user->password2);

                    // Update the user
                    $user->save();

                    // send the email
                    $email = new Email( $user->email, $user->name, $user->token );
                    $email->sendInstructions();


                    // print alert
                    // User::setAlert('success', 'We have sent the instructions to your email');

                    $alerts['success'][] = 'We have sent the instructions to your email';
                } else {
                 
                    // User::setAlert('error', 'The User does not exist or is not confirmed');

                    $alerts['error'][] = 'The User does not exist or is not confirmed';
                }
            }
        }

        // show the vew
        $router->render('auth/forgot', [
            'tittle' => 'I Forgot my password',
            'alerts' => $alerts
        ]);
    }

    public static function reset(Router $router) {

        $token = s($_GET['token']);

        $valid_token = true;

        if(!$token) header('Location: /');

        // Identify the user with this token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', 'Invalid Token, try again');
            $valid_token = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //  Add the new password
            $user->sync($_POST);

            // Validate the password
            $alerts = $user->validatePassword();

            if(empty($alerts)) {
                // Hash new password
                $user->hashPassword();

                // Delete the Token
                $user->token = null;

                // Save the user in the DB
                $result = $user->save();

                // Redirect
                if($result) {
                    header('Location: /login');
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Show the vew
        $router->render('auth/reset', [
            'tittle' => 'Reset Password',
            'alerts' => $alerts,
            'valid_token' => $valid_token
        ]);
    }

    public static function message(Router $router) {

        $router->render('auth/message', [
            'tittle' => 'Account Created Successfully'
        ]);
    }

    public static function confirm(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        //  Find the User with this token
        $user = User::where('token', $token);

        if(empty($user)) {
            // No user found with that token
            User::setAlert('error', 'Invalid Token, the account is not confirmed');
        } else {
            // confirm account  
            $user->confirm = 1;
            $user->token = '';
            unset($user->password2);
            
            // Save to DB
            $user->save();

            User::setAlert('success', 'Correctly Verified Account');
        }

     

        $router->render('auth/confirm', [
            'tittle' => 'Confirm your DevWebcamp account',
            'alerts' => User::getAlerts()
        ]);
    }
}