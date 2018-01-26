<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/19/17
 * Time: 12:33 AM
 */
    require_once('../../db.php');
    require_once('../../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("connection");
    }
    $tableOfRocks = "select count(match_id) as rocks from matches where user_choice = 0";
    $tableOfPapers = "select count(match_id) as papers from matches where user_choice = 1";
    $tableOfScissors = "select count(match_id) as scissors from matches where user_choice = 2";
    $query = "select (({$tableOfRocks})/count(match_id)) as prob_rock, (({$tableOfPapers})/count(match_id)) as prob_paper, ".
        "(({$tableOfScissors})/count(match_id)) as prob_scissors from matches";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error($query);
    }
    $row = @ mysqli_fetch_array($result);
    $prob_rock = $row['prob_rock'];
    if(is_null($prob_rock)){
        $prob_rock = 0;
    }
    $prob_paper = $row['prob_paper'];
    if(is_null($prob_paper)){
        $prob_paper = 0;
    }
    $prob_scissors = $row['prob_scissors'];
    if(is_null($prob_scissors)){
        $prob_scissors = 0;
    }
    $json = array();
    $results = array();
    $results['prob_of_rock'] = $prob_rock;
    $results['prob_of_paper'] = $prob_paper;
    $results['prob_of_scissors'] = $prob_scissors;
    $json['results'] = $results;
    $end = json_encode($json);
    echo $end;
?>