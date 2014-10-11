'use strict';

app.directive('breadcrumbs', ['$location', function ($location) {
  return {
    templateUrl: 'views/individual/breadcrumbs.html',
    restrict: 'A',
    scope:{
      ngModel: "="
    },
    link: function postLink(scope, element, attrs) {

      scope.goToLetter = function() {
        if (scope.ngModel && scope.ngModel.letter) {
          $location.search({
            'letter': scope.ngModel.letter
          });
          $location.path('/families');
        }
      }

      scope.goToFamily = function() {
        if (scope.ngModel && scope.ngModel.family) {
          $location.search({
            'family': scope.ngModel.family
          });
          $location.path('/lastnames');
        }
      }

      scope.goToIndividual = function() {
        if (scope.ngModel && scope.ngModel.individual) {
          $location.search({
            'individual': scope.ngModel.individual.id
          });
          $location.path('/individual');
        }
      }
    }
  }
}]);
