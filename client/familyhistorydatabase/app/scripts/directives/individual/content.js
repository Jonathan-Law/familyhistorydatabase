'use strict';

app.directive('indData', ['$timeout', function ($timeout) {
  return {
    restrict: 'A',
    scope:{
      left: '=',
      right: '=',
      watch: '='
    },
    link: function postLink(scope, el, attrs) {

      var param = {};
      param.side = attrs.indData || 'right';
      param.speed = attrs.psSpeed || '0.5';
      param.size = attrs.psSize || '300px';
      param.className = attrs.psClass || 'ng-indData';
      // console.log('attrs', attrs);


      /* DOM manipulation */
      var content = null;
      if (!attrs.href && el.children() && el.children().length) {
        content = el.children()[0];  
      } else {
        content = (attrs.href) ? document.getElementById(attrs.href.substr(1)) : document.getElementById(attrs.psTarget.substr(1));
      }

      // Check for content
      if (!content) 
        throw new Error('You have to elements inside the <indData> or you have not specified a target href');
      var slider = document.createElement('div');
      slider.className = param.className;
      $(slider).attr('tabindex', 0);
      $(slider).css({
        '-webkit-appearance' :'none',
        'outline': 0
      });

      /* Style setup */
      slider.style.transitionDuration = param.speed + 's';
      slider.style.webkitTransitionDuration = param.speed + 's';
      slider.style.zIndex = 1000;
      slider.style.transitionProperty = 'width, height';

      slider.style.height = attrs.psCustomHeight || '100%'; 
      slider.style.top = attrs.psCustomTop ||  '52px';
      slider.style.bottom = attrs.psCustomBottom ||  '0px';
      slider.style.left = attrs.psCustomLeft ||  '0px';
      slider.style.right = attrs.psCustomRight ||  '0px';


      /* Append */
      $timeout(function() {
        $(el).append(slider);
        $(slider).append(content);
        $(slider).focus();
      })


      scope.$on('$destroy', function() {
        el[0].removeChild(slider);
      });


      $(slider).on('keyup', function(e){
        /* if (e.keyCode === 37){
          scope.right = !scope.right;
          scope.$apply();
        } else if (e.keyCode === 39){
          scope.left = !scope.left;
          scope.$apply();
        }*/
        /* else if (e.keyCode === 38){
          scope.right = true;
          scope.left = true;
          scope.$apply();
        } else if (e.keyCode === 40){
          scope.right = false;
          scope.left = false;
          scope.$apply();
        }*/
      });
      $timeout(function() {
        // fixed a weird bug where arriving on the page left you 10 pixes short from the top.
        $('body').animate({scrollTop:0},0);
      });
    }
  };
}]);
