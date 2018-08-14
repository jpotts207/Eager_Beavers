<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 15/07/2018
 * Time: 2:58 PM
 */

//sesession_start();
spl_autoload_extensions(".php");
spl_autoload_register();

$email = $_REQUEST["email"];
$id = $_REQUEST["user"];
$db = new DatabaseContext();
$friend = $db->findUser($email);
$friendId = $friend->getId();

$user = $db->getUser($id);

$user->addFriend($friendId);

$db->updateUser($user);

echo json_encode($friend);




