'use strict';

app.controller('LastnamesCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.family;
  $scope.famLetter = '';
  $scope.letter = null;
  if ($location.search()){
    $scope.family = $location.search().family? $location.search().family: null;
    if ($scope.family === null) {
      $scope.goBackToLetter('a');
    }
  }
  $scope.$watch('letter', function() {
    if ($scope.letter) {
      $scope.goBackToLetter($scope.letter);
    }
  });

  $scope.$watch('family', function() {
    if ($scope.family) {
      Business.individual.getFirstNames($scope.family).then(function(result) {
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

  $scope.goBackToLetter = function(letter) {
    $location.search({
      'letter': letter
    });
    $location.path('/families');
  }

  $scope.goToIndividual = function(individualId) {
    $location.search({
      'individual': individualId
    });
    $location.path('/individual');
  }


}]);
