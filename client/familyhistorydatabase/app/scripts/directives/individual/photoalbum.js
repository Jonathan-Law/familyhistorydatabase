'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/photoalbum
* @description
* # individual/photoalbum
*/
app.directive('photoalbum', ['business', '$timeout', function (Business, $timeout) {
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

      scope.active = 0;
      scope.focus;

      scope.imgWidth;
      scope.imgHeight;

      scope.moreAfter = function(){
        return (scope.pictures.length - scope.start) > scope.size;
      }
      scope.moreBefore = function(){
        return scope.start > 0;
      }
      var timeout;
      $(window).resize(function() {
        clearTimeout(timeout);
        timeout =  setTimeout(function() {
          scope.setDimensions();
          scope.setActiveImage(scope.active, scope.focus);
        }, 500);
      });

      scope.setDimensions = function() {
        scope.tempWidth = element.find('#display').width();
        scope.tempHeight = 600;
      };


      var calculateAspectRatioFit = function(srcWidth, srcHeight, maxWidth, maxHeight) {
        var ratio = [maxWidth / srcWidth, maxHeight / srcHeight ];
        ratio = Math.min(ratio[0], ratio[1]);
        scope.imgWidth = srcWidth*ratio;
        scope.imgHeight = (srcHeight*ratio) - 2;
        scope.$apply();
      }


      scope.setActiveImage = function(index, image){
        scope.active = index;
        scope.focus = image;
        var img = new Image();
        img.onload = function() {
          calculateAspectRatioFit(this.width, this.height, scope.tempWidth, scope.tempHeight);
        }
        img.src = 'http://familyhistorydatabase.org/'+scope.focus.link;
      }

      scope.pictures = [];
      Business.individual.getPictures(scope.id).then(function(result){
        scope.pictures = result? result: [];
        if (scope.pictures.length) {
          $timeout(function() {
            scope.setDimensions();
            scope.setActiveImage(0, scope.pictures[0]);
          }, 300);
        }
      }, function(){
        scope.pictures = [];
      });


      element.find("#thumbnails").on('mousewheel DOMMouseScroll', function(e){
        if(e.originalEvent.wheelDelta /120 > 0) {
          if (scope.moreBefore()){
            scope.start = scope.start - scope.interval;
            scope.stop = scope.stop - scope.interval;
            scope.active++;
          }
        }
        else{
          if (scope.moreAfter()){
            scope.start = scope.start + scope.interval;
            scope.stop = scope.stop + scope.interval;
            scope.active--;
          }
        }
        scope.$apply();
      });

    }
  };
}]);


app.directive('backImg', function(){
  return function(scope, element, attrs){
    attrs.$observe('backImg', function(value) {
      // console.log('Object', {
      //   'background-image': 'url("' + value +'")',
      //   'background-size' : 'contain',
      //   '-moz-background-size': 'contain'
      // });

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