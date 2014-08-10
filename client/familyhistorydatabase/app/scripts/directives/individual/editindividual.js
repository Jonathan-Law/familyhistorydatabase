'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/editIndividual
* @description
* # individual/editIndividual
*/
app.directive('editIndividual', ['business', function (Business) {
  return {
    scope: {
      id: '='
    },
    templateUrl: 'views/individual/addindividual.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      if (scope.id) {
        Business.individual.getIndData(scope.id).then(function(result){
          scope.person = result;
        });
      }
    }
  };
}]);
