<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 3/07/2018
 * Time: 6:42 PM
*/
    if(isset($_SESSION["Message"])){
        $message = $_SESSION["Message"];
        echo "<p style='text-align: center'>".$message."</p>";
    }
?>
    <p style="text-align: center">Plan !t is a meeting time organiser app.</p>

<?php
    $_SESSION["Message"] = '';
?>
