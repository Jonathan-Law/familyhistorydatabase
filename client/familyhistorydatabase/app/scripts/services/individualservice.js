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

  service.getPictures = function(id){
    var deferred = $q.defer();
    if (id) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/pictures/' + id,
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
  }

  service.updateIndData = function (data){
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
  service.getSpouses = function (spouseId, individualId){
    var deferred = $q.defer();
    if (spouseId && individualId) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/spouses/' + spouseId + '/' + individualId,
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
  service.getPlace = function (placeId){
    var deferred = $q.defer();
    if (placeId) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/place/' + placeId,
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

  service.deleteInd = function(id) {
    var deferred = $q.defer();
    if (id) {
      $http({
        method: 'DELETE',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/'+id
      }).success(function(data, status, headers, config){
        deferred.resolve(data);
      }).error (function(data, status, headers, config){
        deferred.reject('There was an error on the server.')
      })
    }
    return deferred.promise;
  }
  
  service.getFamilies = function(letter) {
    var deferred = $q.defer();
    if (letter) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/families/'+letter
      }).success(function(data, status, headers, config){
        deferred.resolve(data);
      }).error (function(data, status, headers, config){
        deferred.reject('There was an error on the server.')
      })
    }
    return deferred.promise;
  }

  service.getFirstNames = function(family) {
    var deferred = $q.defer();
    if (family) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/individual/familyNames/'+family
      }).success(function(data, status, headers, config){
        deferred.resolve(data);
      }).error (function(data, status, headers, config){
        deferred.reject('There was an error on the server.')
      })
    }
    return deferred.promise;
  }

  return service;
}]);
