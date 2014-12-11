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
        return "<img ng-src='http://familyhistorydatabase.org/{{profilePic.viewlink}}' onerror=\"if (this.src != 'http://familyhistorydatabase.org/images/familytree.jpg') this.src = 'http://familyhistorydatabase.org/images/familytree.jpg';\" style='height: 150px; width: auto; border-radius: 4px; border: 1px solid darkgray;'>";
        // return "{{person.displayableName}}";
      }
    }
    return "<div>This is our template</div>";
  }
  return {
    restrict: 'E',
    scope:{
      person: '='
    },
    template: getTemplate,
    link: function postLink(scope, element, attrs) {
      var timer;
      var setProfilePic = function(profilePic) {
        if (profilePic.error) {
          clearTimeout(timer);
          timer = setTimeout(function() {
            grabProfilePic();
          }, 500);
        } else {
          scope.profilePic = profilePic;
          console.log('profilePic', profilePic);
        }
      }
      var grabProfilePic = function() {
        if (scope.person) {
          Business.individual.getProfilePic(scope.person.profile_pic).then(function(profilePic) {
            setProfilePic(profilePic);
          });
        }
      }
      grabProfilePic();
      // element.text('this is the individual directive');
    }
  };
}]);
