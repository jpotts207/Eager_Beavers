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
            $groups = $user->getGroups(Group::AS_GROUPS);
            $friends = $user->getFriends(User::AS_USERS);
            $friendsJSON = json_encode($friends);
            $friendsJSON = str_replace('"', '\'', $friendsJSON);
        }
        else{

        }
    }else{

    }

    if(!$authenticated){
       // die("You are not logged in, and can't access this page");
        header("location: index.php");
    }
?>

<div class="panel panel-default">
    <div class="panel-body">
        <h1>Groups</h1>
        <h5>View all active groups of friends, you may click on a group for further options.</h5>
    </div>
</div>

<?php
echo '<div class="beaverList">',
        '<div class="row" >',
            '<div class="col-sm-8" style="border-right : 1px solid black; border-radius : 0px;">';
                foreach($groups as $group){
                    $groupJSON = json_encode($group);
                    $groupJSON = str_replace('"', '\'', $groupJSON);
                    if($group){
                        echo '<div class="listpanel" data-toggle="modal" data-target="#editGroupModal" 
                            data-group="'.$groupJSON.'">
                                <div class="row" 
                                style="margin : 5%; 
                                background-color : whitesmoke; 
                                border: 1px solid black">',

                        ' <div class="col-sm-3">',
                                    '<img src="images/users.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                '</div>',
                                '<div class="col-sm-9">',
                                    '<h2>' . $group->getName().'</h2>';
                                    $members = $group->getMembers(User::AS_USERS);
                                    echo '<p>Members</p>',
                                        '<p>';
                                    $firstdone = false;
                                    foreach($members as $member) {
                                        if($firstdone){
                                            echo ',';
                                        }
                                        echo $member->getFirstName() . ' ' . $member->getSecondName();
                                        $firstdone = true;
                                    }
                                    echo '</p>';
                                echo '</div> ',
                        '</div></div>';
                    }
                }
            echo '</div>',
            '<div class="col-sm-4" style="height : 100%;cursor : pointer;" data-toggle="modal" data-target="#addGroupModal">',
                '<div class="addButton">',
                    '<h1><span class="glyphicon glyphicon-plus"></span></h1>Add Group',
                '</div>',
            '</div>',
        '</div>',
     '</div>';
?>
<!-- Modals -->
<div id="addGroupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="create_group.php" method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Group Name: <input type="text" id="name" name="groupname"/></h3>
            </div>
                    <div class="modal-body">
                        <?php
                            foreach($friends as $friend) {
                                if ($friend) {
                                echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                                        '<div class="col-sm-4">',
                                            '<img src="images/users.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                        '</div>',

                                        '<div class="col-sm-6">',
                                            '<p>' . $friend->getFirstName() . ' '. $friend->getSecondName() .'</p>',
                                            '<p>' . $friend->getEmail().'</p>',
                                        '</div>',
                                        '<div class="col-sm-2">',
                                         '<input name="friend[]" value="'.$friend->getId().'" type="checkbox" style="margin-top : 80%">',
                                        '</div>',
                                '</div>';
                                } else {
                                    echo "<p>You have no friends. :_(</p>";
                                }
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Create</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div id="editGroupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="edit_group.php" method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><input id="groupName" name="groupName" type="text"/></h3>
                <p>Check/Uncheck the boxes to edit friends in this group.  Should you wish to remove someone, simply uncheck the relevant box.</p>
                <button id="deleteGroupButton" class="btn btn-danger" >Delete Group</button>
            </div>

                <div class="modal-body">
                    <?php
                    echo '<input id="groupId" name="groupId" style="visibility: hidden" />';
                    foreach($friends as $friend) {
                        if ($friend) {
                            echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                            '<div class="col-sm-4">',
                            '<img src="images/user.png" alt="user_image"  style="padding : 10%; height : 80%; width: 80%;">',
                            '</div>',

                            '<div class="col-sm-6">',
                                '<p>' . $friend->getFirstName() . ' '. $friend->getSecondName() .'</p>',
                                '<p>' . $friend->getEmail().'</p>',
                            '</div>',
                            '<div class="col-sm-2">',
                                '<input name="friend[]" id="User'.$friend->getId().'" value="'.$friend->getId().'" type="checkbox" style="margin-top : 80%">',
                            '</div>',
                            '</div>';
                        } else {
                            echo "<p>You have no friends. :_(</p>";
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Update</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        $("#editGroupModal").on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var group = button.data("group");
            var modal = $(this);
            group = group.replace(/'/g, "\"");
            group = JSON.parse(group);
            var friends = group.members;
            var friendsArray = friends.split(",");

            //modal.find(".modal-title").text(group.name);
            modal.find("#groupName").val(group.name);
            modal.find("#groupId").val(group.Id);

            //reset checkboxes
            var checkboxes = new Array();
            checkboxes = document.getElementsByTagName("input");
            for(var i=0; i < checkboxes.length; i++){
                checkboxes[i].checked = false;
            }

            //check all members in the group
            friendsArray.forEach(function(entry){
                var inputId = "User"+entry;
                document.getElementById(inputId).checked = true;
            });
        });

        $("#deleteGroupButton").click(function(){
            var group = $("#groupId").val();
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    window.location.href = "index.php?page=groups";
                }
            };
            xmlhttp.open("GET", "delete_group.php?group=" + group, true);
            xmlhttp.send();
        });

    });

</script>
