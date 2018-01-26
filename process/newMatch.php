<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/18/17
 * Time: 10:07 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error(null);
    }
    if(count($_GET)){
        switch($_GET['choice']){
            case 0:
                $choice = 0;
                break;
            case 1:
                $choice = 1;
                break;
            case 2:
                $choice = 2;
                break;
            default:
                error(null);
                break;
        }
    }
    if(!isset($choice)){
        error(null);
    }
    $user_id = checkUser();
    //get the previous match from this user
    $query = "select max(match_id) from matches where user_id = {$user_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error(null);
    }
    if(mysqli_num_rows($result) > 1){
        error("");
    }
    $row = @ mysqli_fetch_array($result);
    $match_id = $row['max(match_id)'];
    if(is_null($match_id)){
        // The user has never played before
        // Find the stats for the first moves of sessions of all other users
        $tableOfRocks = "select count(match_id) as rocks from matches where user_choice = 0 and previous_match is null";
        $tableOfPapers = "select count(match_id) as papers from matches where user_choice = 1 and previous_match is null";
        $tableOfScissors = "select count(match_id) as scissors from matches where user_choice = 2 and previous_match is null";
        $query = "select (({$tableOfRocks})/count(match_id)) as prob_rock, (({$tableOfPapers})/count(match_id)) as prob_paper, ".
            "(({$tableOfScissors})/count(match_id)) as prob_scissors from matches";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error(null);
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
        if($prob_rock > $prob_paper && $prob_rock > $prob_scissors){
            $computer_choice = 1;
        } else if($prob_paper > $prob_rock && $prob_paper > $prob_scissors) {
            $computer_choice = 2;
        } else if($prob_scissors > $prob_paper && $prob_scissors > $prob_rock) {
            $computer_choice = 0;
        } else if($prob_scissors == $prob_rock) {
            $computer_choice = 0;
        } else if($prob_scissors == $prob_paper) {
            $computer_choice = 2;
        } else if ($prob_rock == $prob_paper) {
            $computer_choice = 1;
        } else {
            $computer_choice = 0;
        }
    } else {
        //Determine whether the last match was the final match of a session
        $query = "select user_choice, computer_choice, is_final from matches where match_id = {$match_id} and user_id = {$user_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error(null);
        }
        if(notUnique($result)){
            error(null);
        }
        $row = @ mysqli_fetch_array($result);
        if($row['is_final'] == 1){
            // It was the last match of a session
            //Get the stats on people choices when starting a session
            $tableOfRocks = "select count(match_id) as rocks from matches where user_choice = 0 and previous_match is null";
            $tableOfPapers = "select count(match_id) as papers from matches where user_choice = 1 and previous_match is null";
            $tableOfScissors = "select count(match_id) as scissors from matches where user_choice = 2 and previous_match is null";
            $tableOfUserRocks = "select count(match_id) as rocks from matches where user_choice = 0 and ".
                "previous_match is null and user_id = {$user_id}";
            $tableOfUserPapers = "select count(match_id) as papers from matches where user_choice = 1 and ".
                "previous_match is null and user_id = {$user_id}";
            $tableOfUserScissors = "select count(match_id) as scissors from matches where user_choice = 2 and ".
                "previous_match is null and user_id = {$user_id}";
            $queryPart1 = "select 1 as thing, (({$tableOfRocks})/count(match_id)) as prob_rock, (({$tableOfPapers})/count(match_id)) as prob_paper, ".
                "(({$tableOfScissors})/count(match_id)) as prob_scissors from matches";
            $queryPart2 = "select 1 as thing, (({$tableOfUserRocks})/count(match_id)) as prob_rock, (({$tableOfUserPapers})/count(match_id)) as prob_paper, ".
                "(({$tableOfUserScissors})/count(match_id)) as prob_scissors from matches where user_id = {$user_id}";
            $query = "select ((.75 * r1.prob_rock) + (.25 * r2.prob_rock)) as prob_rock, ((.75 * r1.prob_paper) + ".
                "(.25 * r2.prob_paper)) as prob_paper, ((.75 * r1.prob_scissors) + (.25 * r2.prob_scissors)) as prob_scissors from ".
                "({$queryPart1}) as r1 left join ({$queryPart2}) as r2 using (thing)";
            if(($result = @ mysqli_query($connection, $query))==FALSE){
                error(null);
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
            if($prob_rock > $prob_paper && $prob_rock > $prob_scissors){
                $computer_choice = 1;
            } else if($prob_paper > $prob_rock && $prob_paper > $prob_scissors) {
                $computer_choice = 2;
            } else if($prob_scissors > $prob_paper && $prob_scissors > $prob_rock) {
                $computer_choice = 0;
            } else if($prob_scissors == $prob_rock) {
                $computer_choice = 0;
            } else if($prob_scissors == $prob_paper) {
                $computer_choice = 2;
            } else if ($prob_rock == $prob_paper) {
                $computer_choice = 1;
            } else {
                $computer_choice = 0;
            }
            $wasFinal = true;
        } else {
            //It was in the middle of a session
            //Get stats on what user did next when it was in this scenario
            $old_computer_choice = $row['computer_choice'];
            $old_user_choice = $row['user_choice'];
            // select all of the matches where that has been the case
            $rightScenarioGeneral = "select user_choice from (select (match_id + 1) as match_id from matches where user_choice = ".
                "{$old_user_choice} and computer_choice = {$old_computer_choice}) as r1 left join matches using (match_id)";
            $rightScenarioUser = "select user_choice from (select (match_id + 1) as match_id from matches where user_choice = ".
                "{$old_user_choice} and computer_choice = {$old_computer_choice} and user_id = {$user_id}) as r2 left ".
                "join matches using (match_id)";
            $tableOfRocks = "select count(user_choice) as rocks from ({$rightScenarioGeneral}) as r3 where user_choice = 0";
            $tableOfPapers = "select count(user_choice) as papers from ({$rightScenarioGeneral}) as r4 where user_choice = 1";
            $tableOfScissors = "select count(user_choice) as scissors from ({$rightScenarioGeneral}) as r5 where user_choice = 2";
            $tableOfUserRocks = "select count(user_choice) as rocks from ({$rightScenarioUser}) as r6 where user_choice = 0";
            $tableOfUserPapers = "select count(user_choice) as papers from ({$rightScenarioUser}) as r7 where user_choice = 1";
            $tableOfUserScissors = "select count(user_choice) as scissors from ({$rightScenarioUser}) as r8 where user_choice = 2";
            $queryPart1 = "select 1 as thing, (({$tableOfRocks}) / count(user_choice)) as prob_rock, (({$tableOfPapers}) / count(user_choice)) as prob_paper, ".
                "(({$tableOfScissors}) / count(user_choice)) as prob_scissors from ({$rightScenarioGeneral}) as r9";
            $queryPart2 = "select 1 as thing, (({$tableOfUserRocks}) / count(user_choice)) as prob_rock, (({$tableOfUserPapers}) / count(user_choice)) as prob_paper, ".
                "(({$tableOfUserScissors}) / count(user_choice)) as prob_scissors from ({$rightScenarioUser}) as r10";
            $query = "select ((.75 * r11.prob_rock) + (.25 * r12.prob_rock)) as prob_rock, ((.75 * r11.prob_paper) + ".
                "(.25 * r12.prob_paper)) as prob_paper, ((.75 * r11.prob_scissors) + (.25 * r12.prob_scissors)) as prob_scissors from ".
                "({$queryPart1}) as r11 left join ({$queryPart2}) as r12 using (thing)";
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
            if($prob_rock > $prob_paper && $prob_rock > $prob_scissors){
                $computer_choice = 1;
            } else if($prob_paper > $prob_rock && $prob_paper > $prob_scissors) {
                $computer_choice = 2;
            } else if($prob_scissors > $prob_paper && $prob_scissors > $prob_rock) {
                $computer_choice = 0;
            } else if($prob_scissors == $prob_rock) {
                $computer_choice = 0;
            } else if($prob_scissors == $prob_paper) {
                $computer_choice = 2;
            } else if ($prob_rock == $prob_paper) {
                $computer_choice = 1;
            } else {
                $computer_choice = 0;
            }
        }
    }
    $newMatch = $match_id + 1;
    if(is_null($match_id) || isset($wasFinal)){
        $match_id = 'null';
    }
    $query = "insert into matches (user_id, match_id, user_choice, computer_choice, previous_match) values ".
        "({$user_id}, {$newMatch}, {$choice}, {$computer_choice}, {$match_id})";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error($query);
    }
    if(mysqli_affected_rows($connection) == -1){
        error(null);
    }
    header("Location: ../play/result.php");
    exit;
?>