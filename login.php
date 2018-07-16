<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 28/06/2018
 * Time: 8:26 PM
 */
//make sure we're using the session on this page
session_start();

//make sure all pages are available (for use of classes)
spl_autoload_extensions('.php');
spl_autoload_register();

//get username and password
$username = $_POST['username'];
$password = md5($_POST['password']);

//open up the database
$db = new DatabaseContext();

//get the user from the database and create an instance of a User.
$user = $db->authenticateUser($username, $password);

//if no user was found the result will be false
if($user !== false) {
    //record the id of the user in the "Authenticated" session variable
    // ('authenticated_user' would be better)
    $_SESSION["Authenticated"] = $user->getId();
    echo '<script type="text/javascript">',
    'alert("logged in Successfully.");',        //notify the user that they've logged in successfully
    'window.location("index.php?page=home")',   //redirct to home
    '</script>';
}else{
    $_SESSION["Authenticated"] = false;         //set authenticated to false for use on other pages
    echo '<script type="text/javascript">',
        'alert("login failed.\nCheck email and password.");',   //notify user of failure
        'window.location("index.php?page=home")',               //redirect to home
        '</script>';
}
