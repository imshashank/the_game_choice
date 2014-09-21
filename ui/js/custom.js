$(function() {
    $(".draggable").draggable({
        revert: function(dropped) {
            var dropped = dropped && dropped[0].id == "droppable";
            return !dropped;
        }
    }).each(function() {
        var top = $(this).position().top;
        var left = $(this).position().left;
        $(this).data('orgTop', top);
        $(this).data('orgLeft', left);
    });


    $("#droppable").droppable({
        /*activeClass: 'ui-state-hover',
        /*hoverClass: 'ui-state-active',*/
        drop: function(event, ui) {
            //$(this).addClass('ui-state-highlight').find('p').html('Dropped!');
            window.location.href = "refine.html?types=" + ui.draggable[0].id;
        },
        out: function(event, ui) {
            ui.draggable.mouseup(function() {
                var top = ui.draggable.data('orgTop');
                var left = ui.draggable.data('orgLeft');
                ui.position = {
                    top: top,
                    left: left
                };
            });
        }
    });
});

$(document).ready(function() {
    //Center the "info" bubble in the  "circle" div
    var divTop = ($("#square").height() - $("#center-panel").height()) / 2;
    var divLeft = ($("#square").width() - $("#center-panel").width()) / 2;
    $("#center-panel").css("top", divTop + "px");
    $("#center-panel").css("left", divLeft + "px");

    numItems = $(".draggable").length; //How many items are in the circle?
    start = 0; //the angle to put the first image at. a number between 0 and 2pi
    step = (2 * Math.PI) / numItems; //calculate the amount of space to put between the items.

    $(".draggable").each(function(index) {
        radius = ($("#square").width() - $(this).width()) / 2; //The radius is the distance from the center of the div to the middle of an icon
        //the following lines are a standard formula for calculating points on a circle. x = cx + r * cos(a); y = cy + r * sin(a)
        //We have made adjustments because the center of the circle is not at (0,0), but rather the top/left coordinates for the center of the div
        //We also adjust for the fact that we need to know the coordinates for the top-left corner of the image, not for the center of the image.
        tmpTop = (($("#square").height() / 2) + radius * Math.sin(start)) - ($(this).height() / 2);
        tmpLeft = (($("#square").width() / 2) + radius * Math.cos(start)) - ($(this).width() / 2);
        start += step; //add the "step" number of radians to jump to the next icon

        //set the top/left settings for the image
        $(this).css("top", tmpTop);
        $(this).css("left", tmpLeft);
    });


});