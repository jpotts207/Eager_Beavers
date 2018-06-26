<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 16/06/2018
 * Time: 8:22 PM
 */
class User
{
    protected $Id;
    protected $first_name;
    protected $second_name;
    protected $email;
    protected $password;
    protected $friends;
    protected $groups;

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
    public function getGroups(){
        $groups = explode(",", $this->groups);
        $groupArray = array();
        $db = new DatabaseContext();

        foreach($groups as $group){
            $groupArray[] = $db->getGroup($group);
        }
        return $groupArray;
    }

    /**
     * @return array of Users - the friends of the user
     */
    public function getFriends(){
        $friends = explode(',', $this->friends);
        $friendArray = array();
        $db = new DatabaseContext();

        foreach($friends as $friend) {
            $friendArray[] = $db->getPerson($friend);
        }
        return $friendArray;
    }

    public function addFriend($id){
        //friends are stored in the database as comma seperated list
        //eg "2,5,16".  Each number is the Id of another User.
        //So we just need to append the end of the friends with "," + $id
        $this->friends = $this->friends.",".$id;
    }

 }