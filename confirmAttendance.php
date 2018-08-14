<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 5/08/2018
 * Time: 2:28 PM
 */
spl_autoload_extensions(".php");
spl_autoload_register();
$db = new DatabaseContext();

$eventId = $_REQUEST["event"];
$userId = $_REQUEST["user"];
$type = $_REQUEST["type"];

$event = $db->getEvent($eventId);
$user = $db->getUser($userId);

switch($type){
    case "confirm":
        $event->removeNonAttendee($userId);
        $event->addConfirmedAttendee($userId);
        $db->updateEvent($event);
        echo "confirm";
        break;
    case "decline":
        $event->removeConfirmedAttendee($userId);
        $event->addNotAttending($userId);
        $db->updateEvent($event);
        echo "decline";
        break;
}




