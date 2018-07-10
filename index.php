<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
*/


if(session_status() === PHP_SESSION_ACTIVE){

}else{
    session_start();
}

if (isset($_SESSION["Authenticated"])){

}else{
    //anything to do?
}


$var = '';
if(isset($_GET["page"])) {
    $var = $_GET["page"];
    $page_content = $var.".php";

}
else {
    $page_content = "home.php";
}


include ('master.php');


?>



