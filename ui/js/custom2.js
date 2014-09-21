/*var hackgt = angular.module('hackgt', []);

hackgt.config(['$locationProvider',
    function($locationProvider) {
        $locationProvider.html5Mode(true);
    }
])

hackgt.controller('CustomCtrl', function($scope, $location, $http) {
    /*$scope.data = { categories:["Trek","Weekend", "Walking distance", "Vacation", "Day Excursion"],  list:["National Park", "Florida"]};  
     */
/*    var param = $location.search().types;
    $http.get('http://localhost:8000/The-Game-Of-Choices/places/index.php?types=' + param)
        .success(function(data) {
            $scope.data = data;
            callback();
        }).error(function(data) {
            console.log(error);
        });
*/

//     $scope.data = {"categories":["adventure","tourist destinations","budget travel","trekking","leisure","camping","sightseeing"],"title":[{"name":"Georgia State Capitol","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/museum-71.png","lat":33.749612,"lng":-84.388365,"vicinity":"206 Washington St SW, Atlanta"},{"name":"Underground Atlanta","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.751739,"lng":-84.389949,"vicinity":"Suite 007, 50 Central Ave SW, Atlanta"},{"name":"Georgia Capitol \/ Georgia Capitol Museum & Tour Program","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/museum-71.png","lat":33.748994,"lng":-84.388111,"vicinity":"206 State Capitol, Atlanta"},{"name":"Marta Station","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.750331,"lng":-84.38641,"vicinity":"170 Piedmont Ave SE, Atlanta"},{"name":"Greyhound","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.748523,"lng":-84.396353,"vicinity":"232 Forsyth St SW, Atlanta"},{"name":"Atlanta Convention & Visitors Bureau Visitor Center","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.752532,"lng":-84.389851,"vicinity":"65 Alabama St SW, Atlanta"},{"name":"Holiday Inn Express","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/lodging-71.png","lat":33.75794,"lng":-84.389696,"vicinity":"111 Cone St NW, Atlanta"},{"name":"Quality Hotel Downtown","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/lodging-71.png","lat":33.75731,"lng":-84.389394,"vicinity":"89 Luckie St NW, Atlanta"},{"name":"Historic Preservation Division :Dept. of Natural Resources","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/library-71.png","lat":33.747937,"lng":-84.389779,"vicinity":"254 Washington St SW, Atlanta"},{"name":"Glenn Hotel, Autograph Collection","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/lodging-71.png","lat":33.756998,"lng":-84.393,"vicinity":"110 Marietta St NW, Atlanta"},{"name":"Georgia United Credit Union","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.749176,"lng":-84.386816,"vicinity":"2 Martin Luther King Jr Dr SE #460, Atlanta"},{"name":"Travelers","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/travel_agent-71.png","lat":33.756946,"lng":-84.388595,"vicinity":"100 Peachtree St NE, Atlanta"},{"name":"Fairfield Inn & Suites Atlanta Downtown","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/lodging-71.png","lat":33.752881,"lng":-84.391178,"vicinity":"54 Peachtree St SW, Atlanta"},{"name":"Fairlie - Poplar Historic District","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/generic_business-71.png","lat":33.756497,"lng":-84.390342,"vicinity":"Forsyth St NW, Atlanta"},{"name":"Residence Inn Atlanta Downtown","icon":"http:\/\/maps.gstatic.com\/mapfiles\/place_api\/icons\/lodging-71.png","lat":33.757294,"lng":-84.388169,"vicinity":"134 Peachtree St NW, Atlanta"}]};

//  var x;

var param = window.location.search.substring(window.location.search.indexOf("=") + 1)
if (param === "travel") {
var jqxhr = $.ajax("http://localhost:8000/The-Game-Of-Choices/places/index.php?types=" + param)
    .done(function(data) {
        //alert( "success" );
        successHandler(data);
    })
    .fail(function() {
        //alert( "error" );
    })
} else if (param === "food") {
    var jqxhr = $.ajax("http://localhost:8000/The-Game-Of-Choices/eat/index.php?types=" + param)
        .done(function(data) {
            //alert( "success" );
            successHandler(data);
        })
        .fail(function() {
            //alert( "error" );
        })
}

function successHandler(data) {

    var index, category_length;
    if (data.categories != null) {
        category_length = data.categories.length;
    } else {
        category_length = 0;
    }

    if (data.title != null) {
        title_length = data.title.length;
    } else {
        title_length = 0;
    }

    var x = $("#square");
    for (index = 0; index < category_length; ++index) {
        if (data.categories[index] === unescape(param)) {
            x.append("<div class='draggable' style='font-size:14px; padding-top:40px; border: 2px solid rgb(39, 189, 236); background-color: rgb(200, 232, 245);'>" + data.categories[index] + "</div>");
        } else {
            x.append("<div class='draggable' style='font-size:14px; padding-top:40px'>" + data.categories[index] + "</div>");
        }
    }

    var divTop = ($("#square").height() - $(".center-panel").height()) / 2;
    var divLeft = ($("#square").width() - $(".center-panel").width()) / 2;
    $(".center-panel").css("top", divTop + "px");
    $(".center-panel").css("left", divLeft + "px");

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
        drop: function(event, ui) {
            //$(this).addClass('ui-state-highlight').find('p').html('Dropped!');
            var prev_term_start = window.location.search.indexOf("types=") + 6;
            var prev_term_end = window.location.search.indexOf("pre=") - 4;
            var prev_term;
            if(prev_term_end>=0){
                prev_term = window.location.search.substring(prev_term_start, prev_term_end);
            }
            else{
                prev_term = window.location.search.substring(prev_term_start);   
            }
            var newUrl = "refine.html?types=" + ui.draggable.text().trim();
            if (newUrl.indexOf("&pre=") >= 0) {
                window.location.href = newUrl + " " + prev_term;
            }
            else{
                window.location.href = newUrl + "&pre=" + prev_term;    
            }
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

    var y = $("#result");
    if (title_length != 0) {
        var list = y.append("<ul class='list-group'></ul>").find('ul');
        for (index = 0; index < title_length; ++index) {
            list.append("<li class='list-group-item'><img src='" + data.title[index].icon + " ' height = '13px' width='13px' style='margin-right:10px'/>" + data.title[index].name + ", " + data.title[index].vicinity + "<img style='text-align:right; overflow:hidden;' src='../images/map_icon.png' no-repeat 0 0;height:30px;width:16px'><a style='display:block;height:30px;width:16px' href='https://maps.google.com/maps?id=\'" + data.title[index].vicinity + "\''></a></span> </li>");
        }
    }

}