'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:IndividualAddindividualCtrl
* @description
* # IndividualAddindividualCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('IndividualAddindividualCtrl', ['$scope', '$timeout', function ($scope, $timeout) {

  $scope.birthDate = moment('1700-1-1').toDate();
  $scope.deathDate = moment('1700-1-1').toDate();
  $scope.burialDate = moment('1700-1-1').toDate();
  $scope.exactBirthDate = false;
  $scope.exactDeathDate = false;
  $scope.exactBurialDate = false;
  var convertDate = function (v) {
    var d = v? new Date(v): new Date();
    var curr_date  = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year  = d.getFullYear();
    return curr_month + "/" + curr_date + "/" + curr_year;
  };

  $scope.$watch('birthDate', function() {
    console.log('birth');

    $timeout(function() {
      var d = $scope.birthDate;
      if ( Object.prototype.toString.call(d) === "[object Date]" ) {
        // it is a date
        if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
          // date is not valid
          $scope.birthDate = null;
        }
        else {
          $scope.minDeath = convertDate(d);
        }
      }
      else {
        // not a date
        $scope.birthDate = null;
      }
    });
  }, true);

  $scope.$watch('deathDate', function() {
    $timeout(function() {
      var d = $scope.deathDate;
      if ( Object.prototype.toString.call(d) === "[object Date]" ) {
        // it is a date
        if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
          // date is not valid
          $scope.deathDate = null;
        }
        else {
          // $scope.maxBirth = convertDate(d);
          $scope.minBurial = convertDate(d);
        }
      }
      else {
        // not a date
        $scope.deathDate = null;
      }
    });
  }, true);

  $scope.$watch('burialDate', function(d) {
    $timeout(function() {
      var d = $scope.burialDate;
      if ( Object.prototype.toString.call(d) === "[object Date]" ) {
        // it is a date
        if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
          // date is not valid
          $scope.burialDate = null;
        }
        else {
          // date is valid
          $scope.burialDate = d;
        }
      }
      else {
        // not a date
        $scope.burialDate = null;
      }
    });
  });


  $scope.savePerson = function() {
    console.log('birthdate', $scope.birthDate);
    console.log('deathDate', $scope.deathDate);
    console.log('burialDate', $scope.burialDate);
    console.log('firstName', $scope.firstName);
    console.log('middleName', $scope.middleName);
    console.log('lastName', $scope.lastName);

  }
}]);