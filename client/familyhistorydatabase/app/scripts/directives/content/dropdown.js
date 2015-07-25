'use strict';

app.directive('dropdowntoggle', ['$location', '$timeout', function ($location, $timeout) {
  return {
    restrict: 'A',
    scope: {
      dropdowntoggle: '@'
    },
    link: function postLink(scope, element, attrs) {
      scope.$on('$TOGDROP', function(event, id){
        if (id === scope.dropdownTog){
          element.parent().removeClass('open');
        }
      })

      element.on('click', function(e){
        var found = _.contains(element.parent().classes(), 'open');
        console.log('found', found);
        if (found) {
          element.parent().removeClass('open');
        } else {
          element.parent().addClass('open');
        }
        $timeout(function(){
          if (found) {
            element.parent().removeClass('open');
          } else {
            element.parent().addClass('open');
          }
        })
        e.stopPropagation();
      })

      $(document).click(function(){
        element.parent().removeClass('open');
      });
    }
  }
}]);
