<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 28/06/2018
 * Time: 8:26 PM
 */
//make sure we're using the session on this page
session_start();

//make sure all pages are available (for use of classes)
spl_autoload_extensions('.php');
spl_autoload_register();

//get username and password
$username = $_POST['username'];
$password = md5($_POST['password']);

//open up the database
$db = new DatabaseContext();

//get the user from the database and create an instance of a User.
$user = $db->authenticateUser($username, $password);
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
//include("menu.php");
?>
<?php
//if no user was found the result will be false
if($user !== false) {
    //record the id of the user in the "Authenticated" session variable
    // ('authenticated_user' would be better)
    $_SESSION["Authenticated"] = $user->getId();
    echo '<script type="text/javascript">',
            '$(document).ready(function(){',
                '$("#successModal").modal("toggle");',
            '});',
            '</script>';
}else{
    $_SESSION["Authenticated"] = false;         //set authenticated to false for use on other pages
    echo '<script>',
            '$(document).ready(function(){',
                '$("#failureModal").modal("toggle");',
            '});',
            '</script>';
}
?>


<!-- Modal -->
<div id="failureModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="gotoLogin()">&times;</button>
                <h4 class="modal-title">Log in failed!</h4>
            </div>
            <div class="modal-body">
                <p>Please check your email and password.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="gotoLogin()">Ok</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="successModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="gotoHome()">&times;</button>
                <h4 class="modal-title">Log in Successful</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo '<p>Welcome to Plan !t '.$user->getFirstName().'</p>';
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="gotoHome()">Ok</button>
            </div>
        </div>
    </div>
</div>
