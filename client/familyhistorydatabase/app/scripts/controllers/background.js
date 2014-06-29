'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:BackgroundCtrl
* @description
* # BackgroundCtrl
* Controller of the familyhistorydatabaseApp
*/


/*global setupParallax*/

app.controller('BackgroundCtrl', ['$scope', function ($scope) {
  angular.element(document).ready(function () {
    setupParallax();
  });
  $scope.name = 'BackgroundCtrl';
}]);
