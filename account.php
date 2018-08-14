<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 9/07/2018
 * Time: 8:47 PM
 */

spl_autoload_extensions(".php");
spl_autoload_register();

$authenticated = false;
$user = new User();
$id;
if(isset($_SESSION["Authenticated"])){
    if($_SESSION["Authenticated"] != false){
        $authenticated = true;
        $id = $_SESSION["Authenticated"];
        $user = $db->getUser($id);
    }
    else{
        $authenticated = false;
    }
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1>Account</h1>
    </div>
</div>
<div  style="margin : 5%; background-color : whitesmoke; border: 1px solid black;">
    <?php

        echo '<div id="container" class="beaverList">';
        echo '<p> email: '. $user->getEmail($id).'</p>';
        echo '<p> First Name : '. $user->getFirstName($id).'</p>';
        echo '<p> Surname : '. $user->getSecondName($id).'</p>';
    ?>
    <a href="?page=change_password"><button class="btn btn-default">Change Password</button></a>
</div>