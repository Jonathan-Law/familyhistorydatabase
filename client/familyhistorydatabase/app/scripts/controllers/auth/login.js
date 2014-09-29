'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:AuthLoginCtrl
* @description
* # AuthLoginCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('AuthLoginCtrl', ['$scope', 'business', function ($scope, Business) {
  $scope.username = null;
  $scope.password = null;
  $scope.error    = false;
  $scope.submitLogin = function () {
    $scope.error = false;
    Business.user.login($scope.username, $scope.password).then(function(response){
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
