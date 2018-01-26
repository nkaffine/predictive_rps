/**
 * Created by Nick on 9/19/17.
 */
$(document).ready(function(){
    console.log('get/probabilities.php');
    $.getJSON('get/probabilities.php', function(data){
        var prob_rock  = data.results.prob_of_rock;
        var prob_paper  = data.results.prob_of_paper;
        var prob_scissors  = data.results.prob_of_scissors;
        var html = "<table class='table table-striped'>" +
            "<thead>" +
            "<th>Probability of Result Being Rock</th>" +
            "<th>Probability of Result Being Paper</th>" +
            "<th>Probability of Result Being Scissors</th>" +
            "</thead>" +
            "<tbody>" +
            "<tr>" +
            "<td>"+prob_rock+"</td>" +
            "<td>"+prob_paper+"</td>" +
            "<td>"+prob_scissors+"</td>" +
            "</tr>" +
            "</tbody>" +
            "</table>";
        document.getElementById('probs').innerHTML = html;
    })
    $("#getProbOfThrow").click(function(){
       var ychoice = document.getElementById('myChoice').value;
       var ochoice = document.getElementById('theirChoice').value;
       var link = 'get/choice.php?ochoice=' + encodeURIComponent(ochoice) + "&ychoice=" + encodeURIComponent(ychoice);
       console.log(link);
       $.getJSON(link, function(data){
           var prob_rock  = data.results.prob_of_rock;
           var prob_paper  = data.results.prob_of_paper;
           var prob_scissors  = data.results.prob_of_scissors;
           var html = "<table class='table table-striped'>" +
               "<thead>" +
               "<th>Probability of Result Being Rock</th>" +
               "<th>Probability of Result Being Paper</th>" +
               "<th>Probability of Result Being Scissors</th>" +
               "</thead>" +
               "<tbody>" +
               "<tr>" +
               "<td>"+prob_rock+"</td>" +
               "<td>"+prob_paper+"</td>" +
               "<td>"+prob_scissors+"</td>" +
               "</tr>" +
               "</tbody>" +
               "</table>";
           document.getElementById('results').innerHTML = html;
        });
    });
});
