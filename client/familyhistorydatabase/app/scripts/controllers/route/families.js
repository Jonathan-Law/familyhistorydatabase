'use strict';

app.controller('FamiliesCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.letter;
  if ($location.search()){
    $scope.letter = $location.search().letter? $location.search().letter: 'a';
  }
  $scope.names = [];
  $scope.noNames = '';

  $scope.$watch('letter', function() {
    if ($scope.letter) {
      Business.individual.getFamilies($scope.letter).then(function(result) {
        if (result) {
          $scope.names = angular.copy(result); 
        } else {
        $scope.noNames = 'There are currently no individuals in our database with a last name starting with \''+$scope.letter+'\'.';
        }
      }, function() {
        $scope.noNames = 'There are currently no individuals in our database with a last name starting with \''+$scope.letter+'\'.';
      });
    }
  });

  $scope.goToFamily = function(name){
    $location.search({
      'family': name
    });
    $location.path('/lastnames');
  }

}]);
