<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $name;
    public $token;
    
    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('cuentas@devwebcamp.com');
         $mail->addAddress($this->email, $this->name);
         $mail->Subject = 'Confirm your Account';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $content = '<html>';
         $content .= "<p><strong>Hello " . $this->name .  "</strong> You have Successfully Registered your account in DevWebCamp; but you need to confirm it</p>";
         $content .= "<p>Press here: <a href='" . $_ENV['HOST'] . "/confirm-account?token=" . $this->token . "'>Confirm Account</a>";       
         $content .= "<p>If you did not create this account; you can ignore the message</p>";
         $content .= '</html>';
         $mail->Body = $content;

         //send email
         $mail->send();

    }

    public function sendInstructions() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('accounts@devwebcamp.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Reset your password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hello " . $this->name .  "</strong> You have requested to reset your password, follow the link below to do so.</p>";
        $content .= "<p>Press here: <a href='" . $_ENV['HOST'] . "/reset?token=" . $this->token . "'>Reset Password</a>";        
        $content .= "<p>If you did not request this change, you can ignore the message</p>";
        $content .= '</html>';
        $mail->Body = $content;

        //send email
        $mail->send();
    }
}