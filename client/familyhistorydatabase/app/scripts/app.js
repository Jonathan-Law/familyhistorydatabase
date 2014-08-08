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
.run(['$rootScope', 'business', '$q', function($rootScope, Business, $q) {
  $rootScope.name = 'root';

  $rootScope.$on('$triggerEvent', function (event, eventtrigger, content){
    $rootScope.$broadcast(eventtrigger, content);
  });
  $rootScope.$on('$loggedIn', function (event, user){
    $rootScope.user = user;
  });
  $rootScope.$on('$loggedOut', function (event){
    $rootScope.user = null;
  });

  $rootScope.checkLogin = function() {
    return Business.user.checkLoggedIn();
  }
  $rootScope.log = function(message, variable) {
    console.log(message, variable);
  }
  $rootScope.getTypeahead = function(val) {
    return Business.getTypeahead(val);
  }

  $rootScope.checkLogin().then(function(response){
    if (response) {
      $rootScope.user = response;
    }
  });

}]);
