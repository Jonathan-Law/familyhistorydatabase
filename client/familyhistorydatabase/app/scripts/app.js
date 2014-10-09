'use strict';

/**
* @ngdoc overview
* @name familyhistorydatabaseApp
* @description
* # familyhistorydatabaseApp
*
* Main module of the application.
*/

/*exported app*/

var app = angular
.module('familyhistorydatabaseApp', [
  'ngAnimate',
  'ngCookies',
  'ngResource',
  'ngRoute',
  'ngSanitize',
  'ngTouch',
  'ui.bootstrap',
  'mgcrea.ngStrap',
  'mgcrea.ngStrap.helpers.dateParser',
  'mgcrea.ngStrap.tooltip',
  'angulartics.google.analytics',
  'ngTagsInput',
  'pageslide-directive'
  ])
.config(['$routeProvider', '$asideProvider', '$httpProvider', function ($routeProvider, $asideProvider, $httpProvider) {
  $routeProvider
  .when('/', {
    templateUrl: 'views/main.html',
    controller: 'MainCtrl'
  })
  .when('/about', {
    templateUrl: 'views/about.html',
    controller: 'AboutCtrl'
  })
  .when('/admin', {
    templateUrl: 'views/admin.html',
    controller: 'AdminCtrl'
  })
  .when('/admin/add', {
    templateUrl: 'views/admin/addfiles.html',
    controller: 'AdminAddfilesCtrl'
  })
  .when('/admin/edit', {
    templateUrl: 'views/admin/edit.html',
    controller: 'AdminEditCtrl'
  })
  .when('/families', {
    templateUrl: 'views/route/families.html',
    controller: 'FamiliesCtrl'
  })
  .when('/lastnames', {
    templateUrl: 'views/route/lastnames.html',
    controller: 'LastnamesCtrl'
  })
  .when('/individual', {
    templateUrl: 'views/route/individual.html',
    controller: 'IndividualCtrl'
  })
  .otherwise({
    redirectTo: '/'
  });
  angular.extend($asideProvider.defaults, {
    container: 'body',
    html: true,
    animation: 'am-fadeAndSlideLeft',
    placement: 'left'
  });
  // $httpProvider.defaults.withCredentials = true;
}])
.run(['$rootScope', 'business', '$q', '$route', function($rootScope, Business, $q, $route) {
  $rootScope.$on('$routeChangeSuccess', function(){
    Business.user.isLoggedInStill().then(function(result){
      if (!result) {
        $rootScope.$broadcast('$NOTLOGGEDIN');
      }
    })
  })

  $rootScope.name = 'root';

  $rootScope.$on('$triggerEvent', function (event, eventtrigger, content){
    $rootScope.$broadcast(eventtrigger, content);
  });
  $rootScope.$on('$LOGGEDIN', function (event, user){
    $rootScope.user = user;
  });
  $rootScope.$on('$LOGOUT', function (event){
    $rootScope.user = null;
  });

  var setupTagVal = function(result) {
    var list = [];
    if (result && result.length > 0 && result[0].address_components) {
      _.each(result, function(response){
        if (response && response.address_components) {
          var temp = {};
          temp.town = response.address_components[0]? response.address_components[0].long_name: '';
          temp.county = response.address_components[1]? response.address_components[1].long_name: '';
          temp.state = response.address_components[2]? response.address_components[2].long_name: '';
          temp.country = response.address_components[3]? response.address_components[3].long_name: '';
          temp.text = response.formatted_address;
          list.push(temp);
        }
      });
    } else if (result && result.length > 0 && !result[0].text) {
      _.each(result, function(response){
        response.text = response.typeahead;
        list.push(response);
      });
    } else {
      list = result;
    }
    return list;
  }

  $rootScope.checkLogin = function() {
    return Business.user.checkLoggedIn();
  }
  $rootScope.log = function(message, variable) {
    console.log(message, variable);
  }
  $rootScope.getTypeahead = function(val) {
    return Business.getTypeahead(val);
  }
  $rootScope.getTypeaheadPlace = function(val) {
    return Business.getLocation(val);
  }
  $rootScope.getOtherTypeahead = function(val) {
    return Business.getOtherTypeahead(val);
  }
  $rootScope.getTagTypeahead = function(switchTrigger, val) {
    var deferred = $q.defer();
    var target = $rootScope.getTypeahead;
    if (switchTrigger) {
      if (switchTrigger === 'place') {
        target = $rootScope.getTypeaheadPlace;
      } else if (switchTrigger === 'other') {
        target = $rootScope.getOtherTypeahead;
      }
      if (target) {
        target(val).then(function(result){
          if (result && result.length > 0) {
            deferred.resolve(setupTagVal(result));
          } else {
            deferred.reject(false);
          }
        });
      } else {
        deferred.reject('Your target switch trigger doesn\'t exist');
      }
    } else {
      deferred.reject('You need to provide the switch trigger');
    }
    return deferred.promise;
  }

  $rootScope.getTagTypeaheadFiles = function(val, switchTrigger) {
    var deferred = $q.defer();
    if (val) {
      if (switchTrigger && switchTrigger === 'place'){
        Business.getLocation(val).then(function(result){
          val = setupTagVal(result);
          Business.file.getTypeahead(val, switchTrigger).then(function(result){
            if (result && result.length > 0) {
              deferred.resolve(result);
            } else {
              deferred.reject(false);
            }
          });
        })
      } else {
        Business.file.getTypeahead(val, switchTrigger).then(function(result){
          if (result && result.length > 0) {
            deferred.resolve(result);
          } else {
            deferred.reject(false);
          }
        });
      }
    } else {
      deferred.reject('Your target switch trigger doesn\'t exist');
    }
    return deferred.promise;
  }

  $rootScope.editIndividual = function(id) {
    var title = 'Edit This Individual';
    if (!id) {
      title = 'Add an Individual';
    }
    var content = '<edit-individual id="'+id+'"></edit-individual>';
    var body = {
      'modalTitle': title,
      'modalBodyContent': content,
      'showFooter': false,
      'classes': [
      'fullmodal',
      'darkTheme'
      ]
    }
    $rootScope.$broadcast('$triggerModal', body);
  }

  $rootScope.editFile = function(id) {
    if (id) {
      var title = 'Edit This File';
      var content = '<edit-file id="'+id+'"></edit-file>';
      var body = {
        'modalTitle': title,
        'modalBodyContent': content,
        'showFooter': false,
        'classes': [
        'fullmodal',
        'darkTheme'
        ]
      }
      $rootScope.$broadcast('$triggerModal', body);
    }
  }


  $rootScope.checkLogin().then(function(response){
    if (response) {
      $rootScope.user = response;
    }
  });

}]);
