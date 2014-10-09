'use strict';

app.controller('IndividualCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.family = null;
  $scope.famLetter = null;
  $scope.letter = null;
  $scope.individual = null;
  $scope.checked = false;
  if ($location.search()){
    $scope.individual = $location.search().individual? $location.search().individual: null;
    if ($scope.individual === null) {
      $scope.goBackToLetter('a');
    }
  }

  $scope.$watch('individual', function() {
    if ($scope.individual) {
      Business.individual.getIndData($scope.individual).then(function(result) {
        if (result) {
          $scope.data = angular.copy(result);
        } else {
          $scope.noData = 'We could not grab the individual\'s data.';
        }
      }, function() {
        $scope.noData = 'We could not grab the individual\'s data.';
      });
    }
  });

  $scope.goBackToLetter = function(letter) {
    $location.search({
      'letter': letter
    });
    $location.path('/families');
  }

  $scope.goBackToFamily = function(familyName) {
    $location.search({
      'individual': familyName
    });
    $location.path('/individual');
  }

}]);
