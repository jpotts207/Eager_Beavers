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
<!DOCTYPE html lang="en" xmlns="http://www.w3.org/1999/xhtml">
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
    <body>
        <?php
            if($page_content === null){
                $page_content = "oops.php";
            }
            //include('header.php');
            include ('menu.php');
            include($page_content);
            //include ('footer.php');
        ?>
    </body>
</html>
