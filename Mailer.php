<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 1/07/2018
 * Time: 5:13 PM
 */
require_once "Mail.php";
class Mailer
{


    public static function sendWelcome($user){
        $to = $user->getEmail();
        $subject = "Welcome to Plan !t";
        $body = "hi, \n\nWelcome to Plan !t.\n\nFrom now on you will be able to organize your schedule with\n\n
        friends, family and/or colleagues.\n\nRegards\n\n Harry Beaver";

        Mailer::send($to, $subject,  $body);
    }

    public static function sendPasswordReset($email){
        /*
         * Generate a key ( md5(username) + current hashed password)
         * email a link with key in url, so when user clicks link it
         * directs user to the page where they can reset password
         *
         * the reset page will verify the key.
         * */
        $to = $email;
        $subject = "Eager Beaver Password Reset";
        $link = "https://eagerbeavers.azurewebsites.net/password_reset.php?u=".md5($email);
        $body = "hi, \n\n".$link;

        Mailer::send($to, $subject,$body);

    }

    public static function sendEventNotification($user, $event){

    }

    public static function sendReminder($user, $event){

    }

    private function send($to, $subject, $body){
        $from = "notifications@eagerbeavers.com";
        $host = "smtp.sendgrid.net";
        $username="<username>";
        $password="<password>";
        $headers = array('From' =>$from,'To' => $to, 'Subject' =>$subject);
        $smtp = Mail::factory('smtp', array('host'=>$host, 'auth'=>true, 'username'=>$username, 'password'=> $password));
        $mail = $smtp->send($to, $headers, $body);
        if(PEAR::isError($mail)){
            echo("<p>".$mail->getMessage()."</p>");
        }else{
            echo("<p>Message successfully sent!</p>");
        }
    }
}