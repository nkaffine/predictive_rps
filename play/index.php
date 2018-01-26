<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 4:15 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error(null);
    }
    $user_id = checkUser();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Rock Paper Scissors</title>
        <!--Stuff required for bootstrap-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../scripts/play.js"></script>
    </head>
    <body>
        <img id="rock" src="../images/rock.png" class="col-lg-4 col-xs-12">
        <img id="paper" src="../images/paper.png" class="col-lg-4 col-xs-12">
        <img id="scissors" src="../images/scissors.png" class="col-lg-4 col-xs-12">
    </body>
</html>
