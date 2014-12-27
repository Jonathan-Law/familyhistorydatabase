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
        return "<div class='image_enlarge_container'><img ng-cloak class=\"{{classes}}\" ng-src='{{profilePic}}' onerror=\"if (this.src != 'http://familyhistorydatabase.org/images/familytree.jpg') this.src = 'http://familyhistorydatabase.org/images/familytree.jpg';\" style='height: {{initialsize}}; width: auto; border-radius: 4px;'></div>";
        // return "{{person.displayableName}}";
      }
    }
    return "<div>This is our template</div>";
  }
  return {
    restrict: 'E',
    scope:{
      person: '@',
      classes: '@',
      initialsize: '@',
      zoomable: '&'
    },
    template: getTemplate,
    link: function postLink(scope, element, attrs) {
      var setupZommable = function(){
        if (scope.zoomable){
          $(element).on('click', function(){
            var img = $(this).find('img');
            var width = img.width();
            var height = img.height();
            var heightRatio = 200 / height;
            var widthCalc = width * heightRatio;
            var tempHolder = '<a class="a-unstyled" href="#/individual?individual='+scope.data.id+'&tab=default"></a>';
            tempHolder = $(tempHolder);
            var link = $('<div class="dynamicImage" style="width:300px; background:#2F2F2F; border:1px solid black; border-radius:4px; text-align: center; overflow:hidden; color: white;"></div>');
            var temp = $('<img style="border:1px solid darkgray; border-radius:4px; margin:4px;">');
            var data = $('<div>'+scope.data.displayableName+' ('+scope.data.yearBorn+' - '+scope.data.yearDead+')</div>');
            tempHolder.append(link);
            link.append(temp);
            link.append(data);
            temp.attr('src', img.attr('src'));
            temp.css({
              'height': '200px',
              'width': widthCalc + 'px',
              'display':'inline-block'
            }) 
            tempHolder.css({
              'position': 'absolute',
              'z-index': '1234',
              'left': img.offset().left - ((300 - width) / 2),
              'top': img.offset().top - ((200 - height) /2),
            })
            $('body').prepend(tempHolder);

            tempHolder.on('mouseleave click', function(){
              $(this).remove();
            })
          }) 
          $(window).scroll(function(){ //
            $('.dynamicImage').each(function(){
              $(this).remove();
            })
          })
        }
      }

      Business.individual.getIndData(scope.person).then(function(result) {
        // console.log('result', result);
        scope.data = result;
        if (result && result.profile_pic) {
          Business.individual.getProfilePic(result.profile_pic).then(function(profilePic) {
            // console.log('==========result========', profilePic);
            if (profilePic && profilePic.viewlink) {
              scope.profilePic = "http://familyhistorydatabase.org/" + profilePic.viewlink;
            } else {
              scope.profilePic = 'http://familyhistorydatabase.org/images/familytree.jpg';
            }
          }, function(result){
            scope.profilePic = 'http://familyhistorydatabase.org/images/familytree.jpg';
            // console.log('Fail result', result);
          });
          setupZommable();
        } else {
          scope.profilePic = 'http://familyhistorydatabase.org/images/familytree.jpg';
          setupZommable();
        }
      }, function(result){
        scope.profilePic = 'http://familyhistorydatabase.org/images/familytree.jpg';
        // console.log('Fail result', result);
      });
    } //
  };
}]);
