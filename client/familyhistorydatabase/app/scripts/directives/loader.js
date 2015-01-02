'use strict';


/***************************************************************
* Usage:: <loader trigger="triggerId"></loader>
*
* ~~~
*
* $scope.$emit('$TRIGGERLOAD', 'triggerId');
*
* ~load stuff~
*
* $scope.$emit('$TRIGGERUNLOAD', 'triggerId');
***************************************************************/
app.directive('loader', function () {
  return {
    template: '<div class="loader-holder modal-backdrop fade in" ng-show="loading" style="position:absolute; min-height: 100px; min-width: 100px;"><div class="loader">Loading<div></div>',
    restrict: 'E',
    scope: {
      trigger: '@trigger'
    },
    link: function postLink(scope, element, attrs) { /*jshint unused:false*/
      scope.loading = true;
      scope.saveElementPosition;
      scope.saveOverflow = null;
      scope.saveOverflowX = null;
      scope.saveOverflowY = null;
      scope.$on('$LOAD', function(event, value) {
        if (value === scope.trigger) {
          if (!$(element).parent().css('position') || $(element).parent().css('position') === 'static') {
            scope.saveElementPosition = $(element).parent().css('position');
            $(element).parent().css('position', 'relative');
            if ($(element).parent().css('overflow-x') || $(element).parent().css('overflow-y')) {
              scope.overflowX = $(element).parent().css('overflow-x');
              scope.overflowY = $(element).parent().css('overflow-y');
            } else {
              scope.saveOverflow = $(element).parent().css('overflow');
            }
            $(element).parent().css('overflow', 'hidden');
          } else {
            scope.saveElementPosition = null;
          }
          scope.loading = true;
        }
      });
      scope.$on('$UNLOAD', function(event, value){
        if (value === scope.trigger) {
          if (scope.saveElementPosition) {
            console.log('scope.saveOverflow', scope.saveOverflow);
            console.log('scope.saveElementPosition', scope.saveElementPosition);

            $(element).parent().css('position', scope.saveElementPosition);
            if (scope.overflowX || $(element).parent().css('overflow-y')) {
              var overflowX = scope.overflowX || 'auto';
              var overflowY = scope.overflowY || 'auto';
              $(element).parent().css('overflow-x', overflowX);
              $(element).parent().css('overflow-y', overflowY);
            } else {
              var overflow = scope.saveOverflow || 'auto';
              $(element).parent().css('overflow', overflow);
            }
          }
          scope.loading = false;
        }
      });
    }
  };
});
