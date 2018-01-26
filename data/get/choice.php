<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/19/17
 * Time: 12:32 AM
 */
    require_once('../../db.php');
    require_once('../../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error(null);
    }
    if(count($_GET)){
        switch($_GET['ochoice']){
            case 0:
                $choice1 = 0;
                break;
            case 1:
                $choice1 = 1;
                break;
            case 2:
                $choice1 = 2;
                break;
            default:
                error(null);
                break;
        }
        switch($_GET['ychoice']){
            case 0:
                $choice2 = 0;
                break;
            case 1:
                $choice2 = 1;
                break;
            case 2:
                $choice2 = 2;
                break;
            default:
                error(null);
                break;
        }
    }
    if(!isset($choice1) || !isset($choice2)){
        error(null);
    }
    $rightScenarioGeneral = "select user_choice from (select (match_id + 1) as match_id from matches where user_choice = ".
        "{$choice1} and computer_choice = {$choice2}) as r1 left join matches using (match_id)";
    $tableOfRocks = "select count(user_choice) as rocks from ({$rightScenarioGeneral}) as r3 where user_choice = 0";
    $tableOfPapers = "select count(user_choice) as papers from ({$rightScenarioGeneral}) as r4 where user_choice = 1";
    $tableOfScissors = "select count(user_choice) as scissors from ({$rightScenarioGeneral}) as r5 where user_choice = 2";
    $query = "select (({$tableOfRocks}) / count(user_choice)) as prob_rock, (({$tableOfPapers}) / count(user_choice)) as prob_paper, ".
        "(({$tableOfScissors}) / count(user_choice)) as prob_scissors from ({$rightScenarioGeneral}) as r9";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error($query);
    }
    $row = @ mysqli_fetch_array($result);
    $json = array();
    $results = array();
    $results['prob_of_rock'] = $row['prob_rock'];
    $results['prob_of_paper'] = $row['prob_paper'];
    $results['prob_of_scissors'] = $row['prob_scissors'];
    $json['results'] = $results;
    $end = json_encode($json);
    echo $end;
?>
