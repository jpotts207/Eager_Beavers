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
$rsvp = $_GET["rsvp"];
$totime = $_GET["totime"];

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


$event = new Event();
$event->setTitle($eventName);
$event->setFromDate($from);
$event->setToDate($to);
$event->setTime($time);
$event->setLocation($location);
$event->setRsvp($rsvp);
$event->setToTime($totime);
$event->addInvitee($id);

$eventId = $db->addEvent($event, $id);

//add the attendees to the event
$event = $db->getEvent($eventId);
foreach($friends as $friend){
    $event->addAttendee($friend);
    $event->addInvitee($friend);

    //notify attendee
    $selectedFriend = $db->getUser($friend);
    $selectedFriend->addInvite($eventId);
    $db->updateUser($selectedFriend);
    Mailer::sendEventNotification($selectedFriend, $event);
}


foreach($groups as $group){
    $event->addGroup($group);
    //add members of group to invitee list
    $selectedGroup = $db->getGroup($group);
    $members = $selectedGroup->getMembers(User::AS_USER_IDS);
    foreach($members as $member){
        $event->addInvitee($member);

        //notify group member
        $selectedMember = $db->getUser($member);
        $selectedMember->addInvite($eventId);
        $db->updateUser($selectedMember);
        Mailer::sendEventNotification($selectedMember, $event);
    }
}

$db->updateEvent($event);

//add event to the user's list
$user->addEvent($eventId);
$user->addInvite($eventId);
$db->updateUser($user);

//add event to the friends/groups

header("location: index.php?page=events");

?>

