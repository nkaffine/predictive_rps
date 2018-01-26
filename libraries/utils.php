<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 4:16 PM
 */
function checkUser(){
    global $connection;
    if(!isset($_COOKIE['user'])){
        $query = "select max(user_id) from users";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error(null);
        }
        $row = @ mysqli_fetch_array($result);
        $newId = $row['max(user_id)'] + 1;
        $query = "insert into users (user_id) values ({$newId})";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error(null);
        }
        if(mysqli_affected_rows($connection) == -1){
            error(null);
        }
        $cookie_name = "user";
        $cookie_value = $newId;
        setcookie($cookie_name, $cookie_value, time() + (10 * 365 * 24 * 60 * 60), "/"); //10 years +- 3-4 days
    }
    return $_COOKIE['user'];
}

function error($error){
    if(isset($error)){
        $location = "/error/index.php?message=" . urlencode($error);
    } else {
        $location = "/error";
    }
    header("Location: " . $location);
    exit;
}
function notUnique($result){
    if(mysqli_num_rows($result) != 1){
        return true;
    } else {
        return false;
    }
}
?>