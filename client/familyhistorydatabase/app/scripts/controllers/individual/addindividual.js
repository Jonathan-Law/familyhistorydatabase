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
        $scope.exactBirthDate = person.birth.yearB? true: false;
        if (person.birth.birthPlace) {
          var place = person.birth.birthPlace;
          $scope.result.birthPlace = {
            'formatted_address': ''+ place.town +', '+place.state+', '+place.country,
            'address_components': [
            {
              'long_name': place.town
            }, {
              'long_name': place.county
            }, {
              'long_name': place.state
            }, {
              'long_name': place.country
            }
            ]
          }
        }
      }
      if (person.death) {
        date = makeDate(person.death);
        if (date) {
          $scope.result.deathDate = new Date(date);
        }
        $scope.exactDeathDate = person.death.yearD? true: false;
        if (person.death.deathPlace) {
          var place = person.death.deathPlace;
          $scope.result.deathPlace = {
            'formatted_address': ''+ place.town +', '+place.state+', '+place.country,
            'address_components': [
            {
              'long_name': place.town
            }, {
              'long_name': place.county
            }, {
              'long_name': place.state
            }, {
              'long_name': place.country
            }
            ]
          }
        }
      }
      if (person.burial) {
        date = makeDate(person.burial);
        if (date) {
          $scope.result.burialDate = new Date(date);
        }
        $scope.exactBurialDate = person.burial.yearB? true: false;
        if (person.burial.burialPlace) {
          var place = person.burial.burialPlace;
          $scope.result.burialPlace = {
            'formatted_address': ''+ place.town +', '+place.state+', '+place.country,
            'address_components': [
            {
              'long_name': place.town
            }, {
              'long_name': place.county
            }, {
              'long_name': place.state
            }, {
              'long_name': place.country
            }
            ]
          }
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
    var data = {};
    console.log('person', $scope.person);

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
    if ($scope.result.birthDate) {
      if ($scope.exactBirthDate) {
        data.birth.day = $scope.result.birthDate.getDate();
        data.birth.month = $scope.result.birthDate.getMonth() + 1;
      } else {
        data.birth.day = null;
        data.birth.month = null;
      }
      data.birth.year = $scope.result.birthDate.getFullYear();
      data.person.yearBorn = data.birth.year;
      data.birth.yearB = $scope.exactBirthDate;
      delete data.birth.birthPlace;
    }
    if ($scope.result.deathDate) {
      if ($scope.exactDeathDate) {
        data.death.day = $scope.result.deathDate.getDate();
        data.death.month = $scope.result.deathDate.getMonth() + 1;
      } else {
        data.death.day = null;
        data.death.month = null;
      }
      data.death.year = $scope.result.deathDate.getFullYear();
      data.person.yearDead = data.death.year;
      data.death.yearD = $scope.exactDeathDate;
      delete data.death.deathPlace;
    }
    if ($scope.result.burialDate) {
      if ($scope.exactBurialDate) {
        data.burial.day = $scope.result.burialDate.getDate();
        data.burial.month = $scope.result.burialDate.getMonth() + 1;
      } else {
        data.burial.day = null;
        data.burial.month = null;
      }
      data.burial.year = $scope.result.burialDate.getFullYear();
      data.burial.yearB = $scope.exactBurialDate;
      delete data.burial.burialPlace;
    }
    if ($scope.result.birthPlace) {
      data.birthPlace.town = null;
      data.birthPlace.county = null;
      data.birthPlace.state = null;
      data.birthPlace.country = null;
      if (typeof $scope.result.birthPlace === 'object')
      {
        data.birthPlace.town = $scope.result.birthPlace.address_components[0].long_name;
        data.birthPlace.county = $scope.result.birthPlace.address_components[1].long_name;
        data.birthPlace.state = $scope.result.birthPlace.address_components[2].long_name;
        data.birthPlace.country = $scope.result.birthPlace.address_components[3].long_name;
      } else {
        var list = $scope.result.birthPlace.split(',');
        if (list.length < 4) {
          triggerAlert('There was an error.');
          return false;
        }
        data.birthPlace.town = list[0].trim();
        data.birthPlace.county = list[1].trim();
        data.birthPlace.state = list[2].trim();
        data.birthPlace.country = list[3].trim();
      }
    }
    if ($scope.result.deathPlace) {
      data.deathPlace.town = null;
      data.deathPlace.county = null;
      data.deathPlace.state = null;
      data.deathPlace.country = null;
      if (typeof $scope.result.deathPlace === 'object')
      {
        data.deathPlace.town = $scope.result.deathPlace.address_components[0].long_name;
        data.deathPlace.county = $scope.result.deathPlace.address_components[1].long_name;
        data.deathPlace.state = $scope.result.deathPlace.address_components[2].long_name;
        data.deathPlace.country = $scope.result.deathPlace.address_components[3].long_name;
      } else {
        var list = $scope.result.deathPlace.split(',');
        if (list.length < 4) {
          triggerAlert('There was an error.');
          return false;
        }
        data.deathPlace.town = list[0].trim();
        data.deathPlace.county = list[1].trim();
        data.deathPlace.state = list[2].trim();
        data.deathPlace.country = list[3].trim();
      }
    }
    if ($scope.result.burialPlace) {
      data.burialPlace.town = null;
      data.burialPlace.county = null;
      data.burialPlace.state = null;
      data.burialPlace.country = null;
      if (typeof $scope.result.burialPlace === 'object')
      {
        data.burialPlace.town = $scope.result.burialPlace.address_components[0].long_name;
        data.burialPlace.county = $scope.result.burialPlace.address_components[1].long_name;
        data.burialPlace.state = $scope.result.burialPlace.address_components[2].long_name;
        data.burialPlace.country = $scope.result.burialPlace.address_components[3].long_name;
      } else {
        var list = $scope.result.burialPlace.split(',');
        if (list.length < 4) {
          triggerAlert('There was an error.');
          return false;
        }
        data.burialPlace.town = list[0].trim();
        data.burialPlace.county = list[1].trim();
        data.burialPlace.state = list[2].trim();
        data.burialPlace.country = list[3].trim();
      }
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
    if ($scope.result.parents) {
      data.parents = $scope.result.parents;
    }
    if ($scope.result.spouse) {
      data.spouse = $scope.result.spouse;
    }
      console.log('data', data);
    Business.individual.updateIndData(data).then(function(result){
      console.log('data', result);
    })

  }
}]);
