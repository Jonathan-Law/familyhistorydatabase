'use strict';

/**
* @ngdoc service
* @name familyhistorydatabaseApp.individualService
* @description
* # individualService
* Factory in the familyhistorydatabaseApp.
*/
app.factory('fileService', ['localCache', '$http', '$q', function (localCache, $http, $q) { /*jshint unused: false*/
  var service = {};

  service.getFileData = function (id){
    var deferred = $q.defer();
    if (id) {
      $http({
        method: 'GET',
        url: 'http://familyhistorydatabase.org/v2/api/v1/file/' + id,
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

  service.updateFile = function (data){
    var deferred = $q.defer();
    if (data) {
      $http({
        method: 'POST',
        url: 'http://familyhistorydatabase.org/v2/api/v1/file/update',
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

  service.getTypeahead = function(val, switchTrigger){
    var deferred = $q.defer();
    if (val) {
      var body;
      if (typeof val === 'object' && switchTrigger === 'place'){
        body = {
          method: 'GET',
          params: {
            'place': JSON.stringify(val)
          }
        };
        val = 'object';
        body.url = 'http://familyhistorydatabase.org/v2/api/v1/file/getTypeahead/'+val+'/'+switchTrigger;
      } else {
        body= {
          method: 'GET',
          url: 'http://familyhistorydatabase.org/v2/api/v1/file/getTypeahead/'+val+'/'+switchTrigger,
        };
      }
      $http(body).success(function(data, status, headers, config){
        if (data) {
          // console.log('data', data)
          for (var i = data.length - 1; i >= 0; i--) {
            if (data[i].title) {
              data[i].typeahead = data[i].title;
            }
          };
          deferred.resolve(data);
        }
      }).error(function(data, staus, headers, config){
        deferred.reject('The typeahead failed');
      })
    }
    return deferred.promise;
  }

  return service;
}]);
