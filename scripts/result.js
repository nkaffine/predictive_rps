/**
 * Created by Nick on 9/18/17.
 */
function adjustTopMargin(){
    var height = $(window).height();
    var btnHeight = $("#main").outerHeight();
    var diff = height/2 - btnHeight;
    $("#main").css('margin-top', diff);
}
$(document).ready(function(){
    adjustTopMargin();
    $(window).resize(function(){
        adjustTopMargin();
    });
    $("#stop").click(function(){
        window.location = "../process/stop.php";
    });
    $("#again").click(function(){
        window.location = "index.php";
    });
});