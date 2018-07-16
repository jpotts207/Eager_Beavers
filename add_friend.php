<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 15/07/2018
 * Time: 2:58 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

$db = new DatabaseContext();

$friendId = $_GET["id"];

$id = $_SESSION['Authenticated'];
$user = $db->getUser($id);

$user->addFriend($friendId);
$db->updateUser($user);

echo '<script type="text/javascript">',
    'alert("Friend Added");',
    'window.location.href="index.php?page=friends";',
    '</script>';