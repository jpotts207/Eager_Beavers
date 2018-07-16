<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 28/06/2018
 * Time: 9:10 PM
 */
session_destroy();
$S_SESSION["Authenticated"] = false;
echo '<script type="text/javascript">',
    'alert("logged out Successfully.");',        //notify the user that they've logged out successfully
    'window.location("index.php?page=home")',   //redirct to home
'</script>';