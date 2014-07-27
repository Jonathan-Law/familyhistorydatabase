'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual
* @description
* # individual
*/
app.directive('individual', ['business', function (Business) {
  var getTemplate = function (element, attrs) {
    var mode = attrs.mode || null;
    if (mode) {
      if (mode === 'picture') {
        return "<img src='images/title.png'>";
      }
    }
    return "<div>This is our template</div>";
  }
  return {
    restrict: 'E',
    scope:{
      mode: '=mode'
    },
    template: getTemplate,
    link: function postLink(scope, element, attrs) {
      Business.individual.getIndData(850);
      // element.text('this is the individual directive');
    }
  };
}]);
