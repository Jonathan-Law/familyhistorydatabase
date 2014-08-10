'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:IndividualAddindividualCtrl
* @description
* # IndividualAddindividualCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('IndividualAddindividualCtrl', ['$rootScope', '$scope', '$timeout', 'business', function ($rootScope, $scope, $timeout, Business) {

  // $scope.result.birthDate = moment('1700-1-1').toDate();
  // $scope.result.deathDate = moment('1700-1-1').toDate();
  // $scope.result.burialDate = moment('1700-1-1').toDate();
  var convertDate = function (v) {
    var d = v? new Date(v): new Date();
    var curr_date  = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year  = d.getFullYear();
    return curr_month + "/" + curr_date + "/" + curr_year;
  };

  var checkDate = function(d){
    if ( Object.prototype.toString.call(d) === "[object Date]" ) {
      // it is a date
      if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
        // date is not valid
        return null;
      }
      else {
        return d;
      }
    }
    else {
      // not a date
      return null;
    }
  }

  $scope.result = {};
  $scope.$parent.$watch('person', function(person){
    if (person) {
      $scope.person = $scope.$parent.person;
      console.log('person', $scope.person);
    }
  })

  var makeDate = function(dateObj) {
    var date = '' + dateObj.year + '/' + dateObj.month + '/' + dateObj.day;
    date = moment(date).toDate();
    return (checkDate(date));
  }


  $scope.$watch('person', function(person){
    if (person) {
      var date = null;
      if (person.birth) {
        date = makeDate(person.birth);
        if (date) {
          $scope.result.birthDate = new Date(date);
        }
      }
      if (person.death) {
        date = makeDate(person.death);
        if (date) {
          $scope.result.deathDate = new Date(date);
        }
      }
      if (person.burial) {
        date = makeDate(person.burial);
        if (date) {
          $scope.result.burialDate = new Date(date);
        }
      }
      if (person.firstName) {
        $scope.result.firstName = person.firstName;
      }
      if (person.middleName) {
        $scope.result.middleName = person.middleName;
      }
      if (person.lastName) {
        $scope.result.lastName = person.lastName;
      }
      if (person.sex) {
        $scope.result.sex = person.sex;
      }
      if (person.relationship) {
        $scope.result.relationship = person.relationship;
      }

      if (person.parents) {
        _.each(person.parents, function(parent){
          Business.individual.getIndData(parent.parentId).then(function(result){
            if (result) {
              $scope.result.parentList.push(result);
            }
          })
        })
      }
      if (person.spouse) {
        _.each(person.spouse, function(spouse){
          Business.individual.getIndData(spouse.personId).then(function(result){
            if (result) {
              $scope.result.spouseList.push(result);
            }
          })
        })
      }
    }
  });

  $scope.exactBirthDate     = false;
  $scope.exactDeathDate     = false;
  $scope.exactBurialDate    = false;
  $scope.parents            = null;
  $scope.spouse             = null;
  $scope.result.parentList  = [];
  $scope.result.spouseList  = [];

  $scope.biHasChanged = -1;
  $scope.deHasChanged = -1;
  $scope.buHasChanged = -1;


  $scope.getTypeahead = $rootScope.getTypeahead;


  $scope.$watch(function(){
    return $scope.result.birthDate;
  }, function() {
    $scope.biHasChanged++;

    $timeout(function() {
      var d = checkDate($scope.result.birthDate);
      if (d) {
        $scope.minDeath = convertDate(d);
      } else {
        $scope.result.birthDate = null;
      }
    });
  }, true);

  $scope.$watch(function(){
    return $scope.result.deathDate;
  }, function() {
    $scope.deHasChanged++;
    $timeout(function() {
      var d = checkDate($scope.result.deathDate);
      if (d) {
        $scope.minBurial = convertDate(d);
      } else {
        $scope.result.deathDate = null;
      }
    });
  }, true);

  $scope.$watch(function(){
    return $scope.result.burialDate;
  }, function(d) {
    $scope.buHasChanged++;
    $timeout(function() {
      var d = checkDate($scope.result.burialDate);
      if (d) {
      } else {
        $scope.result.burialDate = null;
      }
    });
  }, true);



  $scope.onSelectParent = function(item, model, something) {
    if (typeof $scope.parents === 'object' && $scope.parents){
      Business.individual.getIndData($scope.parents.id).then(function(result) {
        $scope.result.parentList.push(result);
        // console.log('Typeahead Item Found: ', $scope.parents);
        console.log('Individual: ', result);
        $scope.parents = '';
      });
    } else {
      // console.log('searchKey', $scope.searchKey);
    }
  };
  $scope.onSelectSpouse = function(item, model, something) {
    if (typeof $scope.spouse === 'object' && $scope.spouse){
      Business.individual.getIndData($scope.spouse.id).then(function(result) {
        $scope.result.spouseList.push(result);
        // console.log('Typeahead Item Found: ', $scope.spouse);
        console.log('Individual: ', result);
        $scope.spouse = '';
      });
    } else {
      // console.log('searchKey', $scope.searchKey);
    }
  };


  $scope.removeParent = function(id) {
    console.log('Individual: ', id);
  };
  $scope.removeSpouse = function(id) {
    console.log('Individual: ', id);
  };




  $scope.savePerson = function() {
    console.log('birthdate', $scope.result.birthDate);
    console.log('deathDate', $scope.result.deathDate);
    console.log('burialDate', $scope.result.burialDate);
    console.log('firstName', $scope.result.firstName);
    console.log('middleName', $scope.middleName);
    console.log('lastName', $scope.lastName);
  }
}]);
