<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 15/07/2018
 * Time: 2:05 PM
 */

spl_autoload_extensions(".php");
spl_autoload_register();

$email = $_REQUEST["email"];
$db = new DatabaseContext();
$friend = $db->findUser($email);
$friend = json_encode($friend);

echo $friend;

