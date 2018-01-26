<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 11:55 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error(null);
    }
    $user_id = checkUser();
    $query = "select max(match_id) from matches where user_id = {$user_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error(null);
    }
    $row = @ mysqli_fetch_array($result);
    $match = $row['max(match_id)'];
    $query = "update matches set is_final = 1 where user_id = {$user_id} and match_id = {$match}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error(null);
    }
    if(mysqli_affected_rows($connection) == -1){
        error(null);
    }
    header("Location: ../index.php");
    exit;
?>