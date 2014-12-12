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
        return "<img ng-src='http://familyhistorydatabase.org/{{profilePic.viewlink}}' onerror=\"if (this.src != 'http://familyhistorydatabase.org/images/familytree.jpg') this.src = 'http://familyhistorydatabase.org/images/familytree.jpg';\" style='height: 25px; width: auto; border-radius: 4px; border: 1px solid darkgray;'>";
        // return "{{person.displayableName}}";
      }
    }
    return "<div>This is our template</div>";
  }
  return {
    restrict: 'E',
    scope:{
      person: '@'
    },
    template: getTemplate,
    link: function postLink(scope, element, attrs) {
      Business.individual.getIndData(scope.person).then(function(result) {
        console.log('result', result);
        if (result && result.profile_pic) {
          Business.individual.getProfilePic(result.profile_pic).then(function(profilePic) {
            console.log('result', profilePic);
            scope.profilePic = profilePic;
          }, function(result){
            console.log('Fail result', result);
          });
        }
      }, function(result){
        console.log('Fail result', result);
      });
    }
  };
}]);
