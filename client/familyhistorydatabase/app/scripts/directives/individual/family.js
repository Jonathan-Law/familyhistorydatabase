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


      var addParents = function(parents, person, size) {
        console.log('person', person);
        
        if (parents && parents.length) {
          var list = person.find('ul');
          if (list.length === 0) {
            list = person.append('<ul></ul>').find('ul');
          }
          _.each(parents, function(parent) {
            var tempsize = (size - 50) >= 25? (size - 50):25;
            var classes = size > 75? 'zoomableParent': size > 50? 'zoomableGrandParent': '';
            var temp = list.append('<li class="'+classes+'"><a ><individual classes="zoomable" person="'+parent.id+'" mode="picture" initialsize="'+size+'px"></individual></a></li>').find('individual[person*="'+parent.id+'"]').parent().parent();
            return addParents(parent.parents, temp, tempsize);
          })
        } else {
          return;
        }
      }


      Business.individual.getFamily(scope.personId).then(function(family){
        console.log('family', family);
        scope.family = family? family: [];
        var base = element.find("#treeHolder");
        var list = base.find('.tree');
        var root = list.append('<ul></ul>').find('ul');
        var person = root.append('<li  class="zoomableInd"><a><individual classes="zoomable" person="'+scope.personId+'" mode="picture" initialsize="150px"></individual></a></li>').find('li');
        addParents(family.parents, person, 125);
        var e = angular.element(base);
        $compile(e.contents())(scope);

        element.replaceWith(e);
        var allImgs = document.getElementById("treeHolder").getElementsByTagName("img");
        var allImgsLength = allImgs.length;
        var i;
        var eventCallback = function() {
          if ( !(--allImgsLength)) {
            $('.tree').css('width', 6000);
            setTimeout(function(){
              $('.tree').css('width', $('.tree').find('ul').find('li').width() + 10);
              setTimeout(function(){
                $('#treeHolder').scrollLeft($('.zoomableInd').width() / 4);
              })
            })
          }
        };

        for (i = 0; i < allImgsLength; i++) {
          if (allImgs[i].complete) {
            allImgsLength--;
          }
          if (allImgs[i].addEventListener) {
            allImgs[i].addEventListener("load", eventCallback);
          } else if (allImgs[i].attachEvent) {
            allImgs[i].attachEvent("onload", eventCallback);
          } else {
            allImgs[i].onload = eventCallback;
          }
        }
      }, function(){
        scope.family = [];
      });
      //
    }
  };
}]);
