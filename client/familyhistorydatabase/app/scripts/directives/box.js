'use strict';

app.directive('box', ['business', function (Business) {
  return {
    templateUrl: 'views/individual/boxTemplate.html',
    restrict: 'E',
    scope: {
      params: '=',
      id: '=',
      callback: '='
    },
    link: function postLink(scope, element, attrs) {
      scope.direction = 'Initial';
      if (scope.id)
      {
        Business.individual.getProfilePicByPersonId(scope.id).then(function(result){
          if (result){
          // console.log('result', result);
          scope.profilePic = result.viewlink;
        }
      });
      }
      $(element).find('.dathumbsContainer').hoverdir();

      // home made direction-aware hover effects...
      // var determineDirection = function ($el, pos){
      //   var w = $el.width(),
      //   h = $el.height(),
      //   x = (pos.x - $el.offset().left - (w/2)) * (w > h ? (h/w) : 1),
      //   y = (pos.y - $el.offset().top  - (h/2)) * (h > w ? (w/h) : 1);

      //   return Math.round((((Math.atan2(y,x) * (180/Math.PI)) + 180)) / 90 + 3) % 4;
      // }
      // $(element).find('.imageContainer').on('mouseenter', function(e){
      //   var dir = determineDirection($(this), {x: e.pageX, y: e.pageY});
      //   scope.in = true;
      //   scope.direction = dir === 0? 'top': dir === 1? 'right' : dir === 2? 'bottom': 'left'; 
      //   scope.$apply();
      // }); 
      // $(element).find('.imageContainer').on('mouseleave', function(e){
      //   var dir = determineDirection($(this), {x: e.pageX, y: e.pageY});
      //   scope.in = false;
      //   scope.direction = dir === 0? 'top': dir === 1? 'right' : dir === 2? 'bottom': 'left'; 
      //   scope.$apply();
      // }); 

}
};
}]);
