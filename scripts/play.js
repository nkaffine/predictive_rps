/**
 * Created by Nick on 9/18/17.
 */
function adjustTopMargin(){
    if($(window).width() > 1200) {
        var height = $(window).height();
        var imgHeight = $("#scissors").outerHeight();
        var diff = (height - imgHeight) / 2;
        $("#rock").css('margin-top', parseInt($("#rock").css('margin-top')) + diff);
        $("#paper").css('margin-top', parseInt($("#paper").css('margin-top')) + diff);
        $("#scissors").css('margin-top', diff);
    } else {

    }
}
function evenOutImages(){
    if($(window).width() > 1200){
        var rock = $("#rock");
        var paper = $("#paper");
        var height = $("#scissors").outerHeight();
        paper.css('margin-top', (height - paper.outerHeight())/2);
        rock.css('margin-top', (height - rock.outerHeight())/2);
    } else {
        var height = $(window).height();
        $("#rock").height(height/3);
        $("#rock").css('width', 'auto');
        $("#paper").height(height/3);
        $("#paper").css('width', 'auto');
        $("#scissors").height(height/3);
        $("#scissors").css('width', 'auto');
        centerImages();
    }
}
function centerImages(){
    var width = $(window).width();
    var rockWidth = (width - $("#rock").width()) / 2 - 10;
    var paperWidth = (width - $("#paper").width()) / 2 - 10;
    var scissorWidth = (width - $("#scissors").width()) / 2 - 10;
    $("#rock").css('margin-left', rockWidth);
    $("#paper").css('margin-left', paperWidth);
    $("#scissors").css('margin-left', scissorWidth);
}
$(document).ready(function(){
    evenOutImages();
    adjustTopMargin();
    $(window).resize(function(){
        evenOutImages();
        adjustTopMargin();
    });
    $("#rock").click(function(){
        window.location = "../process/newMatch.php?choice=0";
    });
    $("#paper").click(function(){
        window.location = "../process/newMatch.php?choice=1";
    });
    $("#scissors").click(function(){
        window.location = "../process/newMatch.php?choice=2";
    });
});

