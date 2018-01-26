<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 11:26 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error(null);
    }
    $user_id = checkUser();
    $query = "select user_choice, computer_choice, is_final from matches where match_id = (select max(match_id) ".
        "from matches where user_id = {$user_id}) and user_id = {$user_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error(null);
    }
    if(mysqli_num_rows($result) != 1){
        error($query);
    }
    $row = @ mysqli_fetch_array($result);
    $is_final = $row['is_final'];
    $user_choice = $row['user_choice'];
    $computer_choice = $row['computer_choice'];
    if($is_final){
        header("Location: index.php");
        exit;
    }
    switch($user_choice){
        case 0:
            switch($computer_choice){
                case 0:
                    $message = "It's a Tie";
                    break;
                case 1:
                    $message = "You Lost";
                    break;
                case 2:
                    $message = "You Won";
                    break;
                default:
                    error(null);
            }
            break;
        case 1:
            switch($computer_choice){
                case 0:
                    $message = "You Won";
                    break;
                case 1:
                    $message = "It's a Tie";
                    break;
                case 2:
                    $message = "You Lost";
                    break;
                default:
                    error(null);
            }
            break;
        case 2:
            switch($computer_choice){
                case 0:
                    $message = "You Lost";
                    break;
                case 1:
                    $message = "You Won";
                    break;
                case 2:
                    $message = "It's a Tie";
                    break;
                default:
                    error(null);
            }
            break;
        default:
            error(null);
    }
    if(!isset($message)){
        error("message not set");
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
        <script src="../scripts/result.js"></script>
    </head>
    <body>
        <div id="main" class="col-lg-4 col-lg-offset-4 col-xs-10 col-xs-offset-1">
            <h1 style="padding-left: 0; padding-right:0;" class="col-lg-12 col-xs-12 text-center"><?php echo $message?>&nbsp;</h1>
            <button id="stop" style="padding-left: 0; padding-right:0;" class="col-lg-6 col-xs-12 btn btn-lg btn-default">Stop Playing</button>
            <button id="again" style="padding-left: 0; padding-right:0;" class="col-lg-6 col-xs-12 btn btn-lg btn-primary">Play Again</button>
        </div>
    </body>
</html>













