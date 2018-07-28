<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 15/07/2018
 * Time: 2:58 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

$db = new DatabaseContext();

$friendId = $_GET["id"];
$friend = $db->getUser($friendId);

$id = $_SESSION['Authenticated'];
$user = $db->getUser($id);

$user->addFriend($friendId);
$db->updateUser($user);
?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plan !t</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="scripts/scripts.js" type="text/javascript"></script>
</head>
<?php

echo '<script type="text/javascript">',
    '$(document).ready(function(){',
        '$("#friendAddedModal").modal("toggle");',
    '});',
    '</script>';

?>
<div id="friendAddedModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="gotoHome()">&times;</button>
                <h4 class="modal-title">Friend Added</h4>
            </div>
            <div class="modal-body">
                <?php
                echo '<p>We will notify '.$friend->getFirstName().' that they have a new friend! awww</p>';
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="gotoFriends()">Ok</button>
            </div>
        </div>
    </div>
</div>
