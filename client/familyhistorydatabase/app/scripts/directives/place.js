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
    require: 'ngModel',
    template: '<div class="input-group"  style="width:100%;"><label class="input-group-addon" for="{{placeId}}" style="width:38px;"><i class="fa fa-map-marker"></i></label><input class="form-control" type="text" id="{{placeId}}" ng-model="searchKey" typeahead-on-select="onSelect($item, $model, $label)" typeahead="address for address in getLocation($viewValue)" class="form-control" placeholder="Search"></div>',
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
