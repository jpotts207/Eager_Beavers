<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 10/07/2018
 * Time: 6:57 PM
 */
session_start();
spl_autoload_extensions('.php');
spl_autoload_register();


$password = ($_POST['password']);
$db = new DatabaseContext();
$user = new User();

if(isset($_SESSION["temp_user"])){
    $id = $_SESSION["temp_user"];
    $user = $db->getUser($id);
    $user->setPassword(md5($password));
    $db->updateUser($user);

    echo "<script type='text/javascript'>",
    "alert('password changed successfully');",
    "window.location = 'index.php?page=home';",
    "</script>";
}
else if(isset($_SESSION["Authenticated"])){
    $id = $_SESSION["Authenticated"];
    $user = $db->getUser($id);
    $user->setPassword(md5($password));
    $db->updateUser($user);

    echo "<script type='text/javascript'>",
    "alert('password changed successfully');",
    "window.location = 'index.php?page=home';",
    "</script>";
}
else{
    echo "something went wrong ". $id;
}
?>
