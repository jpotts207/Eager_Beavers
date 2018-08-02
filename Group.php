<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 24/06/2018
 * Time: 10:19 AM
 */
class Group implements \JsonSerializable
{
    const AS_GROUPS = 1;
    const AS_PROPERTY = 2;
    const AS_GROUP_IDS = 3;

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
     * @return array of Users
     */
    public function getMembers($value){
        switch($value){
            case User::AS_USERS:
                $db = new DatabaseContext();
                $membersArray = array();
                $members = explode(",", $this->members);

                foreach($members as $member){
                    $membersArray[] = $db->getUser($member);
                }
                return $membersArray;
                break;
            case User::AS_PROPERTY:
                return $this->members;
                break;
            case User::AS_USER_IDS:
                return explode(",", $this->members);
        }
    }

    public function addMember($id){
        $members =  $this->getMembers(User::AS_USER_IDS);
        $exists = false;
        foreach($members as $member){
            if($id === $member){
                $exists = true;
            }
        }
        if(!$exists){
            if($members[0] === ""){
                $this->members = $this->members. $id;
            }
            else{
                $this->members = $this->members.",".$id;
            }
        }
    }

    public function removeMember($id){
        $a = $this->getMembers(User::AS_USER_IDS);
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
        $this->members = $temp_a;
    }

    public function resetMembers(){
        $this->members = "";
    }

    public function jsonSerialize(){
        $vars = get_object_vars($this);
        return $vars;
    }

}
?>