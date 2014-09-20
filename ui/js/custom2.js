var hackgt = angular.module('hackgt', []);

hackgt.config(['$locationProvider',
    function($locationProvider) {
        $locationProvider.html5Mode(true);
    }
])

hackgt.controller('CustomCtrl', function($scope, $location, $http) {
    /*$scope.data = { categories:["Trek","Weekend", "Walking distance", "Vacation", "Day Excursion"],  list:["National Park", "Florida"]};  
     */
    var param = $location.search().topic;
    $http.get('http://108.61.131.41/the_game_of_choices/places/topic=' + param)
        .success(function(data) {
            $scope.categories = data.categories;
        }).error(function(data) {
            console.log(error);
        });


});

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
        activeClass: 'ui-state-hover',
        hoverClass: 'ui-state-active',
        drop: function(event, ui) {
            //$(this).addClass('ui-state-highlight').find('p').html('Dropped!');
            window.location.href = "refine.html?topic=" + ui.draggable.text().trim();
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