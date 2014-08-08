'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:MainCtrl
* @description
* # MainCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('MainCtrl', ['$scope', 'business', function ($scope, Business) {



  $scope.dostuff = function() {
    $scope.$emit('$triggerEvent', '$triggerModal',   {
      "modalTitle": "Add an Individual",
      "modalBody": "views/individual/addindividual.html",
      "showFooter": false,
      "classes": [
      "fullmodal",
      "darkTheme"
      ]
    });
  }
}]);
