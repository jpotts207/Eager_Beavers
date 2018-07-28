<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 19/07/2018
 * Time: 8:33 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

//open up database
$db = new DatabaseContext();

//get group name from form
$name = $_GET["groupname"];
//get user id
$id = $_SESSION["Authenticated"];
//create instance of user
$user = $db->getUser($id);

//get selected friends
$friends = $_GET['friend'];

//create a new instacne of group
$group = new Group();
//set the groups name
$group->setName($name);
//add the group to the database
$groupId = $db->addGroup($group, $id);

$group = $db->getGroup($groupId);
foreach($friends as $friend) {
    $group->addMember($friend);
}
$db->updateGroup($group);

//add the group to the user's list
$user->addGroup($groupId);
//update the user on the database
$db->updateuser($user);


header("location: index.php?page=groups");

?>

