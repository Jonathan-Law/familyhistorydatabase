'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:place
* @description
* # place
*/
app.directive('place', ['business', function (Business) {
  var uniqueId = 1;
  return {
    scope: {
      ngModel: '=',
    },
    require: 'ngModel',
    templateUrl: 'views/place/default.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      scope.placeId = 'place_' + uniqueId++;
      scope.$watch('searchKey', function() {

      })

      scope.getLocation = function(val) {
        return Business.getLocation(val);
        // return Business.getTypeaheadPlace(val);
      }
      // element.text('this is the place directive');
    }
  };
}]);
