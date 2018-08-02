<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 21/06/2018
 * Time: 9:32 PM
 */

//load in all classes
spl_autoload_extensions(".php");
spl_autoload_register();

//open up a database context that will be used on the page
$db = new DatabaseContext();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plan !t</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AtdWg-nCcD8mwIW4rRQaq16bWW2DX71YiNF5pLIy5YdgMWdrAzEVMeIVrLZdS6cS'></script>
        <script src="scripts/scripts.js" type="text/javascript"></script>
		
    </head>
    <body>
    <?php
            if($page_content === null){
                $page_content = "oops.php";
            }
            include ('menu.php');
            echo '<div class="container body-content">';
                include($page_content);
            echo '</div>';
        ?>
		<div>
		<h6 class = "footer"> Plan It is an group based project taking place in 2018.<br>
		To view licensing related to the project, please 
		<a href="LICENSE.txt" download>click here</a>
		, or follow these links to view our 
		<a href=>Privacy Policy</a> and 
		<a href=>Terms of Use</a>.</h6>
		</div>
    </body>
</html>
