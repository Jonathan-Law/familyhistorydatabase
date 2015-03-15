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
  user.isLoggedIn = false;
  user.getUserInfo = function() {
    var deferred = $q.defer();
    $http({
      method: 'GET',
      url: '/api/v1/user/'
    }).success(function(data, status, headers, config) {
      if (data) {
        user.userInfo = data;
        deferred.resolve(data);
      }
    }).error(function(){
      deferred.resolve(false);
    });
    return deferred.promise;
  };


  user.isLoggedInStill = function() {
    var deferred = $q.defer();
    $http.get('/api/v1/user/isLoggedIn')
    .success(function(data, status, headers, config){
      if (!data || data === 'false') {
        deferred.resolve(false);
      } else {
        user.isLoggedIn = true;
        deferred.resolve(true);
      }
    }).error(function(){
      deferred.resolve(false);
    })
    return deferred.promise;
  }

  user.getIsAdmin = function() {
    if (user) {
      if (!user.isLoggedIn) {
        return false;
      }
      var isAdmin = false;
      if (user.userInfo && user.userInfo.rights) {
        switch(user.userInfo.rights){
          case 'super':
          case 'admin':
          isAdmin = true;
          break;
          default:
          isAdmin = false;
          break;
        }
        return isAdmin;
      }
      return false;
    }
    return false;
  }

  user.getIsValidated = function() {
    if (!user.isLoggedIn) {
      return false;
    }
    var isValid = false;
    switch(user.userInfo.rights){
      case 'super':
      case 'admin':
      case 'high':
      case 'medium':
      isAdmin = true;
      break;
      default:
      isAdmin = false;
      break;
    }
    return isAdmin;
  }

  user.login = function(username, password) {
    var deferred = $q.defer();
    if (!username || !password) {
      deferred.resolve(false);
      console.error('You must include a username and password to login')
    } else {
      $http({
        method: 'POST',
        url: '/api/v1/user/login',
        data: {
          username: username,
          password: password
        },
        headers: {'Content-Type': 'application/json'}
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          user.userInfo = data;
          user.isLoggedIn = true;
          deferred.resolve(data);
        } else {
          deferred.resolve(false);
        }
      });
    }
    return deferred.promise;
  };

  user.register = function(username, password, email, first, last, gender) {
    var deferred = $q.defer();
    if (!username || !password) {
      deferred.resolve(false);
      console.error('You must include a username and password to register')
    } else {
      $http({
        method: 'POST',
        url: '/api/v1/user/register',
        data: {
          username: username? username: null,
          password: password? password: null,
          email: email? email: null,
          first: first? first: null,
          last: last? last: null,
          gender: gender? gender: null
        },
        headers: {'Content-Type': 'application/json'}
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          user.isLoggedIn = true;
          deferred.resolve(data);
        } else {
          deferred.resolve(false);
        }
      });
    }
    return deferred.promise;
  };

  user.checkLoggedIn = function() {
    return user.isLoggedInStill();
  };


  user.logout = function() {
    $http({
      method: 'POST',
      url: '/api/v1/user/logout',
      data: {},
      headers: {'Content-Type': 'application/json'}
    }).success(function(data, status, headers, config) {
      user.isLoggedIn = false;
    });
  };

  return user;
}]);
