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

if(!$authenticated){
    // die("You are not logged in, and can't access this page");
    header("location: index.php");
}

?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h1>Friends</h1>
        </div>
    </div>
<?php
echo '<div class="beaverList">',
    '<div class="row" >',
        '<div class="col-sm-8" style="border-right : 1px solid black; border-radius : 0px;">';
            foreach($friends as $friend) {
                if ($friend) {
                    echo '<div>
                        <div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                            '<div class="col-sm-3">',
                                '<img src="images/user.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;">',
                            '</div>',

                            '<div class="col-sm-9">',
                                '<p>Name : ' . $friend->getFirstName() . ' '.$friend->getSecondName().'</p>',
                                '<p>email: ' . $friend->getEmail() . '</p>',
                                '<a class="btn btn-danger" href="remove_friend.php?id='.$friend->getId().'">Unfriend</a>',
                            '</div>',
                        '</div>',
                    '</div>';
                } else {
                    echo "<p>You have no friends. :_(</p>";
                }
            }
        echo '</div>',
        '<div class="col-sm-4" style="height : 100%;cursor : pointer;" data-toggle="modal" data-target="#addFriendModal">',
            '<div class="addButton">',
                '<h1><span class="glyphicon glyphicon-plus"></span></h1>Add Friend',
            '</div>',
        '</div>',
    '</div>',
'</div>';


?>
<!-- Modals -->
<div id="addFriendModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="search_friend.php" method="post">
                    <div class="form-group">
                        <label for="search">Find Friend (via email)</label>
                        <input name="search" id="search" type="text" size ="50"/>
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="submit" class="btn btn-default">Add</button>-->
            </div>
        </div>
    </div>
</div>

<!--edit friend-->
<div id="editFriendModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="edit_friend.php" method="get">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
