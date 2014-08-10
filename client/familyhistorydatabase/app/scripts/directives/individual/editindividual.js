'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/editIndividual
* @description
* # individual/editIndividual
*/
app.directive('editIndividual', function () {
  return {
    templateUrl: 'views/individual/addIndividual.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
    }
  };
});
