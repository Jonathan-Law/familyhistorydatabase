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

  return service;
}]);
