<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 9/07/2018
 * Time: 7:13 PM
 */

session_start();
spl_autoload_extensions('.php');
spl_autoload_register();

//$redirect = "location: ";
$redirect = "location: https://eagerbeavers.azurewebsites.net/";

$email = $_POST['email'];
$password = ($_POST['password']);
$unhashed = $_POST['password'];
$name = ($_POST['name']);
$surname= ($_POST['surname']);

$db = new DatabaseContext();

//check if user exists
$new_user = $db->findUser($email);

if($new_user === false){
    //add user to database
    $new_user = new User();
    $new_user->setEmail($email);
    $new_user->setFirstName($name);
    $new_user->setSecondName($surname);
    $new_user->setPassword($password);

    $db->addUser($new_user);

    //advise user email sent and redirect to home page with click
    $_SESSION["Message"] = "New user created";
    //email user
    Mailer::sendWelcome($new_user);


}
else{
    $_SESSION["Message"] = "email already exists.";
}

header($redirect);