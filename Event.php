<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 24/06/2018
 * Time: 10:11 AM
 */
class Event
{
    const AS_EVENTS = 1;
    const AS_PROPERTY = 2;
    const AS_EVENT_IDS = 3;

    protected $Id;
    protected $title;
    protected $location;
    protected $attendees;

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

    /**
     * @return array of User Ids
     */
    public function getAttendees($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $attendeeArray = array();
                $this->members = explode(",",$this->members);

                foreach($this->attendees as $attendee){
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

    /**
     * @param $id
     * id = the id of a User
     */
    public function addAttendee($id){
        $this->attendees = $this->attendees.",".$id;
    }

    /**
     * NEED TO WORK ON THIS.
     */
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

}
?>