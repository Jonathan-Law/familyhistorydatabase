'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:place
* @description
* # place
*/
app.directive('place', ['business', '$timeout', function (Business, $timeout) {
  var uniqueId = 1;
  return {
    scope: {
      ngModel: '=',
      form: '@'
    },
    require: 'ngModel',
    templateUrl: 'views/place/default.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      
      scope.$on('$RESETFORM', function(){
        scope.tempNgModel = '';
      })

      scope.tempNgModel;
      scope.placeId = 'place_' + uniqueId++;
      scope.$watch('ngModel', function() {
        if (scope.ngModel && typeof scope.ngModel === 'object') {
          var town;
          var state;
          var country;
          var county;
          town = scope.ngModel.town? scope.ngModel.town: '';
          state = scope.ngModel.state? scope.ngModel.state: '';
          country = scope.ngModel.country? scope.ngModel.country: '';
          county = scope.ngModel.county? scope.ngModel.county: '';
          scope.tempNgModel = {
            'formatted_address': ''+ town +', '+ county +', '+state+', '+country,
            'address_components': [
            {
              'long_name': town
            }, {
              'long_name': county
            }, {
              'long_name': state
            }, {
              'long_name': country
            }
            ]
          }
        }
      })
      scope.$watch('searchKey', function() {

      })

      scope.getLocation = function(val) {
        return Business.getLocation(val);
        // return Business.getTypeaheadPlace(val);
      }

      scope.$watch('tempNgModel', function() {
        if (scope.tempNgModel && typeof scope.tempNgModel === 'object') {
          if (scope.form === 'full'){
            scope.ngModel = scope.tempNgModel;
          } else {
            scope.ngModel = {};
            scope.ngModel.town = scope.tempNgModel.address_components[0].long_name;
            scope.ngModel.county = scope.tempNgModel.address_components[1].long_name;
            scope.ngModel.state = scope.tempNgModel.address_components[2].long_name;
            scope.ngModel.country = scope.tempNgModel.address_components[3].long_name;
          }
        } else if (scope.tempNgModel && scope.tempNgModel !== '') {
          var list = scope.tempNgModel.split(',');
          if (list.length < 4) {
            triggerAlert('There was an error.');
            return false;
          }
          scope.ngModel.town = list[0].trim();
          scope.ngModel.county = list[1].trim();
          scope.ngModel.state = list[2].trim();
          scope.ngModel.country = list[3].trim();
        } else {
          scope.ngModel = false;
        }
      }, true);
      // element.text('this is the place directive');
    }
  };
}]);
