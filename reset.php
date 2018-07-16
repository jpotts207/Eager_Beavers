<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 10/07/2018
 * Time: 7:10 PM
 */

session_start();
spl_autoload_extensions('.php');
spl_autoload_register();

$email= $_POST['email'];
Mailer::sendPasswordReset($email);
header("location: index.php");
?>