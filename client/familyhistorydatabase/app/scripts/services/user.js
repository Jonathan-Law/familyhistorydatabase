'use strict';

/**
* @ngdoc service
* @name familyhistorydatabaseApp.user
* @description
* # user
* Factory in the familyhistorydatabaseApp.
*/
app.factory('userService', ['localCache', '$http', '$q', function (localCache, $http, $q) { /*jshint unused: false*/
  var user = {};

  user.getUserInfo = function() {
    $http({
      method: 'GET',
      url: 'http://familyhistorydatabase.org/v2/api/v1/user/'
    }).success(function(data, status, headers, config) {
      // console.log('data', data);

    });
  };

  user.login = function() {
    $http({
      method: 'POST',
      url: 'http://familyhistorydatabase.org/v2/api/v1/user/login',
      data: {
        username: 'jonlaw88',
        password: 'Vivitronn'
      },
      headers: {'Content-Type': 'application/json'}
    }).success(function(data, status, headers, config) {
      // console.log('Data', data);
    });
  };


  user.logout = function() {
    $http({
      method: 'POST',
      url: 'http://familyhistorydatabase.org/v2/api/v1/user/logout',
      data: {},
      headers: {'Content-Type': 'application/json'}
    }).success(function(data, status, headers, config) {
      // console.log('Data', data);
      // delete_cookie('MYPHPSESSID');
    });
  };

  return user;
}]);
