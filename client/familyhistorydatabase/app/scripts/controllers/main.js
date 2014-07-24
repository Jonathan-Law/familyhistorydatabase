'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:MainCtrl
* @description
* # MainCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('MainCtrl', ['$scope', 'business', function ($scope, Business) {
  $scope.awesomeThings = [
  'HTML5 Boilerplate',
  'AngularJS',
  'Karma'
  ];

  Business.user.login();

}]);
