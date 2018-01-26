/**
 * Created by Nick on 9/18/17.
 */
function adjustTopMargin(){
    var height = $(window).height();
    var btnHeight = $("#btn").outerHeight();
    var diff = height/2 - btnHeight;
    $("#btn").css('margin-top', diff);
}
$(document).ready(function(){
    adjustTopMargin();
    $(window).resize(function(){
        adjustTopMargin();
    });
    $("#btn").click(function(){
       window.location = "/play";
    });
});
