<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 3/07/2018
 * Time: 7:11 PM
 */

spl_autoload_extensions(".php");
spl_autoload_register();

$authenticated = false;
$user = new User();
$friends = array();

$id;
if(isset($_SESSION["Authenticated"])){
    if($_SESSION["Authenticated"] != false){
        $authenticated = true;
        $id = $_SESSION["Authenticated"];
        $user = $db->getUser($id);
        $friends  = $user->getFriends(User::AS_USERS);
    }
    else{
        $authenticated = false;
    }
}
?>
<div class="jumbotron">
    <h1>Friends</h1>
    <form action="search_friend.php" method="post">
        <div class="form-group">
            <label for="search">Find Friend (via email)</label>
            <input name="search" id="search" type="text" size ="50"/>
            <button type="submit">Search</button>
        </div>
    </form>
</div>
<?php
echo '<div id="container" class="row-md-2 form-group">';


foreach($friends as $friend) {
    if($friend) {
        echo '<form>',
         '<div class="panel panel-default">',
             '<p> email: ' . $friend->getEmail() . '</p>',
             '<p> First Name : ' . $friend->getFirstName() . '</p>',
             '<p> Surname : ' . $friend->getSecondName() . '</p>',
             '<a href="remove_friend.php?id='.$friend->getId().'" class="btn btn-danger">Remove</a>',
         '</div>',
         '</form>';
    }
    else{
        echo "<p>You have no friends. :_(</p>";
    }
}
?>