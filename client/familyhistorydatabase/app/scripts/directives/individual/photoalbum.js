'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/photoalbum
* @description
* # individual/photoalbum
*/
app.directive('photoalbum', ['business', function (Business) {
  return {
    templateUrl: 'views/individual/photoalbum.html',
    restrict: 'EA',
    scope:{
      id: '='
    },
    link: function postLink(scope, element, attrs) {

      scope.interval = 1;
      scope.size = 5;

      scope.start = 0;
      scope.stop = scope.size;

      scope.moreAfter = function(){
        return (scope.pictures.length - scope.start) > scope.size;
      }
      scope.moreBefore = function(){
        return scope.start > 0;
      }


      scope.pictures = [];
      Business.individual.getPictures(scope.id).then(function(result){
        scope.pictures = result? result: [];
      }, function(){
        scope.pictures = [];
      });
    }
  };
}]);


app.directive('backImg', function(){
  return function(scope, element, attrs){
    attrs.$observe('backImg', function(value) {
      console.log('Object', {
        'background-image': 'url("' + value +'")',
        'background-size' : 'contain',
        '-moz-background-size': 'contain'
      });
      
      element.css({
        'background-image': 'url("' + value +'")',
        'background-size' : 'contain',
        '-moz-background-size': 'contain'
      });
    });
  };
});

app.filter('slice', function() {
  return function(arr, start, end) {
    return (arr || []).slice(start, end);
  };
});