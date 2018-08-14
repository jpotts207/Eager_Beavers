<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 14/08/2018
 * Time: 7:19 PM
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
$eventId = $_GET["eventid"];

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

$event = $db->getEvent($eventId);
$event->setTitle($eventName);
$event->setFromDate($from);
$event->setToDate($to);
$event->setTime($time);
$event->setLocation($location);
$event->setRsvp($rsvp);
$event->setToTime($totime);
//$event->addInvitee($id);


foreach($friends as $friend){
    $event->addAttendee($friend);
    $event->addInvitee($friend);

    //notify attendee
    $selectedFriend = $db->getUser($friend);
    $selectedFriend->addInvite($eventId);
    $db->updateUser($selectedFriend);

    //we need to make sure this friend isn't already invited before sending notification
    $alreadyAttendingFriends = $event->getAttendees(User::AS_USER_IDS);
    $alreadyAttending = false;
    foreach($alreadyAttendingFriends as $attendingFriend){
        if($friend == $attendingFriend){
            $alreadyAttending = true;
        }
    }

    if(!$alreadyAttending){
        //Mailer::sendEventNotification($selectedFriend, $event);
    }
}

foreach($groups as $group){
    $event->addGroup($group);
    //add members of group to invitee list
    $selectedGroup = $db->getGroup($group);
    $members = $selectedGroup->getMembers(User::AS_USER_IDS);

    //we need to make sure this group isn't already invited before sending notification to it's members
    $alreadyAttendingGroups = $event->getAttendees(Group::AS_GROUP_IDS);
    $alreadyAttending = false;
    foreach($alreadyAttendingGroups as $attendingFriend){
        if($group == $attendingGroup){
            $alreadyAttending = true;
        }
    }

    if(!$alreadyAttending){
        foreach($members as $member){
            $event->addInvitee($member);

            //notify group member
            $selectedMember = $db->getUser($member);
            $selectedMember->addInvite($eventId);
            $db->updateUser($selectedMember);
            //Mailer::sendEventNotification($selectedMember, $event);
        }
    }
}

$db->updateEvent($event);

//add event to the user's list
$user->addEvent($eventId);
$user->addInvite($eventId);
$db->updateUser($user);

header("location: index.php?page=events");
?>