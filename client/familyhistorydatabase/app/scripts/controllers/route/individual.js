'use strict';

app.controller('IndividualCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.family = null;
  $scope.famLetter = null;
  $scope.letter = null;
  $scope.individual = null;
  $scope.setFocus = false;
  $scope.data = {};
  $scope.view = {};
  $scope.view.trigger = 'default';

  $scope.$watch('view', function(view){
    if (view && view.trigger) {
      console.log('view', view.trigger);
    }
  }, true);

  if ($location.search()){
    $scope.individual = $location.search().individual? $location.search().individual: null;
    $scope.view.trigger = $location.search().tab? $location.search().tab: null;
    if (!$location.search().tab) {
      var temp = $location.search();
      temp.tab = 'default';
      $location.search(temp);
    }
    if ($scope.individual === null) {
      $scope.goBackToLetter('a');
    }
  }

  $scope.cycleNext = function() {
    switch($scope.view.trigger){
      case 'photoAlbum':
      $scope.view.trigger = 'documents'
      break;
      case 'documents':
      $scope.view.trigger = 'default'
      break;
      case 'default':
      $scope.view.trigger = 'photoAlbum'
      break;
      default:
      $scope.view.trigger = 'default'
      break;
    }
  }

  $scope.getLoc = function() {
    switch($scope.view.trigger){
      case 'photoAlbum':
      return 'Photo Album'
      break;
      case 'documents':
      return 'Documents'
      break;
      default:
      return 'Home'
      break;
    }
  }

  $scope.changeTrigger = function(val) {
    $scope.view.trigger = val;
    var temp = $location.search();
    temp.tab = val;
    $location.search(temp);
  }

  $scope.triggerChartResize = function(){
    $scope.$emit('$TRIGGEREVENT', '$CHARTRESIZE');
  }

  $scope.addToSearch = function(attribute, value) {
    var search = $location.search();
    search[attribute] = value;
    $location.search(search);
  }

  $scope.$watch('individual', function() {
    if ($scope.individual) {
      Business.individual.getIndData($scope.individual).then(function(result) {
        if (result) {
          $scope.data = angular.copy(result);
          $scope.pretty = JSON.stringify($scope.data, null, 4);
          $scope.links = {};
          $scope.links.letter = $scope.data.lastName.charAt(0);
          $scope.links.family = $scope.data.lastName;
          $scope.links.individual = $scope.data;
          Business.individual.getProfilePicByPersonId(result.id).then(function(profilePicture){
            $scope.data.profilePicture = profilePicture;
          })
        } else {
          $scope.noData = 'We could not grab the individual\'s data.';
        }
      }, function() {
        $scope.noData = 'We could not grab the individual\'s data.';
      });
      Business.individual.getPictures($scope.individual).then(function(result){
        $scope.pictures = result? result: [];
      }, function(){
        $scope.pictures = [];
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
