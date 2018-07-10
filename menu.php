<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton/Tapra
 * Date: 21/06/2018
 * Time: 10:09 PM
 */
spl_autoload_extensions(".php");
spl_autoload_register();

$authenticated = false;
$user = new User();
if(isset($_SESSION["Authenticated"])){
    if($_SESSION["Authenticated"] != false){
        $authenticated = true;
        $id = $_SESSION["Authenticated"];
        $user = $db->getUser($id);
        //echo $user->getFirstName();
    }
    else{
        $authenticated = false;
    }
}

?>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">

        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><img src="images/logo1.png" height="25" alt="Plan !T"></a>
        </div>

        <ul class="nav navbar-nav">
            <?php
            /*open up extra menu items if logged in*/
            if($authenticated === true){
                echo "<li><a href='?page=events'>Events</a></li>";
                echo "<li><a href='?page=friends'>Friends</a></li>";
                echo "<li><a href='?page=groups'>Groups</a></li>";
                echo "<li><a href='?page=account'>Account</a></li>";
            }
            else{
                echo "<li><a class=\"nav-link\" href='?page=signupPage'>signup</a></li>";
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            /* display login for logged out users, and logout for logged in users - got it? */
            if($authenticated === true){
                echo "<li><a class='content'>Welcome ".$user->getFirstName()."</a>";
                echo "<li><a href='?page=logout'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
            }
            else{
                echo "<li><a href='?page=loginPage'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
            }
            ?>

        </ul>
    </div>
</nav>

