<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 14/08/2018
 * Time: 6:54 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

//open up database
$db = new DatabaseContext();

//get current user Id
$id = $_SESSION["Authenticated"];
$user = $db->getUser($id);

//get request
$status = $_REQUEST["status"];
$eventId = $_REQUEST["event"];

$event = $db->getEvent($eventId);

switch($status){
    case "confirm":
        $event->setStatus(1);
        break;
    case "cancel":
        $event->setStatus(2);
        break;
}

$db->updateEvent($event);


?>