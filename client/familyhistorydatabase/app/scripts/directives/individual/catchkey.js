'use strict';

app.directive('catchkey', function () {
  return {
    templateUrl: 'views/individual/catchkey.html',
    scope: {
      letter: '='
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

      $(document).on("keydown", function(e) {
        if (e.which !== 9 && e.which !== 13) {
          var letter =  myKeyPress(e);
          var objRegExp  = /[A-Z]{1}/;
          if (!objRegExp.test(letter)) {
            console.log('Not Letter', letter)
          } else {
            console.log('letter', letter);
            scope.letter = letter.toLowerCase();
            scope.$apply();
          }
        }
      });
    }
  };
});
