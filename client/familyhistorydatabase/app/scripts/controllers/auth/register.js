'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:AuthRegisterCtrl
* @description
* # AuthRegisterCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('AuthRegisterCtrl', ['$scope', 'business', function ($scope, Business) {
  $scope.username = null;
  $scope.password = null;
  $scope.error    = false;
  $scope.submitRegister = function () {
    $scope.error = false;
    Business.user.register($scope.username, $scope.password, $scope.email, $scope.first, $scope.last, $scope.gender).then(function(response){
      if (response) {
        $scope.$emit('$triggerEvent', '$LOGGEDIN', response);
        $scope.$emit('$triggerEvent', '$triggerModalClose');
      } else {
        $scope.error = true;
      }
    });
  };
  $scope.cancel = function() {
    $scope.$emit('$triggerEvent', '$triggerModalClose');
  };
}]);
