'use strict';
(function (window) {

  // attach myLibrary as a property of window
  var utils = window.utils || (window.utils = {});

  // BEGIN API

  utils.httpObj = {
    method:'',
    url:'',
    data: {},
    params: {},
    saveName: ''
  }

  // converts a string into a Date object and then into a readable string.
  utils.getDisplayDate = function(date, text){
    if (date && !text) {
      var d = new Date(date);
      var currDate = d.getDate();
      var currMonth = d.getMonth();
      var currYear = d.getFullYear();
      return ((currMonth + 1) + '/' + currDate + '/' + currYear);
    } else if (date) {
      var d = new Date(date);
      var currDate = d.getDate();
      var currMonth = d.getMonth();
      var currYear = d.getFullYear();
      return (utils.MONTHS[currMonth] + ' ' + currDate + ', ' + currYear);
    }
    return null;
  };

  utils.date = {
    birthplace:{},
    day: 0,
    month: 0,
    yearh: 0,
    id: '',
    personId: '',
    yearB: false,
    date: false,
    set: function(rhs){
      if (rhs) {
        this.place = rhs.birthPlace? rhs.birthPlace: rhs.deathPlace? rhs.deathPlace: rhs.burialPlace? rhs.burialPlace : null;
        this.day = parseInt(rhs.day) || this.day;
        this.month = parseInt(rhs.month) || this.month;
        this.year = parseInt(rhs.year) || this.year;
        this.yearB = rhs.yearB === '1'? true: false;
        if (this.day && this.month && this.year) {
          this.date = new Date(this.year + '/' + this.month + '/' + this.day);
        }
        this.personId = rhs.personId || this.personId;
      }
      return angular.copy(this);
    },
    toString: function(format){
      if (this.date &&  Object.prototype.toString.call(this.date) === "[object Date]" ) {
        // it is a date
        if ( isNaN( this.date.getTime() ) ) {  // d.valueOf() could also work
          // date is not valid
        }
        else {
          // date is valid
          if (!format) {
            return utils.getDisplayDate(this.date, true);
          }
        }
      }
      else if (this.year) {
        if (this.yearB) {
          return this.year;
        } else {
          return 'About ' + this.year; 
        }
      }
    },
    getPlace: function(format){
      console.log('this', this);
      
      var result = '';
      if (this.place) {
        if (this.place.cemetary) {
          result += this.place.cemetary + ' (cemetary)';
        }
        if (this.place.town) {
          if (result.length) {
            result += ', '
          }
          result += this.place.town;
        }
        if (this.place.county) {
          if (result.length) {
            result += ', '
          }
          result += this.place.county;
        }
        if (this.place.state) {
          if (result.length) {
            result += ', '
          }
          result += this.place.state;
        }
        if (this.place.country) {
          if (result.length) {
            result += ', '
          }
          result += this.place.country;
        }
        if (!result.length) {
          return 'Unknown';
        }
        return result;
      } else {
        return 'Unknown';
      }
    }
  }

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