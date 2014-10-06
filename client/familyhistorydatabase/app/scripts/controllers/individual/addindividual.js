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
    if (!(typeof d === 'object')) {
      d = new Date(d);
    }
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
  $scope.backup = false;
  $scope.result = {};
  $scope.$parent.$watch('person', function(person){
    if (person) {
      console.log('person', person);
      
      $scope.person = $scope.$parent.person;
      if ($scope.person.profile_pic && $scope.person.profile_pic !=="") {
        Business.individual.getProfilePic($scope.person.profile_pic).then(function(result){
          if (result) {
            $scope.profile_pic = result;
            console.log('result', result);
            
          }
        })
      }
      // console.log('person', $scope.person);
    }
  })

  var makeDate = function(dateObj) {
    console.log('date', dateObj);
    
    if (dateObj.year) {
      var date = '' + dateObj.year + '/';
      date = date + ((dateObj.month && dateObj.month !== '0')? dateObj.month + '/': '1' + '/');
      date = date + ((dateObj.day && dateObj.day !== '0')? dateObj.day: '1');
    }
    console.log('date', date);
    
    date = moment(date).toDate();
    return (checkDate(date));
  }


  $scope.$watch('person', function(person){
    
    if (person) {
      $scope.backup = person;      
      var date = null;
      if (person.birth) {
        date = makeDate(person.birth);
        if (date) {
          $scope.result.birthDate = new Date(date);
        }
        $scope.exactBirthDate = (person.birth.yearB && person.birth.yearB !== '0')? true: false;
        if (person.birth.birthPlace) {
          $scope.result.birthPlace  = person.birth.birthPlace;
        }
      }
      if (person.death) {
        date = makeDate(person.death);
        if (date) {
          $scope.result.deathDate = new Date(date);
        }
        $scope.exactDeathDate = (person.death.yearD && person.death.yearD !== '0')? true: false;
        if (person.death.deathPlace) {
          $scope.result.deathPlace = person.death.deathPlace;
        }
      }
      if (person.burial) {
        date = makeDate(person.burial);
        if (date) {
          $scope.result.burialDate = new Date(date);
        }
        $scope.exactBurialDate = (person.burial.yearB && person.burial.yearB !== '0')? true: false;
        if (person.burial.burialPlace) {
          $scope.result.burialPlace  = person.burial.burialPlace;
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
    var check = _.find($scope.result.parentList, {'id': id});
    var index = _.indexOf($scope.result.parentList, check);
    $scope.result.parentList.splice(index, 1);
  };

  $scope.removeSpouse = function(id) {
    var check = _.find($scope.result.spouseList, {'id': id});
    var index = _.indexOf($scope.result.spouseList, check);
    $scope.result.spouseList.splice(index, 1);
  };




  $scope.savePerson = function() {
    var data = {};
    // console.log('person', $scope.person);

    data.person = {};
    if ($scope.person) {
      data.person.id = $scope.person.id;
      data.person.profile_pic = $scope.person.profile_pic;
    } else {
      data.person.id = null;
      data.person.profile_pic = null;
    }
    if ($scope.person && $scope.person.birth) {
      data.birth = $scope.person.birth;
      data.birthPlace = $scope.person.birth.birthPlace? $scope.person.birth.birthPlace: {};
    } else {
      data.birth = {};
      data.birthPlace = {};
    }
    if ($scope.person && $scope.person.death) {
      data.death = $scope.person.death;
      data.deathPlace = $scope.person.death.deathPlace? $scope.person.death.deathPlace: {};
    } else {
      data.death = {};
      data.deathPlace = {};
    }
    if ($scope.person && $scope.person.burial) {
      data.burial = $scope.person.burial;
      data.burialPlace = $scope.person.burial.burialPlace? $scope.person.burial.burialPlace: {};
    } else {
      data.burial = {};
      data.burialPlace = {};
    }

    data.person.yearB = $scope.exactBirthDate? 1:0;
    data.person.yearD = $scope.exactDeathDate? 1:0;
    console.log('$scope.result.birthDate', $scope.result.birthDate);
    
    if ($scope.result.birthDate) {
      console.log('$data.birth', data.birth);
      console.log('$scope.result', $scope.result.birthDate);
      
      var date = new Date($scope.result.birthDate);
      if ($scope.exactBirthDate) {
        data.birth.day = date.getDate();
        data.birth.month = date.getMonth() + 1;
      } else {
        data.birth.day = 0;
        data.birth.month = 0;
      }
      data.birth.year = date.getFullYear();
      data.person.yearBorn = data.birth.year;
      data.birth.yearB = $scope.exactBirthDate;
      delete data.birth.birthPlace;
    }  else {
      // return;
    }
    if ($scope.result.deathDate) {
      var date = new Date($scope.result.deathDate);
      if ($scope.exactDeathDate) {
        data.death.day = date.getDate();
        data.death.month = date.getMonth() + 1;
      } else {
        data.death.day = 0;
        data.death.month = 0;
      }
      data.death.year = date.getFullYear();
      data.person.yearDead = data.death.year;
      data.death.yearD = $scope.exactDeathDate;
      delete data.death.deathPlace;
    } else {
      // return;
    }
    if ($scope.result.burialDate) {
      console.log($scope.result.burialDate);
      
      var date = new Date($scope.result.burialDate);
      if ($scope.exactBurialDate) {
        data.burial.day = date.getDate();
        data.burial.month = date.getMonth() + 1;
      } else {
        data.burial.day = 0;
        data.burial.month = 0;
      }
      data.burial.year = date.getFullYear();
      data.burial.yearB = $scope.exactBurialDate;
      delete data.burial.burialPlace;
    } else {
      data.burial = false;
    }
    if ($scope.result.birthPlace) {
      data.birthPlace.town = null;
      data.birthPlace.county = null;
      data.birthPlace.state = null;
      data.birthPlace.country = null;
      data.birthPlace = $scope.result.birthPlace
    } else {
      data.birthPlace = false;
    }
    if ($scope.result.deathPlace) {
      data.deathPlace.town = null;
      data.deathPlace.county = null;
      data.deathPlace.state = null;
      data.deathPlace.country = null;
      data.deathPlace = $scope.result.deathPlace
    } else {
      data.deathPlace = false;
    }
    if ($scope.result.burialPlace) {
      data.burialPlace.town = null;
      data.burialPlace.county = null;
      data.burialPlace.state = null;
      data.burialPlace.country = null;
      data.burialPlace = $scope.result.burialPlace
    } else {
      data.burialPlace = false;
    }
    if ($scope.result.firstName) {
      data.person.firstName = $scope.result.firstName;
    }
    if ($scope.result.middleName) {
      data.person.middleName = $scope.result.middleName;
    }
    if ($scope.result.lastName) {
      data.person.lastName = $scope.result.lastName;
    }
    if ($scope.result.sex) {
      data.person.sex = $scope.result.sex;
    }
    if ($scope.result.relationship) {
      data.person.relationship = $scope.result.relationship;
    }
    if ($scope.result.parentList) {
      data.parents = $scope.result.parentList;
    }
    if ($scope.result.spouseList) {
      var spouses = [];
      _.each($scope.result.spouseList, function(spouse){
        console.log('spouse', spouse);
        if (spouse.marriageDate){
          var marriageDate = {};
          var date = new Date(spouse.marriageDate);
          if ($scope.exactDeathDate) {
            marriageDate.day = date.getDate();
            marriageDate.month = date.getMonth() + 1;
          } else {
            marriageDate.day = null;
            marriageDate.month = null;
          }
          marriageDate.year = date.getFullYear();
          marriageDate.yearM = spouse.exactMarriageDate? true: false;
          spouse.marriageDate = marriageDate;
        }
        spouses.push(spouse);
      });
      
      data.spouse = spouses;
    }
    console.log('data', data);
    Business.individual.updateIndData(data).then(function(result){
      if (result) {
        // console.log('************Result************', result);
        
        if (!$scope.backup) {
          $scope.$broadcast('$RESETFORM');
          $scope.result.parentList = [];
          $scope.result.spouseList = [];
          $scope.result = {};
        }
        triggerAlert('Your individual\'s data was saved!!', 'addIndividual', '#globalModal', 5000);        
      }
    })

  }
}]);
