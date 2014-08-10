'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:date
* @description
* # date
*/
app.directive('date',['$timeout', function ($timeout) {
  var uniqueId = 0;
  var getTemplate = function(element, attrs) {
    if (attrs.mode && attrs.mode === 'custom') {
      return 'views/date/default.html';
    }
    return 'views/date/default.html';
  }
  return {
    scope: {
      ngModel: '=',
      exact: '=',
      maxDate: '=',
      minDate: '=',
      startView: '=',
      autoClose: '=',
      placeHolder: '=',
      form: '=',
      hasError: '='
    },
    templateUrl: getTemplate,
    restrict: 'E',
    controller: function($scope){
      $scope.exact = false;
      $scope.date = {};
    },
    link: function postLink(scope, element, attrs) {

      scope.id = 'date_' + uniqueId++;
      scope.placeHolderText = '(1-31-1700)';

      scope.$watch('exact', function(val) {
        if (val) {
          scope.exactPath = 'views/date/full.html'
          scope.placeHolderText = '(1-31-1700)';
        } else {
          scope.placeHolderText = '(1700)';
          scope.exactPath = 'views/date/partial.html'
        }
      })

      scope.$watch(function(){
        return scope.date.dateValue? scope.date.dateValue: scope.date.dateValue !== undefined;
      }, function(){
        scope.ngModel = scope.date.dateValue;
      })


      scope.$watch(function() {
        return scope.ngModel? scope.ngModel: scope.ngModel !== undefined;
      }, function(){
        scope.dateValue = scope.ngModel;
      });


      scope.getType = function(key) {
        return Object.prototype.toString.call(scope[key]);
      };
    }
  };
}]);
