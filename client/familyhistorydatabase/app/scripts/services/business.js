/*
* Copyright 2014 Jonathan Law
*
* Licensed under the Apache License, Version 2.0 (the 'License');
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an 'AS IS' BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
'use strict';

app.factory('business', ['localCache', '$http', '$q', 'userService', 'authService','individualService','fileService', function (localCache, $http, $q, UserService, AuthService, IndividualService, FileService) { /*jshint unused: false*/
  // 60 seconds until expiration
  var expireTime = 60 * 1000;
  var business = {};
  business.user = UserService;
  business.auth = AuthService;

  business.individual = IndividualService;
  business.file = FileService;

  business.getTypeahead = function(val) {
    return $http.get('http://familyhistorydatabase.org/v2/api/v1/typeahead/', {
      params: {
        typeahead: val,
        sensor: false
      }
    }).then(function(res){
      if (res.data !== 'false') {
        var typeahead = [];
        _.each(res.data, function(item){
          typeahead.push(item);
        });
        return typeahead;
      }
      return [];
    });
  };

  business.getLocation = function(val) {
    return $http.get('http://maps.googleapis.com/maps/api/geocode/json', {
      params: {
        address: val,
        sensor: false
      }
    }).then(function(res){
      var addresses = [];
      angular.forEach(res.data.results, function(item){
        addresses.push(item);
      });
      return addresses;
    });
  };

  business.getOtherTypeahead = function(val) {
    return $http.get('http://familyhistorydatabase.org/v2/api/v1/tags/other', {
      params: {
        typeahead: val,
        sensor: false
      }
    }).then(function(res){
      if (res.data !== 'false') {
        var typeahead = [];
        _.each(res.data, function(item){
          typeahead.push(item);
        });
        return typeahead;
      }
      return [];
    });
  };


  // var get_cookie = function (cname) {
  //   var name = cname + "=";
  //   var ca = document.cookie.split(';');
  //   for(var i=0; i<ca.length; i++) {
  //     var c = ca[i];
  //     while (c.charAt(0)==' '){
  //       c = c.substring(1);
  //     }
  //     if (c.indexOf(name) != -1) {
  //       return c.substring(name.length,c.length);
  //     }
  //   }
  //   return "";
  // };

  // var delete_cookie = function ( name, path, domain ) {
  //   if( get_cookie( name ) ) {
  //     document.cookie = name + "=" +
  //     ((path) ? ";path="+path:"")+
  //     ((domain)?";domain="+domain:"") +
  //     ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
  //   }
  // };

  return business;

}]);
