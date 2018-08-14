<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 16/06/2018
 * Time: 8:22 PM
 */
class User implements \JsonSerializable
{
    /*constants for the getFriends(), getGroups(), getEvents() functions.
     * The constant determines whether we're to return User objects, User Ids, or
     *  the property with the list of users as comma separated list.
     */
    const AS_USERS = 1;
    const AS_PROPERTY = 2;
    const AS_USER_IDS = 3;

    //properties
    protected $Id;
    protected $first_name;
    protected $second_name;
    protected $email;
    protected $password;
    protected $friends;
    protected $groups;
    protected $events;
    protected $invites;

    public function getId(){
        return $this->Id;
    }
    public function setId($value){
        $this->Id = $value;
    }

    public function getFirstName(){
        return $this->first_name;
    }
    public function setFirstName($name){
        $this->first_name = $name;
    }
    public function getSecondName(){
        return $this->second_name;
    }
    public function setSecondName($name){
        $this->second_name = $name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($value){
        $this->email = $value;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($value){
        $this->password = $value;
    }

    public function getGroups($value){
        switch($value){
            case Group::AS_GROUPS:
                $groups = explode(",", $this->groups);
                $groupArray = array();
                $db = new DatabaseContext();

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
                break;
        }
    }
    public function getFriends($value){
        switch($value){
            case User::AS_USERS:
                $friends = explode(',', $this->friends);
                $friendArray = array();
                $db = new DatabaseContext();

                foreach($friends as $friend) {
                    $friendArray[] = $db->getUser($friend);
                }
                return $friendArray;
                break;
            case User::AS_PROPERTY:
                return $this->friends;
                break;
            case User::AS_USER_IDS:
                return explode(',', $this->friends);
                break;
        }
    }
    public function isFriend($id){
        //just returns true if friend already in list, false otherwise
        $isFriend = false;
        $friends = $this->getFriends(User::AS_USER_IDS);
        foreach($friends as $friend){
            if($friend === $id){
                $isFriend = true;
            }
        }
        return $isFriend;
    }
    public function getEvents($value){
        switch($value){
            case Event::AS_EVENTS:
                $events = explode(",", $this->events);
                $eventArray = array();
                $db = new DatabaseContext();

                foreach($events as $event){
                    $eventArray[] = $db->getEvent($event);
                }
                return $eventArray;
                break;
            case Event::AS_PROPERTY:
                return $this->events;
                break;
            case Event::AS_EVENT_IDS:
                return explode(",", $this->events);
                break;
        }
    }
    public function getInvites($value){
        switch($value){
            case Event::AS_EVENTS:
                $invites = explode(",", $this->invites);
                $invitesArray = array();
                $db = new DatabaseContext();

                foreach($invites as $invite){
                    $invitesArray[] = $db->getEvent($invite);
                }
                return $invitesArray;
                break;
            case Event::AS_PROPERTY:
                return $this->invites;
                break;
            case Event::AS_EVENT_IDS:
                return explode(",", $this->invites);
                break;
        }
    }

    //friends are stored in the database as comma separated list
    //eg "2,5,16".  Each number is the Id of another User.
    //So we just need to append the end of the friends with "," + $id
    public function addFriend($id){
        if ($this->isFriend($id) || $id == $this->getId()){
            //prevent adding yourself as friend or someone who is already a friend
        }else {
            $friends = $this->getFriends(User::AS_USER_IDS);
            $exists = false;
            foreach ($friends as $friend) {
                if ($id === $friend) {
                    $exists = true;
                }
            }
            if (!$exists) {
                if ($friends[0] === "") {
                    $this->friends = $this->friends . $id;
                } else {
                    $this->friends = $this->friends . "," . $id;
                }
            }
        }
    }
    public function addGroup($id){
        $groups = $this->getGroups(Group::AS_GROUP_IDS);
        $exists = false;
        foreach($groups as $group){
            if($id === $group){
                $exists = true;
            }
        }
        if(!$exists){
            if($groups[0] === ""){
                $this->groups = $this->groups.$id;
            }
            else{
                $this->groups = $this->groups.",".$id;
            }
        }

    }
    public function addEvent($id){
        $events = $this->getEvents(Event::AS_EVENT_IDS);
        $exists = false;
        foreach($events as $event){
            if($id === $event){
                $exists = true;
            }
        }
        if(!$exists){
            if($events[0] === ""){
                $this->events = $this->events.$id;
            }
            else{
                $this->events = $this->events.",".$id;
            }
        }
    }
    public function addInvite($id){
        $invites = $this->getInvites(Event::AS_EVENT_IDS);
        $exists = false;
        foreach($invites as $invite){
            if($id === $invite){
                $exists = true;
            }
        }
        if(!$exists){
            if($invites[0] === ""){
                $this->invites = $this->invites.$id;
            }
            else{
                $this->invites = $this->invites.",".$id;
            }
        }
    }

    public function removeFriend($id){
        $a = $this->getFriends(User::AS_USER_IDS);
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
        $this->friends = $temp_a;
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


    public function removeFromGroup($id){
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

    public function removeFromEvent($id){
        $a = $this->getEvents(Event::AS_EVENT_IDS);
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
        $this->events = $temp_a;
    }
    public function jsonSerialize(){
        $vars = get_object_vars($this);
        return $vars;
    }

 }