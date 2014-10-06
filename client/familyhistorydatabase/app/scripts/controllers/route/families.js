'use strict';

app.controller('FamiliesCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.letter;
  if ($location.search()){
    $scope.letter = $location.search().letter? $location.search().letter: 'a';
  }  
}]);
