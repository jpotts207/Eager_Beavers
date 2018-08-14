<?php
/**
 * Created by PhpStorm.
 * User: e_duc
 * Date: 5/08/2018
 * Time: 12:06 PM
 */
spl_autoload_extensions(".php");
spl_autoload_register();
$db = new DatabaseContext();
$e = $_REQUEST["event"];
$type = $_REQUEST["type"];


$event = $db->getEvent($e);

switch($type){
    case "invitees":
        echo json_encode($event->getInvitees(user::AS_USERS));
        break;
    case "confirmed":
        echo json_encode($event->getConfirmedAttendees(user::AS_USERS));
        break;
    case "not":
        echo json_encode($event->getNonAttending(user::AS_USERS));
        break;
}


?>