'use strict';

app.controller('FileEditFileCtrl', ['$rootScope', '$scope', '$timeout', 'business', function ($rootScope, $scope, $timeout, Business) {
  $scope.result = {};
  $scope.$parent.$watch('file', function(file){
    if (file) {
      // console.log('file', file)
      
      $scope.file = $scope.$parent.file;
      $scope.backup = angular.copy($scope.file);
    }
  });

  $scope.$parent.$watch('getTagTypeahead', function(func){
    if (func) {
      $scope.getTagTypeahead = $scope.$parent.getTagTypeahead;
    }
  });

  $scope.cancel = function(){
    $scope.$emit('$triggerEvent', '$triggerModalClose');
  }

  $scope.save = function() {
    var file = angular.copy($scope.file);
    delete file.newName;
    Business.file.updateFile(file).then(function(result){
      if (result) {
        triggerAlert('Your changes were saved', 'editModal', '#globalModal', 5000);
      }
    });
  }

  $scope.reset = function() {
    $scope.file = angular.copy($scope.backup);
  }

}]);
