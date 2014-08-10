'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:MainCtrl
* @description
* # MainCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('MainCtrl', ['$scope', 'business', function ($scope, Business) {

  var convertDate = function (v) {
    var d = v? new Date(v): new Date();
    var curr_date  = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year  = d.getFullYear();
    return curr_month + "/" + curr_date + "/" + curr_year;
  };
  $scope.newDate = moment('1700-1-1').toDate();

  $scope.dostuff = function() {
    $scope.$emit('$triggerEvent', '$triggerModal',   {
      "modalTitle": "Add an Individual",
      "modalBodyContent": "<edit-individual></edit-individual>",
      "showFooter": false,
      "classes": [
      "fullmodal",
      "darkTheme"
      ]
    });
  }
}]);
