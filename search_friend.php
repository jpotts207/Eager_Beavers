<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 15/07/2018
 * Time: 2:05 PM
 */
session_start();
spl_autoload_extensions(".php");
spl_autoload_register();

$email = $_POST['search'];
$db = new DatabaseContext();
$friend = $db->findUser($email);

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
include("menu.php");
?>
<body>
    <div class="container-fluid" id="container">
    <?php
    if($friend){
        echo '<form><h4>We found the following user with that email:</h4>',
        '<div class="panel panel-default">',
            '<p> email: ' . $friend->getEmail() . '</p>',
            '<p> First Name : ' . $friend->getFirstName() . '</p>',
            '<p> Surname : ' . $friend->getSecondName() . '</p>',
            '<div class="btn-group-justified">',
                '<a href ="add_friend.php?id='.$friend->getId().'" class="btn btn-success" >Add</a>',
                '<button type="button" class="btn btn-danger" onclick="gotoFriends()" >Cancel</button>',
            '</div>',
        '</div>',
        '</form>';
    }else{
        echo '<script type="text/javascript">',
            'alert("No user could be found with that email");',
            "gotoFriends();",
            '</script>';
    }

    ?>
    </div>
</body>
