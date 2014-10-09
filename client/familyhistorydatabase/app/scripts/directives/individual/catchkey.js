//Use case: Put this element preceding the exact element that you would like to catch the keys of.

'use strict';

app.directive('catchkey', function () {
  return {
    templateUrl: 'views/individual/catchkey.html',
    scope: {
      letter: '=',
      giveFocus: '=',
      showInput: '=',
      placeholder: '@'
    },
    restrict: 'E',
    link: function postLink(scope, element, attrs) {

      var myKeyPress = function(e){
        var keynum;
        if(window.event){ // IE         
          keynum = e.keyCode;
        }else
        if(e.which){ // Netscape/Firefox/Opera          
          keynum = e.which;
        }
        return String.fromCharCode(keynum);
      }
      element.next().attr('tabindex', 0);
      element.next().css({
        '-webkit-appearance' :'none',
        'outline': 0
      });
      if (scope.giveFocus){
        element.next().focus();
      } else {
        element.find('#focusOnMe').focus();
      }
      element.next().on("keydown", function(e) {
        if (e.which !== 9 && e.which !== 13) {
          var letter =  myKeyPress(e);
          var objRegExp  = /[A-Z]{1}/;
          if (!objRegExp.test(letter)) {
            console.log('Not Letter', letter)
          } else {
            scope.letter = letter.toLowerCase();
            scope.$apply();
          }
        }
      });
    }
  };
});
