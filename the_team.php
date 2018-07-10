<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 21/06/2018
 * Time: 10:22 PM
 */


?>
<div class="container">
    <h1>Hello Beavers </h1>
    <h4>Here are the group members, taken from my SQL database in the cloud</h4>
    <p>The Following are some sample groups and their members</p>
    <?php
    $groups = $db->getGroups();
    echo "<dl>";
    foreach($groups as $group){
        echo "<dt>".$group->getName()."</dt>";

        foreach($group->getMembers(User::AS_USERS) as $member){
            if($member) {
                echo "<dd>- " . $member->getFirstName() . " " . $member->getSecondName() . "</dd>";
            }
        }
    }
    echo "</dl>";

    $daniel = $db->getUser(1);
    $danielsGroups = $daniel->getGroups(User::AS_USERS);

    echo "<dl>";
    echo "<dt>".$daniel->getFirstName(). " ".$daniel->getSecondName();
    foreach($danielsGroups as $group){
        echo "<dd>-".$group->getName()."</dd>";
    }

    //Mailer::sendPasswordReset($daniel);

    ?>
    <input type="button"  value="Open Context" onclick="openContext()" />
</div>
