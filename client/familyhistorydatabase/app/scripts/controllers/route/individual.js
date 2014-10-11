'use strict';

app.controller('IndividualCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.family = null;
  $scope.famLetter = null;
  $scope.letter = null;
  $scope.individual = null;
  $scope.setFocus = false;
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
          $scope.links = {};
          $scope.links.letter = $scope.data.lastName.charAt(0);
          $scope.links.family = $scope.data.lastName;
          $scope.links.individual = $scope.data;
        } else {
          $scope.noData = 'We could not grab the individual\'s data.';
        }
      }, function() {
        $scope.noData = 'We could not grab the individual\'s data.';
      });
    }
  });

  $scope.$watch('openFam', function() {
    if (!$scope.openFam) {
      $scope.setFocus = true;
    }
  })
  $scope.$watch('openInd', function() {
    if (!$scope.openFam) {
      $scope.setFocus = true;
    }
  })

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
