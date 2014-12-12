'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:individual/family
* @description
* # individual/family
*/
app.directive('family', ['business', '$timeout', '$compile', function (Business, $timeout, $compile) {
  return {
    templateUrl: 'views/individual/family.html',
    restrict: 'EA',
    scope: {
      personId: '='
    },
    link: function postLink(scope, element, attrs) {


      var addParents = function(parents, person) {
        if (parents && parents.length) {
          var list = person.find('ul');
          if (list.length === 0) {
            list = person.append('<ul></ul>').find('ul');
          }
          _.each(parents, function(parent) {
            var temp = list.append('<li><a><individual person="'+parent.id+'" mode="picture"></individual></a></li>').find('individual[person*="'+parent.id+'"]').parent().parent();
            return addParents(parent.parents, temp);
          })
        } else {
          return;
        }
      }


      Business.individual.getFamily(scope.personId).then(function(family){
        console.log('family', family);
        scope.family = family? family: [];
        var list = element.find(".tree");
        var root = list.append('<ul></ul>').find('ul');
        var person = root.append('<li><a><individual person="'+scope.personId+'" mode="picture"></individual></a></li>').find('li');
        addParents(family.parents, person);
        var e = angular.element(list);
        $compile(e.contents())(scope);
        element.replaceWith(e);
      }, function(){
        scope.family = [];
      });

    }
  };
}]);
