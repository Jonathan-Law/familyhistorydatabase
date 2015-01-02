'use strict';

app.directive('documents', ['business', '$timeout', function (Business, $timeout) {
  return {
    templateUrl: 'views/individual/documents.html',
    restrict: 'A',
    scope: {
      id: '='
    },
    link: function postLink(scope, element, attrs) {
      scope.$broadcast('$LOAD', 'documentsLoader');

      scope.getDate = function(date) {
         return utils.getDate(date)
      }

      Business.individual.getDocuments(scope.id).then(function(result){
        if (result) {
          scope.$broadcast('$UNLOAD', 'documentsLoader');
          console.log('result', result);
          scope.documents = result;
        } else {
          scope.documents = [];
          scope.$broadcast('$UNLOAD', 'documentsLoader');
        }
      }, function() {
        scope.documents = [];
        scope.$broadcast('$UNLOAD', 'documentsLoader');
      })
    }
  };
}]);
