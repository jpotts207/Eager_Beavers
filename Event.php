<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 24/06/2018
 * Time: 10:11 AM
 */
class Event
{
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
    public function getAttendees(){
        return explode(",",$this->attendees);
    }

    /**
     * @param $id
     * id = the id of a User
     */
    public function addAttendee($id){
        $this->attendees = $this->attendees.",".$id;
    }

}
?>