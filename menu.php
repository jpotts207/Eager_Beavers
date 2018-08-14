<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton/Tapra
 * Date: 21/06/2018
 * Time: 10:09 PM
 */
spl_autoload_extensions(".php");
spl_autoload_register();

$authenticated = false; //used to open up extra menu items
$user = new User();

//check if there is a value in "Authenticated"
if(isset($_SESSION["Authenticated"])){

    //if not value in Athenticated doesn't equal false, then user is auth'd
    if($_SESSION["Authenticated"] != false){
        $authenticated = true;
        $id = $_SESSION["Authenticated"];   //authenticated contains the user Id
        $user = $db->getUser($id);          //get all the user details
    }
    else{
        $authenticated = false;
    }
}

?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="images/logo1.png" height="25" alt="Plan !T"/></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                /*open up extra menu items if logged in/authenticated*/
                if($authenticated === true){
                    echo "<li><a href='?page=events'>Events</a></li>",
                        "<li><a href='?page=friends'>Friends</a></li>",
                        "<li><a href='?page=groups'>Groups</a></li>",
                        "<li><a href='?page=invites'>Invites</a></li>",
                        "<li><a href='?page=account'>Account</a></li>";
                }
                else{
                    echo "<li><a class='nav-link' href='?page=signupPage'>Signup</a></li>";

                }
                echo "<li><a class='nav-link' href='?page=about'>About</a></li>";
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                /* display login for logged out users, and logout for logged in users - got it? */
                if($authenticated === true){
                    echo "<li><a class='content'>Welcome ".$user->getFirstName()."</a></li>",
                        "<li><a href='index.php?page=logout'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
                }
                else{
                    echo "<li><a href='index.php?page=loginPage'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>


