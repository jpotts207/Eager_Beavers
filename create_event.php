<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 26/07/2018
 * Time: 6:55 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

//open up database
$db = new DatabaseContext();

//get current user Id
$id = $_SESSION["Authenticated"];
$user = $db->getUser($id);

$from = $_GET["from"];
$to = $_GET["to"];
$eventName = $_GET["eventName"];
$time = $_GET["time"];
$location = $_GET["location"];

//get selected friends
$friends = array();
$groups = array();
if(isset($_GET["friend"])) {
    $friends = $_GET["friend"];
}
//get selected groups
if(isset($_GET["group"])) {
    $groups = $_GET["group"];
}

echo $groups[0];

$event = new Event();
$event->setTitle($eventName);
$event->setFromDate($from);
$event->setToDate($to);
$event->setTime($time);
$event->setLocation($location);

$eventId = $db->addEvent($event, $id);

//add the attendees to the event
$event = $db->getEvent($eventId);
foreach($friends as $friend){
    $event->addAttendee($friend);
    //notify attendee
}
foreach($groups as $group){
    $event->addGroup($group);
    //notify group members
}
$db->updateEvent($event);

//add event to the user's list
$user->addEvent($eventId);
$db->updateUser($user);

//add event to the friends/groups

header("location: index.php?page=events");

?>

