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
                        <label for="search">Find Friend (via email)</label>
                        <input name="search" id="search" type="text" size ="50"/>
                        <button type="buttn" class="btn btn-default" onclick="findFriend()">Search</button>
                <div>
                    <h4 id="title"></h4>
                </div>
                <div>
                    <p id="email"></p>
                    <p id="name"></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" style="visibility : hidden">
                    <?php echo '<button type="button" class="btn btn-success" onclick="addFriend('.$id.')">Add</button>';?>
                    <button type="button" class="btn btn-danger" onclick="gotoFriends()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="friendAddedModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="gotoHome()">&times;</button>
                <h4 class="modal-title">Friend Added</h4>
            </div>
            <div class="modal-body">
                <p id="confirm"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="gotoFriends()">Ok</button>
            </div>
        </div>
    </div>
</div>

<script>
    function findFriend(){
        var email = $("#search").val();
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var friend = JSON.parse(this.responseText);
                if (!friend){
                    $(".btn-group").css("visibility", "hidden");
                    document.getElementById("email").innerText = "";
                    document.getElementById("name").innerText = "";
                    document.getElementById("title").innerText="No user could be found with that email";
                }else{
                    $(".btn-group").css("visibility", "visible");
                    document.getElementById("title").innerText = "We found the following user with that email:";
                    document.getElementById("email").innerText = friend.email;
                    var full_name = friend.first_name + " " + friend.second_name;
                    document.getElementById("name").innerText = full_name;
                }
            }
        };
        xmlhttp.open("GET", "search_friend.php?email=" + email, true);
        xmlhttp.send();
    }

    function addFriend(userId){
        var email = $("#search").val();
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var friend = JSON.parse(this.responseText);
                $("#addFriendModal").modal("toggle");
                $("#friendAddedModal").modal("toggle");
                $("#friendAddedModal").modal().find("#confirm").text("We will notify " + friend.first_name + " that they have a new friend! awww");
            }
        };
        xmlhttp.open("GET", "add_friend.php?email=" + email + "&user=" + userId, false);
        xmlhttp.send();
    }

</script>
