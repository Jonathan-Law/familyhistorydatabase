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
      hasError: '=',
      isRequire: '='
    },
    templateUrl: getTemplate,
    restrict: 'E',
    controller: ['$scope', function($scope){
      $scope.exact = true;
      $scope.date = {};
    }],
    link: function postLink(scope, element, attrs) {

      scope.$on('$RESETFORM', function() {
        scope.date.dateValue = '';
      })

      scope.id = 'date_' + uniqueId++;
      scope.placeHolderText = '(1-31-1700)';

      scope.$watch('exact', function(val) {
        if (val) {
          scope.exactPath = 'views/date/full.html'
          scope.placeHolderText = '(MM-DD-YYYY Make sure to use dashes "-")';
        } else {
          scope.placeHolderText = '(YYYY)';
          scope.exactPath = 'views/date/partial.html'
        }
      })

      scope.$watch(function(){
        return scope.date.dateValue? scope.date.dateValue: scope.date.dateValue !== undefined;
      }, function(){
        scope.ngModel = scope.date.dateValue;
      });


      var convertDate = function (v) {
        var d = v? new Date(v): new Date();
        var curr_date  = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year  = d.getFullYear();
        return curr_month + "/" + curr_date + "/" + curr_year;
      };

      var checkDate = function(d){
        if ( Object.prototype.toString.call(d) === "[object Date]" ) {
          // it is a date
          if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
            // date is not valid
            return null;
          }
          else {
            return d;
          }
        }
        else {
          // not a date
          return null;
        }
      }

      scope.$watch(function() {
        return scope.ngModel? scope.ngModel: scope.ngModel !== undefined;
      }, function(){
        var d = checkDate(scope.ngModel);
        if (d) {
          scope.date.dateValue = scope.ngModel;
        } 
      }, true);


      scope.getType = function(key) {
        return Object.prototype.toString.call(scope[key]);
      };
    }
  };
}]);
