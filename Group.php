<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 24/06/2018
 * Time: 10:19 AM
 */
class Group
{
    protected $Id;
    protected $name;
    protected $members;

    public function getId(){
        return $this->Id;
    }
    public function setId($value){
        $this->Id = $value;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($value){
        $this->name= $value;
    }

    /**
     * @return array of User Ids
     */
    public function getMembers(){
        $db = new DatabaseContext();
        $membersArray = array();
        $this->members = explode(",",$this->members);

        foreach($this->members as $member){
            $membersArray[] = $db->getUser($member);
        }
        return $membersArray;
    }

    /**
     * @param $id
     * id = the id of a User
     */
    public function addMember($id){
        $this->members = $this->members.",".$id;
    }

}
?>