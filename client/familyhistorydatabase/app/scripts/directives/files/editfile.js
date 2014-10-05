'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/editIndividual
* @description
* # individual/editIndividual
*/
app.directive('editFile', ['business', function (Business) {
  return {
    scope: {
      id: '='
    },
    templateUrl: 'views/files/editFile.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      scope.getTagTypeahead = scope.$parent.getTagTypeahead;
      if (scope.id) {
        Business.file.getFileData(scope.id).then(function(result){
          // console.log('result', result)
          scope.file = result;
        });
      }
    }
  };
}]);
