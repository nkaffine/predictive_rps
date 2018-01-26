<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/19/17
 * Time: 12:31 AM
 */
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
        <script src="../scripts/data.js"></script>
        <!--Stuff for selectors-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    </head>
    <body>
        <div id="probs"></div>
        <div>
            <label for="myChoice">Your Last Throw</label>
            <select id="myChoice" class="col-lg-4 selectpicker">
                <option value="0">Rock</option>
                <option value="1">Paper</option>
                <option value="2">Scissors</option>
            </select>
            <label for="theirChoice">Their Last Throw</label>
            <select id="theirChoice" class="col-lg-4 selectpicker">
                <option value="0">Rock</option>
                <option value="1">Paper</option>
                <option value="2">Scissors</option>
            </select>
            <button id="getProbOfThrow" class="btn btn-primary">Get Probability of Their Throw</button>
            <div id="results">

            </div>
        </div>
    </body>
</html>
