'use strict';
(function (window) {

  // attach myLibrary as a property of window
  var utils = window.utils || (window.utils = {});

  // BEGIN API

  utils.httpObj = {
    method:'',
    url:'',
    promise:{},
    data: {},
    params: {},
    saveName: ''
  }

  // converts a string into a Date object and then into a readable string.
  utils.getDate = function(date){
    if (date)
    {
      var d = new Date(date);
      var currDate = d.getDate();
      var currMonth = d.getMonth();
      var currYear = d.getFullYear();
      return ((currMonth + 1) + '/' + currDate + '/' + currYear);
    }
    return null;
  };

  // function to convert an object with parameters that translate to strings
  utils.toParamString = function(obj){
    var queryParams = "";
    for (var key in obj) {
      if (obj.hasOwnProperty(key)) {
        var val = obj[key];
        // if the value is a clean string and has a value, we know we want it.
        if (val !== null && (typeof val === 'string' || typeof val === 'number')){
          if (!queryParams.length) {
            queryParams += key + '=' + encodeURIComponent(val);
          } else{
            queryParams += '&' + key + '=' + encodeURIComponent(val);
          }
        }
      }
    }
    return queryParams;
  }

  // END API
  utils.RE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  utils.EMAIL_REGEXP = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i;
  
  utils.MONTHS = new Array('January', 'February', 'March',
    'April', 'May', 'June', 'July', 'August', 'September',
    'October', 'November', 'December');
  
})(window);