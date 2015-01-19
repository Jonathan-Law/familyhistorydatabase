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

      console.log('scope.id', scope.id);

      scope.isUserAdmin = false;

      scope.isUserAdmin = Business.user.getIsAdmin() || false;
      

      scope.setProfilePicture = function(){
        Business.individual.setProfilePic(scope.id, scope.focus.id).then(function(result){
          console.log(result);
        });
      };

      $(window).on('keydown', function (e){
        if(e.keyCode === 37 || e.keyCode === 38) { //left or up
          if (scope.start > 0 && scope.active === 0) {
            scope.stop--;
            scope.start--;
            scope.setActiveImage(scope.active, scope.pictures[scope.start]);
          } else if (scope.start > 0){
            scope.setActiveImage(scope.active - 1, scope.pictures[(scope.start + scope.active) - 1]);
          } else if (scope.active > 0) {
            scope.setActiveImage(scope.active - 1, scope.pictures[(scope.start + scope.active) - 1]);
          }
          scope.$apply();
        }
        if(e.keyCode === 39 || e.keyCode === 40) { //right or down
          if (scope.stop < scope.pictures.length && scope.active === 4) {
            scope.setActiveImage(scope.active, scope.pictures[scope.stop]);
            scope.stop++;
            scope.start++;
          } else if (scope.stop < scope.pictures.length) {
            scope.setActiveImage(scope.active + 1, scope.pictures[(scope.start + scope.active) + 1]);
          } else if (scope.active < 4){
            scope.setActiveImage(scope.active + 1, scope.pictures[(scope.start + scope.active) + 1]);
          }
          scope.$apply();
        }
      });

      scope.$on('$destroy', function handleDestroyEvent() {
        // console.log('we destroyed the photo-album');
        $(window).off('keydown', function(){

        });
      });

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

      jQuery.fn.animateAuto = function(prop, speed, callback){
        var elem, height, width;
        return this.each(function(i, el){
          el = jQuery(el), elem = el.clone().css({"height":"auto","width":"auto"}).appendTo("body");
          height = elem.css("height"),
          width = elem.css("width"),
          elem.remove();

          if(prop === "height")
            el.animate({"height":height}, speed, callback);
          else if(prop === "width")
            el.animate({"width":width}, speed, callback);  
          else if(prop === "both")
            el.animate({"width":width,"height":height}, speed, callback);
        });  
      }

      // element.find('#display').on('mouseenter', function(){
      //   $('.photoAlbumData').stop(true, true).animate({
      //     backgroundColor: 'rgba(102,102,76,.95)',
      //   }, 150, function(){
      //     //animation complete
      //   }).animateAuto('height', 150);
      // })
      // element.find('#display').on('mouseleave', function(){
      //   $('.photoAlbumData').stop(true, true).animate({
      //     'height': '100%',
      //     backgroundColor: 'rgba(0,0,0,.6)',
      //   }, 150, function(){
      //         //animation complete
      //       });
      // })
      //
      scope.setActiveImage = function(index, image){
        scope.active = index;
        scope.focus = image;
        var img = new Image();
        img.onload = function() {
          calculateAspectRatioFit(this.width, this.height, scope.tempWidth, scope.tempHeight);
        }
        img.src = 'http://familyhistorydatabase.org/'+scope.focus.link;
      }

      scope.openInNewWindow = function() {
        window.open('http://familyhistorydatabase.org/'+scope.focus.link);
      }

      scope.print = function() {
        var content = element.find('#display').html();
        $('#printOnly').html(content);
        window.print();
      }

      scope.getDownload = function() {
        var url = 'http://familyhistorydatabase.org/' + scope.focus.link;
        var download = scope.focus.link.replace('upload/', '');
        var a = $("<a>").attr("href", url).attr("download", download).appendTo("body");
        a[0].click();
        a.remove();
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