<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 28/06/2018
 * Time: 8:26 PM
 */
session_start();
spl_autoload_extensions('.php');
spl_autoload_register();

$redirect = "location: ";

$username = $_POST['username'];
$password = md5($_POST['password']);

$db = new DatabaseContext();
$user = $db->authenticateUser($username, $password);

if($user !== false) {
    $_SESSION["Authenticated"] = $user->getId();
    header($redirect);
}else{
    $_SESSION["Authenticated"] = false;
    header($redirect);
}
