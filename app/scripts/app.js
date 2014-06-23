'use strict';

/**
* @ngdoc overview
* @name familyhistorydatabaseApp
* @description
* # familyhistorydatabaseApp
*
* Main module of the application.
*/

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
  ])
.config(function ($routeProvider, $asideProvider) {
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
});
