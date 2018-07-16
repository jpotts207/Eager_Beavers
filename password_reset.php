<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 10/07/2018
 * Time: 6:22 PM
 */
session_start();
spl_autoload_extensions('.php');
spl_autoload_register();
$redirect = "location: index.php?page=home";

$email = $_GET["u"];
$password = $_GET["p"];

echo $email." ".$password;
$db = new DatabaseContext();
$users = $db->getUsers();
$registered_user = new User();

//iterate through all user accounts until we find matching emails.
foreach($users as $user){
    if($email === md5($user->getEmail())){
        $registered_user = $user;
    }
}

if($registered_user !== false) {
    $_SESSION["temp_user"] = $registered_user->getId();
    header("location: index.php?page=change_password");
}else{
    header($redirect);
}
?>