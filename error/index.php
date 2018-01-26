<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 4:16 PM
 */
    if(isset($_GET)){
        $message = $_GET['message'];
    }
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
    </head>
    <body>
        <div class='col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1' style='margin-top:2%; padding-left: 0; padding-right:0;'>
            <div class='panel panel-danger'>
                <div class='panel-heading'>Alert:</div>
                <div class='panel-body'>Something went wrong, please contact the administrator. <?php if(isset($message)){echo $message;};?></div>
            </div>
        </div>
    </body>
</html>
