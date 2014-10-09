'use strict';

app.controller('AdminEditCtrl', ['$scope', 'business', '$location', function ($scope, Business, $location) {
  if (!Business.user.getIsAdmin()) {
    $location.path('/');
  }
  $scope.$on('$LOGOUT', function() {
    $location.path('/');
  })

  $scope.goTo = function(path) {
    $location.search({});
    $location.path(path);
  }

  $scope.searchTypes = [
  {name:'Title and Comments', value:'default'},
  {name:'Person Tag', value:'person'},
  {name:'Place Tag', value:'place'},
  {name:'Collection Tag', value:'collection'},
  ];
  $scope.fileSearchType = $scope.searchTypes[0];

  $scope.individual;
  $scope.file;

  $scope.deleteInd = function(ind){
    var cont = confirm("Delete this individual?\n"+ind.typeahead+"\nIndividual ID: "+ind.id);
    if (cont) {
      Business.individual.deleteInd(ind.id).then(function(result){
        console.log('result', result);
      });
    }
  }

}]);
