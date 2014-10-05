'use strict';

app.controller('FileEditFileCtrl', ['$rootScope', '$scope', '$timeout', 'business', function ($rootScope, $scope, $timeout, Business) {
  $scope.result = {};
  $scope.$parent.$watch('file', function(file){
    if (file) {
      console.log('file', file)
      
      $scope.file = $scope.$parent.file;
      $scope.backup = $scope.file;
    }
  });

  $scope.cancel = function(){
    $scope.$emit('$triggerEvent', '$triggerModalClose');
  }

}]);
