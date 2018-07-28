<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 22/07/2018
 * Time: 1:42 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

//open up database
$db = new DatabaseContext();
$groupId = $_GET["groupId"];
$id = $_SESSION["Authenticated"];
$user = $db->getUser($id);
$friends = $_GET["friend"];

$group = new Group();
$group = $db->getGroup($groupId);
$group->resetMembers();
foreach($friends as $friend){
    $group->addMember($friend);
}

$db->updateGroup($group);

header("location: index.php?page=groups");
