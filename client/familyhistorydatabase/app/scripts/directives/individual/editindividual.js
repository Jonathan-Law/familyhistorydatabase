'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/editIndividual
* @description
* # individual/editIndividual
*/
app.directive('editIndividual', ['business', '$timeout', '$location', function (Business, $timeout, $location) {
  return {
    scope: {
      id: '=',
      maintain: '='
    },
    templateUrl: 'views/individual/addindividual.html',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      
      scope.refreshData = function(){
        console.log('scope', scope);
        scope.person = {};
        $timeout(function(){
          if (scope.id) {
            Business.individual.getIndData(scope.id, true).then(function(result){
              scope.person = angular.copy(result);
            });
          }
        })
      }

      scope.$on('$triggerModal', function(){
        console.log('this was triggered');
        
        scope.refreshData();
      })

      scope.activateSubmission = function(id){
        Business.individual.activateSubmission(id).then(function(){
          $timeout(function(){
            scope.refreshData();
          });
        })
      }
      scope.deactivateSubmission = function(id){
        Business.individual.deactivateSubmission(id).then(function(){
          $timeout(function(){
            scope.refreshData();
          });
        })
      }

      scope.refreshData();
      scope.closeModal = function(path, search){
        scope.$emit('$TRIGGEREVENT', '$triggerModalClose');
        $location.path(path);
        $location.search(search);
      }
    }
  };
}]);
