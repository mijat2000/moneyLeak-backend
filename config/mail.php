<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require '../vendor/autoload.php';

class customMail
{

    private function createPhpMailer()
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '';         //SMTP username
        $mail->Password   = '';                   //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;
        return $mail;
    }

    public function sendRegistrationEmail($email, $hash,)
    {
        $link = 'http://localhost/moneyLeak/api/validateEmail.php?code=' . $hash;
        try {
            //Setup for PhpMailer
            $mail = $this->createPhpMailer();

            $mail->addAddress($email);
            $mail->isHTML(true);

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Account verification';
            $mail->Body    = "Please click on following link to verify your account: <br><a href=$link>$link</a>";


            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendForgottenPassword($email, $hash)
    {
        $link = 'http://localhost/moneyLeak/api/updatePassword.php?code=' . $hash;
        try {
            //Setup for PhpMailer
            $mail = $this->createPhpMailer();

            $mail->addAddress($email);
            $mail->isHTML(true);

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Forgotten Password';
            $mail->Body    = "Restart your password: <br><a href=$link>$link</a>";


            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
