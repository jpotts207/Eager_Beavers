<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 5/08/2018
 * Time: 10:13 AM
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
        $invites =  $user->getInvites(Event::AS_EVENTS);
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
        <h1>Invites</h1>
        <p>Here's the list of events you're invited to</p>
        <p>Click on the event to see who's going, and to confirm or decline your attendance</p>
    </div>
</div>

<div class="beaverList">
    <div class="row">
        <div class="col-sm-8" border-right : 1px solid black; border-radius : 0px;">
        <?php
            foreach($invites as $invite){
                $inviteJSON = json_encode($invite);
                $inviteJSON = str_replace('"', '\'', $inviteJSON);
                if($invite){
                    echo '<div class="listpanel" data-toggle="modal" data-target="#viewInviteModal" data-event="'.$inviteJSON.'">
                            <div class="row" 
                            style="margin: 5%; 
                            background-color : whitesmoke; 
                            border: 1px solid black">',
                        '<div class="col-sm-3">',
                            '<img src="images/event.png" alt="event_image"  style="padding : 10%; height : 80%; width: 80%;"/>',
                        '</div>',
                        '<div class="col-sm-9">',
                            '<div class="row">',
                                '<div class="col-sm-6">',
                                    '<p>' . $invite->getTitle() . '</p>';
                                    switch($invite->getStatus()){
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
                                    echo '<p>RSVP : '.$invite->getRsvp();
                                echo '</div>',
                                '<div class="col-sm-6">',
                                    '<p>Date : ' . $invite->getFromDate() . '</p>',
                                    '<p>Time : ' . substr($invite->getTime(),0, 5) . '</p>';
                                   if($invite->isAttending($user->getId())){
                                       echo '<p>Attending : <span class="label label-success">Attending</span></p>';
                                   }else if($invite->isNotAttending($user->getId())){
                                       echo '<p>Attending : <span class="label label-danger">Not Attending</span></p>';
                                   }else{
                                       echo '<p>Attending : <span class="label label-primary">Unconfirmed</span></p>';
                                   }

                                echo '</div>',
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>';
                }
                else{
                    echo '<p>No Invites?  No Friends? Aww</p>';
                }
            }
        ?>
    </div>
</div>

<div id="viewInviteModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width : 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-md-6">
                        <h3 id="modal-title" class="modal-title">Event Name:</h3>
                    </div>
                    <div class="col-md-6">
                        <h4 id="location" class="modal-title">Location: </h4>
                    </div>
                </div>


                <input id="eventId" style="visibility: collapse"/>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <h4>Confirmed</h4>
                        <div id="confirmed"></div>
                        <!--confirmed attendees-->
                        <p id="test"></p>
                    </div>
                    <div class="col-md-2">
                        <h4>Invited</h4>
                        <!--pending attendees-->
                        <div id="pending"></div>
                    </div>
                    <div class="col-md-2">
                        <h4>Not Attending</h4>
                        <div id="notAttending"></div>
                        <!--not attending-->
                    </div>
                    <div class="col-md-6">
                        <div id='myMap' style='width: 100%; height: 300px;'></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" onClick="confirmAttendance(<?php echo $user->getId() ?>)">Confirm Attendance</button>
                    <button type="button" class="btn btn-danger" onClick="declineAttendance(<?php echo $user->getId() ?>)">Decline Attendance</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var invitees;
    var confirmed;
    var notAttending;
    $(document).ready(function(){
        $("#viewInviteModal").on("show.bs.modal", function(event){
            var button = $(event.relatedTarget);
            var planitEvent = button.data("event");
            var modal = $(this);
            planitEvent = planitEvent.replace(/'/g, "\"");
            planitEvent = JSON.parse(planitEvent);

            modal.find("#modal-title").text(planitEvent.title);
            modal.find("#location").text(planitEvent.location);
            modal.find("#eventId").val(planitEvent.Id);

            getInvitees(planitEvent.Id);
            getConfirmed(planitEvent.Id);
            getNotAttending(planitEvent.Id);

        });
        $("#viewInviteModal").on("shown.bs.modal", function(event) {
        //function onShown(modal){
            var modal = $(this);
            var innerPending = "";
            var innerConfirmed = "";
            var innerNottAtending = "";

            loadMapScenario("myMap");
            SearchMap(modal.find("#location").text());

            if(invitees != '[false]') {

                invitees = JSON.parse(invitees);
                invitees.forEach(function(user){
                    innerPending = innerPending+ "<p>" + user.first_name + " " + user.second_name + "</p>";
                });
                modal.find("#pending").html(innerPending);
            }
            if(confirmed != '[false]'){
                confirmed = JSON.parse(confirmed);
                confirmed.forEach(function(user){
                    innerConfirmed = innerConfirmed + "<p>" + user.first_name + " " + user.second_name + "</p>";
                });
                modal.find("#confirmed").html(innerConfirmed);
            }
            if(notAttending != '[false]') {
                notAttending = JSON.parse(notAttending);
                notAttending.forEach(function(user){
                    innerNottAtending = innerNottAtending + "<p>" + user.first_name + " " + user.second_name + "</p>";
                });
                modal.find("#notAttending").html(innerNottAtending)
            }


        });

        function getInvitees(id){
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    invitees = this.responseText;
                }
            };
            xmlhttp.open("GET", "getAttendees.php?type=invitees&event=" + id, false);
            xmlhttp.send();
        }
        function getConfirmed(id){
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    confirmed = this.responseText;
                }
            };
            xmlhttp.open("GET", "getAttendees.php?type=confirmed&event=" + id, false);
            xmlhttp.send();
        }
        function getNotAttending(id){
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    notAttending = this.responseText;
                }
            };
            xmlhttp.open("GET", "getAttendees.php?type=not&event=" + id, false);
            xmlhttp.send();
        }
    });

    function confirmAttendance(userId){
        var eventId = $("#eventId").val();
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                window.location.href = "index.php?page=invites";
            }
        };
        xmlhttp.open("GET", "confirmAttendance.php?type=confirm&event=" + eventId + "&user=" +userId, true);
        xmlhttp.send();
    }
    function declineAttendance(userId){
        var eventId = $("#eventId").val();
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                window.location.href = "index.php?page=invites";
            }
        };
        xmlhttp.open("GET", "confirmAttendance.php?type=decline&event=" + eventId + "&user=" +userId, true);
        xmlhttp.send();
    }

</script>