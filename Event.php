<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 24/06/2018
 * Time: 10:11 AM
 */
class Event implements \JsonSerializable
{
    const AS_EVENTS = 1;
    const AS_PROPERTY = 2;
    const AS_EVENT_IDS = 3;

    const PENDING = 0;
    const CONFIRMED = 1;
    const CANCELLED = 2;

    protected $Id;
    protected $title;
    protected $location;
    protected $attendees;
    protected $time;
    protected $from_date;
    protected $to_date;
    protected $groups;
    protected $to_time;
    protected $rsvp;
    protected $status;
    protected $confirmed_attendees;
    protected $invitees;
    protected $not_attending;

    public function getId(){
        return $this->Id;
    }
    public function setId($value){
        $this->Id = $value;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($value){
        $this->title = $value;
    }
    public function getLocation(){
        return $this->location;
    }
    public function setLocation($value){
        $this->location = $value;
    }
    public function getTime(){
    return $this->time;
}
    public function setTime($value){
        $this->time = $value;
    }
    public function getToTime(){
        return $this->to_time;
    }
    public function setToTime($value){
        $this->to_time = $value;
    }
    public function getFromDate(){
        return $this->from_date;
    }
    public function setFromDate($value){
        $this->from_date = $value;
    }
    public function getToDate(){
        return $this->to_date;
    }
    public function setToDate($value){
        $this->to_date = $value;
    }
    public function getRsvp(){
        return $this->rsvp;
    }
    public function setRsvp($value){
        $this->rsvp = $value;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($value){
        $this->status = $value;
    }

    /**
     * @return array of User Ids
     */
    public function getAttendees($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $attendeeArray = array();
                $attendees = explode(",",$this->attendees);

                foreach($attendees as $attendee){
                    $membersArray[] = $db->getUser($attendee);
                }
                return $attendeeArray;
                break;
            case User::AS_PROPERTY:
                return $this->attendees;
                break;
            case User::AS_USER_IDS:
                return explode(",",$this->attendees);
                break;
        }
    }
    public function getGroups($value){
        switch($value){
            case Group::AS_GROUPS:
                $db = new DatabaseContext();
                $groupArray = array();
                $groups = explode(",", $this->groups);
                foreach($groups as $group){
                    $groupArray[] = $db->getGroup($group);
                }
                return $groupArray;
            break;
            case Group::AS_PROPERTY:
                return $this->groups;
                break;
            case Group::AS_GROUP_IDS:
                return explode(",", $this->groups);
        }
    }
    public function getConfirmedAttendees($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $attendeeArray = array();
                $attendees = explode(",",$this->confirmed_attendees);

                foreach($attendees as $attendee){
                    $attendeeArray[] = $db->getUser($attendee);
                }
                return $attendeeArray;
                break;
            case User::AS_PROPERTY:
                return $this->confirmed_attendees;
                break;
            case User::AS_USER_IDS:
                return explode(",",$this->confirmed_attendees);
                break;
        }
    }
    public function getInvitees($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $inviteeArray = array();
                $invitees = explode(",",$this->invitees);

                foreach($invitees as $invitee){
                    $inviteeArray[] = $db->getUser($invitee);
                }
                return $inviteeArray;
                break;
            case User::AS_PROPERTY:
                return $this->invitees;
                break;
            case User::AS_USER_IDS:
                return explode(",",$this->invitees);
                break;
        }
    }
    public function getNonAttending($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $inviteeArray = array();
                $invitees = explode(",",$this->not_attending);

                foreach($invitees as $invitee){
                    $inviteeArray[] = $db->getUser($invitee);
                }
                return $inviteeArray;
                break;
            case User::AS_PROPERTY:
                return $this->not_attending;
                break;
            case User::AS_USER_IDS:
                return explode(",",$this->not_attending);
                break;
        }
    }

    /**
     * @param $id
     * id = the id of a User
     */
    public function addAttendee($id){
    $attendees =  $this->getAttendees(User::AS_USER_IDS);
    $exists = false;
    foreach($attendees as $attendee){
        if($id === $attendee){
            $exists = true;
        }
    }
    if(!$exists){
        if($attendees[0] === ""){
            $this->attendees = $this->attendees. $id;
        }
        else{
            $this->attendees = $this->attendees.",".$id;
        }
    }
}
    public function addConfirmedAttendee($id){
        $attendees =  $this->getConfirmedAttendees(User::AS_USER_IDS);
        $exists = false;
        foreach($attendees as $attendee){
            if($id === $attendee){
                $exists = true;
            }
        }
        if(!$exists){
            if($attendees[0] === ""){
                $this->confirmed_attendees = $this->confirmed_attendees. $id;
            }
            else{
                $this->confirmed_attendees = $this->confirmed_attendees.",".$id;
            }
        }
    }
    public function addInvitee($id){
        $invitees =  $this->getInvitees(User::AS_USER_IDS);
        $exists = false;
        foreach($invitees as $invitee){
            if($id === $invitee){
                $exists = true;
            }
        }
        if(!$exists){
            if($invitees[0] === ""){
                $this->invitees = $this->invitees. $id;
            }
            else{
                $this->invitees = $this->invitees.",".$id;
            }
        }
    }
    public function addNotAttending($id){
        $notAtt =  $this->getNonAttending(User::AS_USER_IDS);
        $exists = false;
        foreach($notAtt as $n){
            if($id === $n){
                $exists = true;
            }
        }
        if(!$exists){
            if($notAtt[0] === ""){
                $this->not_attending = $this->not_attending. $id;
            }
            else{
                $this->not_attending = $this->not_attending.",".$id;
            }
        }
    }

    public function addGroup($id){
        $groups =  $this->getGroups(Group::AS_GROUP_IDS);
        $exists = false;
        foreach($groups as $group){
            if($id === $group){
                $exists = true;
            }
        }
        if(!$exists){
            if($groups[0] === ""){
                $this->groups = $this->groups. $id;
            }
            else{
                $this->groups = $this->groups.",".$id;
            }
        }
    }


    public function removeAttendee($id){
        $a = $this->getAttendees(User::AS_USER_IDS);
        $temp_a = '';
        $firstEntree = true;
        foreach($a as $t_a){
            if($t_a != $id) {
                if($firstEntree){
                    $temp_a = $t_a;
                    $firstEntree = false;
                }else {
                    $temp_a = $temp_a . "," . $t_a;
                }
            }
        }
        $this->attendees = $temp_a;
    }
    public function removeConfirmedAttendee($id){
        $a = $this->getConfirmedAttendees(User::AS_USER_IDS);
        $temp_a = '';
        $firstEntree = true;
        foreach($a as $t_a){
            if($t_a != $id) {
                if($firstEntree){
                    $temp_a = $t_a;
                    $firstEntree = false;
                }else {
                    $temp_a = $temp_a . "," . $t_a;
                }
            }
        }
        $this->confirmed_attendees = $temp_a;
    }
    public function removeNonAttendee($id){
        $a = $this->getNonAttending(User::AS_USER_IDS);
        $temp_a = '';
        $firstEntree = true;
        foreach($a as $t_a){
            if($t_a != $id) {
                if($firstEntree){
                    $temp_a = $t_a;
                    $firstEntree = false;
                }else {
                    $temp_a = $temp_a . "," . $t_a;
                }
            }
        }
        if($temp_a == ''){
            $temp_a = null;
        }
        $this->not_attending = $temp_a;
    }
    public function removeGroup($id){
        $a = $this->getGroups(Group::AS_GROUP_IDS);
        $temp_a = '';
        $firstEntree = true;
        foreach($a as $t_a){
            if($t_a != $id) {
                if($firstEntree){
                    $temp_a = $t_a;
                    $firstEntree = false;
                }else {
                    $temp_a = $temp_a . "," . $t_a;
                }
            }
        }
        $this->groups = $temp_a;
    }
    public function isAttending($id){
        //just returns true if friend already in list, false otherwise
        $isAttending = false;
        $attendees = $this->getConfirmedAttendees(User::AS_USER_IDS);
        foreach($attendees as $friend){
            if($friend === $id){
                $isAttending = true;
            }
        }
        return $isAttending;
    }
    public function isNotAttending($id){
        //just returns true if friend already in list, false otherwise
        $isNotAttending = false;
        $nA = $this->getNonAttending(User::AS_USER_IDS);
        foreach($nA as $a){
            if($a === $id){
                $isNotAttending = true;
            }
        }
        return $isNotAttending;
    }

    public function resetFriendsGroups(){
        $this->attendees='';
        $this->groups='';
    }
    public function jsonSerialize(){
        $vars = get_object_vars($this);
        return $vars;
    }

}
?>