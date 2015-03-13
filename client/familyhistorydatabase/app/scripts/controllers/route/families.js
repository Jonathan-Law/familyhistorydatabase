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
      var search = $location.search();
      search.letter = $scope.letter;
      $location.search(search);
      Business.individual.getFamilies($scope.letter, true).then(function(result) {
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

  $scope.getNames = function(index) {
    if (index !== null && $scope.names && $scope.names.length > 0) {
      var offset = 1;
      if ($scope.names.length > 30) {
        if (index === 0) {
          offset = 0;
        }
        return $scope.names.slice(($scope.names.length / 3) * index + offset, ($scope.names.length / 3) * (index + 1) + 1);
      } else if ($scope.names.length > 15) {
        if (index === 0) {
          offset = 0;
        }
        return $scope.names.slice(($scope.names.length / 2) * index + offset, ($scope.names.length / 2) * (index + 1) + 1);
      } else {
        return $scope.names;
      }
    } else if ($scope.names) {
      if ($scope.names.length > 30) {
        return new Array(3);
      } else if ($scope.names.length > 15) {
        return new Array(2);
      } else {
        return new Array(1);
      }
    }
  }

  $scope.goToFamily = function(name){
    $location.search({
      'family': name
    });
    $location.path('/lastnames');
  }

}]);
