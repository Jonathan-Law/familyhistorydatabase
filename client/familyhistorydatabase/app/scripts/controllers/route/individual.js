'use strict';

app.controller('IndividualCtrl', ['$scope', '$location', 'business', '$timeout', function ($scope, $location, Business, $timeout) {
  $scope.family = null;
  $scope.famLetter = null;
  $scope.letter = null;
  $scope.individual = null;
  $scope.setFocus = false;
  $scope.data = {};
  $scope.view = {};
  $scope.view.trigger = 'default';
  $scope.spouses = [];
  $scope.spouse = null;
  $scope.currentSpouse = 0;
  $scope.$broadcast('$UNLOAD', 'childLoader');

  $scope.$watch('view', function(view){
    if (view && view.trigger) {
      // console.log('view', view.trigger);
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
      $scope.changeTrigger('documents')
      break;
      case 'documents':
      $scope.changeTrigger('default')
      break;
      case 'default':
      $scope.changeTrigger('photoAlbum')
      break;
      default:
      $scope.changeTrigger('default')
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

  function compareDisplayNames(a,b) {
    // console.log('a', a);
    // console.log('b', b);
    
    return ((a.displayableName == b.displayableName) ? 0 : ((a.displayableName > b.displayableName) ? 1 : -1));
  }

  $scope.getIndData = function(id, ind) {
    if (ind) {
      Business.individual.getIndData(id).then(function(result) {
        if (result) {
          $scope.data = angular.copy(result);
          console.log('data', $scope.data);
          $scope.data.birth = utils.date.set($scope.data.birth);
          $scope.data.death = utils.date.set($scope.data.death);
          $scope.data.burial = utils.date.set($scope.data.burial);
          $scope.pretty = JSON.stringify($scope.data, null, 4);
          $scope.links = {};

          $scope.links.letter = $scope.data.lastName.charAt(0);
          $scope.links.family = $scope.data.lastName;
          $scope.links.individual = $scope.data;
          
          console.log('Links', $scope.links)
          $scope.getSpouses($scope.data.spouse);
        } else{ //
          $scope.noData = 'We could not grab the individual\'s data.';
        }
      }, function() {
        $scope.noData = 'We could not grab the individual\'s data.';
      });
    } else {
      return Business.individual.getIndData(id);
    }
  } //

  $scope.getChildren = function(father, mother){
    Business.individual.getChildren(father, mother).then(function(result){
      // console.log('children', result);
    })
  }

  $scope.getSpouses = function(spouses) {
    $scope.$broadcast('$LOAD', 'spouseLoader');
    setTimeout(function(){
      var total = spouses.length;
      if (spouses.length) {

        _.each(spouses, function(spouse){
          $scope.getIndData(spouse.personId, false).then(function(result){
            result.displayName = true;
            result? $scope.spouses.push(result) : '';
            if (!(--total)) {
              $('#spouseHolder').css('width', 10000);
              setTimeout(function(){
                $('#spouseHolder').css('width', $('#spouseHolderInner').width() + 10);
                $scope.spouses = $scope.spouses.sort(compareDisplayNames);
                $scope.setKids($scope.spouses[0]);
                $scope.$broadcast('$UNLOAD', 'spouseLoader');
                $scope.$apply();
              }, 1000)
            //stop the loading. 
          }
        }, function() {
          $scope.$broadcast('$UNLOAD', 'spouseLoader');
        });
        });
      } else {
        $scope.spouses = $scope.spouses.sort(compareDisplayNames);
        $scope.setKids(null);
        $scope.$broadcast('$UNLOAD', 'spouseLoader');
        $scope.$apply();
      }
    }) 
    return; //
  }

  $scope.setKids = function(spouse){
    $scope.$broadcast('$LOAD', 'childLoader');
    if (spouse) {
      $scope.spouse = spouse;
      // console.log('spouse', $scope.spouse);
      // console.log('individual', $scope.data);
      Business.individual.getChildren($scope.data.id, $scope.spouse.id).then(function(result){
        // console.log('result', result);
        result = result.sort(compareDisplayNames);
        _.each(result, function(child){
          child.displayName = true
        });
        $scope.children = result;
        $timeout(function(){
          $scope.$broadcast('$UNLOAD', 'childLoader');
        },500)
      },function(){
        // console.log('Children call failed');
      })
    } else {
      $scope.$broadcast('$UNLOAD', 'childLoader');
    }
  }

  $scope.$watch('individual', function() {
    if ($scope.individual) {
      $scope.getIndData($scope.individual, true);
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
