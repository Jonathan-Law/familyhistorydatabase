'use strict';

/**
* @ngdoc service
* @name familyhistorydatabaseApp.individualService
* @description
* # individualService
* Factory in the familyhistorydatabaseApp.
*/
app.factory('individualService', ['localCache', '$http', '$q', function (localCache, $http, $q) { /*jshint unused: false*/
  var service = {};

  service.getIndData = function (id){
    var deferred = $q.defer();
    if (id) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/' + id,
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          deferred.resolve(data);
        } else {
          deferred.resolve([]);
        }
      });
    } else {
      deferred.resolve([]);
    }
    return deferred.promise;
  };

  service.updateIndData = function (data){
    console.warn('data', data);
    
    var deferred = $q.defer();
    if (data) {
      $http({
        method: 'POST',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/',
        data: data
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          deferred.resolve(data);
        } else {
          deferred.resolve(false);
        }
      });
    } else {
      deferred.resolve(false);
    }
    return deferred.promise;
  };

  service.getProfilePic = function (picId){
    var deferred = $q.defer();
    if (picId) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/profilePic/'+ picId,
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          deferred.resolve(data);
        } else {
          deferred.resolve(false);
        }
      });
    } else {
      deferred.resolve(false);
    }
    return deferred.promise;
  };
  service.getProfilePicByPersonId = function (personId){
    var deferred = $q.defer();
    if (personId) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/profilePic/person/'+ personId,
      }).success(function(data, status, headers, config) {
        if (data !== "false") {
          deferred.resolve(data);
        } else {
          deferred.resolve(false);
        }
      });
    } else {
      deferred.resolve(false);
    }
    return deferred.promise;
  };

  return service;
}]);
