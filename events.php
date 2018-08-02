<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 3/07/2018
 * Time: 7:10 PM
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
        $friends  = $user->getFriends(User::AS_USERS);
        $groups = $user->getGroups(Group::AS_GROUPS);
        $events = $user->getEvents(Event::AS_EVENTS);
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
        <h1>Events</h1>
        <p>Here you can create and modify events that you've created.</p>
        <p>To see events that you are invited to or attending, view <a href="#">Invites</a></p>
    </div>
</div>
<div class="beaverList">
    <div class="row">
        <div class="col-sm-8" style="border-right : 1px solid black; border-radius : 0px;">
        <?php
            foreach($events as $event){
                $eventJSON = json_encode($event);
                $eventJSON = str_replace('"', '\'', $eventJSON);
                if($event) {
                    echo '<div class="listpanel" data-toggle="modal" data-target="#editEventModal" 
                            data-event="'.$eventJSON.'">
                            <div class="row" 
                            style="margin: 5%; 
                            background-color : whitesmoke; 
                            border: 1px solid black">',

                            '<div class="col-sm-3">',
                                '<img src="images/event.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;"/>',
                            '</div>',

                            '<div class="col-sm-9">',
                                '<div class="row">',
                                    '<div class="col-sm-6">',
                                        '<p>' . $event->getTitle() . '</p>';
                                        switch($event->getStatus()){
                                            case Event::PENDING:
                                                echo '<p>Status : <span class="label label-primary">Pending</span></p>';
                                                break;
                                            case Event::CONFIRMED:
                                                echo '<p>Status : <span class="label label-success">Confirmed</span></p>';
                                                break;
                                            case EVENT::CANCELLED:
                                                echo '<p>Status : <span class="label label-danger">Cancelled</span></p>';
                                                break;
                                            default:
                                                break;
                                        }
                                        echo '<p>RSVP : '.$event->getRsvp();
                                    echo '</div>',
                                    '<div class="col-sm-6">',
                                        '<p>Date : ' . $event->getFromDate() . '</p>',
                                        '<p>Time : ' . substr($event->getTime(),0, 5) . '</p>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                    '</div>';
                }else{
                }
            }
        ?>
        </div>
        <div class="col-sm-4" style="height : 100%;cursor : pointer;" data-toggle="modal" data-target="#addEventModal">
            <div class="addButton">
                <h1><span class="glyphicon glyphicon-plus"></span></h1>Add Event
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="addEventModal" class="modal fade" role="dialog">;
    <div class="modal-dialog" style="width : 70%;">
        <!-- Modal content-->
        <form class="form-inline" action="create_event.php" method="get" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <div class="form-group">
                        <label for="eventName">Event Name:</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" required>
                    </div>
                    <div class="form-group">
                        <label for="from">Date:</label>
                        <input type="date" class="form-control" id="from" name="from" required><span class="glyphicon glyphicon-calendar"/>
                    </div>
                    <div class="form-group">
                        <label for="to">To:</label>
                        <input type="date" class="form-control" id="to" name="to"><span class="glyphicon glyphicon-calendar"/>
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="time" class="form-control" id="time" name="time"><span class="glyphicon glyphicon-time"/>
                    </div>
                    <div class="form-group">
                        <label for="totime">Until:</label>
                        <input type="time" class="form-control" id="totime" name="totime"><span class="glyphicon glyphicon-time"/>
                    </div>
                    <div class="form-group">
                        <label for="rsvp">RSVP:</label>
                        <input type="date" class="form-control" id="rsvp" name="rsvp" required><span class="glyphicon glyphicon-calendar"/>
                    </div>

                <p>Alter the options below to adjust the details of this event</p>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4" style="border-right : 1px solid black; height : 100%">
                        <h6>Add Group to Event</h6>
                        <?php
                        foreach($groups as $group) {
                            if ($group) {
                                echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                                '<div class="col-sm-4">',
                                '<img src="images/user.png" alt="user_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                '</div>',

                                '<div class="col-sm-6">',
                                    '<p>' . $group->getName().'</p>',
                                '</div>',
                                '<div class="col-sm-2">',
                                    '<input name="group[]" value="'.$group->getId().'" type="checkbox" style="margin-top : 80%">',
                                '</div>',
                                '</div>';
                            } else {
                                echo "<p>You have no groups of friends. :_(</p>";
                            }
                        }
                        ?>
                    </div>
                    <div class="col-md-4" style="border-right : 1px solid black">
                        <h6>Add Friends to Event</h6>
                        <?php
                        foreach($friends as $friend) {
                            if ($friend) {
                                echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                                '<div class="col-sm-4">',
                                '<img src="images/users.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                '</div>',

                                '<div class="col-sm-6">',
                                    '<p>' . $friend->getFirstName() . ' '. $friend->getSecondName() .'</p>',
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
                    <div class="col-md-4">
                        <h6>Add Location to Event</h6>
                        <div class="input-group">
                            <input id="mapSearchBox" name="location" type="text" class="form-control" placeholder="Search">
                            <div class="input-group-btn">
                                <div class="btn btn-default" onclick="findAddress()">
                                    <i class="glyphicon glyphicon-search"></i>
                                </div>
                            </div>
                        </div>
                        <div id='myMap' style='width: 100%; height: 300px;'></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Create Event</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div id="editEventModal" class="modal fade" role="dialog">;
    <div class="modal-dialog" style="width : 70%;">
        <!-- Modal content-->
        <form class="form-inline" action="edit_event.php" method="get" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <div class="form-group">
                        <label for="eventName">Event Name:</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" required>
                    </div>
                    <div class="form-group">
                        <label for="from">Date:</label>
                        <input type="date" class="form-control" id="from" name="from" required><span class="glyphicon glyphicon-calendar"/>
                    </div>
                    <div class="form-group">
                        <label for="to">To:</label>
                        <input type="date" class="form-control" id="to" name="to"><span class="glyphicon glyphicon-calendar"/>
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="time" class="form-control" id="time" name="time"><span class="glyphicon glyphicon-time"/>
                    </div>
                    <div class="form-group">
                        <label for="totime">Until:</label>
                        <input type="time" class="form-control" id="totime" name="totime"><span class="glyphicon glyphicon-time"/>
                    </div>
                    <div class="form-group">
                        <label for="rsvp">RSVP:</label>
                        <input type="date" class="form-control" id="rsvp" name="rsvp" required><span class="glyphicon glyphicon-calendar"/>
                    </div>

                    <p>Alter the options below to adjust the details of this event</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4" style="border-right : 1px solid black; height : 100%">
                            <h6>Add Group to Event</h6>
                            <?php
                            foreach($groups as $group) {
                                if ($group) {
                                    echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                                    '<div class="col-sm-4">',
                                    '<img src="images/user.png" alt="user_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                    '</div>',

                                    '<div class="col-sm-6">',
                                        '<p>' . $group->getName().'</p>',
                                    '</div>',
                                    '<div class="col-sm-2">',
                                        '<input name="group[]" id="Group'.$group->getId().'" value="'.$group->getId().'" type="checkbox" style="margin-top : 80%">',
                                    '</div>',
                                    '</div>';
                                } else {
                                    echo "<p>You have no groups of friends. :_(</p>";
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-4" style="border-right : 1px solid black">
                            <h6>Add Friends to Event</h6>
                            <?php
                            foreach($friends as $friend) {
                                if ($friend) {
                                    echo '<div class="row" style="margin : 5%; background-color : whitesmoke; border: 1px solid black">',
                                    '<div class="col-sm-4">',
                                    '<img src="images/users.png" alt="users_image"  style="padding : 10%; height : 80%; width: 80%;">',
                                    '</div>',

                                    '<div class="col-sm-6">',
                                        '<p>' . $friend->getFirstName() . ' '. $friend->getSecondName() .'</p>',
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
                        <div class="col-md-4">
                            <h6>Add Location to Event</h6>
                            <div class="input-group">
                                <input id="mapSearchBox" name="location" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <div class="btn btn-default" onclick="findAddress()">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </div>
                                </div>
                            </div>
                            <div id='editMap' style='width: 100%; height: 300px;'></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#editEventModal").on("shown.bs.modal", function(event){
            loadMapScenario("editMap");
           var modal = $(this);
           SearchMap(modal.find("#mapSearchBox").val());
        });
        $("#addEventModal").on("shown.bs.modal", function(event){
            loadMapScenario("myMap");
        });

        $("#editEventModal").on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var planitEvent = button.data("event");
            var modal = $(this);
            planitEvent = planitEvent.replace(/'/g, "\"");
            planitEvent = JSON.parse(planitEvent);

            modal.find("#eventName").val(planitEvent.title);
            modal.find("#from").val(planitEvent.from_date);
            modal.find("#to").val(planitEvent.to_date);
            modal.find("#time").val(planitEvent.time);
            modal.find("#mapSearchBox").val(planitEvent.location);
            modal.find("#totime").val(planitEvent.to_time);
            modal.find("#rsvp").val(planitEvent.rsvp);


            //reset checkboxes
            var checkboxes = new Array();
            checkboxes = document.getElementsByTagName("input");
            for(var i=0; i < checkboxes.length; i++){
                checkboxes[i].checked = false;
            }

            //setup checkboxes of friends and groups already selected.
            var friends = planitEvent.attendees;
            if(friends != null && friends != "") {
                var friendsArray = friends.split(",");
                //check all members selected
                friendsArray.forEach(function(entry){
                    var inputId = "User"+entry;
                    document.getElementById(inputId).checked = true;
                });
            }
            var groups = planitEvent.groups;
            if(groups != null && groups != ""){

                var groupsArray = groups.split(",");
                groupsArray.forEach(function(entry){
                    var inputId = "Group"+entry;
                    document.getElementById(inputId).checked = true;
                 });
            }
        });
    });
</script>