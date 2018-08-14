<?php
/**
 * Created by PhpStorm.
 * User: e_duc
 * Date: 22/07/2018
 * Time: 3:03 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

//open up database
$db = new DatabaseContext();

$id = $_SESSION["Authenticated"];
$groupId = $_REQUEST["group"];

$user = $db->getUser($id);
$user->removeGroup($groupId);
$db->updateUser($user);

$db->deleteGroup($groupId);
