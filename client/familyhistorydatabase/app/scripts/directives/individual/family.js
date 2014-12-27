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

      scope.getTitle = function() {
        if (scope.family) {
          return scope.family.self.displayableName + ' Family Chart';
        } else {
          return 'Family Chart';
        }
      }
      var addParents = function(parents, person, size) {
        if (parents && parents.length) {
          var list = person.find('ul');
          if (list.length === 0) {
            list = person.append('<ul></ul>').find('ul');
          }
          _.each(parents, function(parent) {
            var tempsize = (size - 50) >= 25? (size - 50):25;
            var temp = list.append('<li id="person'+parent.id+'"><a class="zoomable"><individual classes="" person="'+parent.id+'" mode="picture" zoomable="true" initialsize="'+size+'px"></individual></a></li>').find('#person'+parent.id);
            return addParents(parent.parents, temp, tempsize);
          })
        } else {
          return;
        }
      }

      var resizeTree = function() {
        $('.tree').css('width', 6000);
        setTimeout(function(){
          $('.tree').css('width', $('.tree').find('ul').find('li').width() + 100);
          setTimeout(function(){
            var treeHolderWidth = $('#treeHolder').width();
            var zoomableIndWidth = $('.zoomableInd').width();
            if (treeHolderWidth < zoomableIndWidth) {
              $('#treeHolder').scrollLeft((zoomableIndWidth - treeHolderWidth) / 2);
            }
          },100)
        }, 400)
      }

      $(window).resize(function(){
        $timeout(function(){
          resizeTree()
        })
      })

      scope.$on('$CHARTRESIZE', function(){
        $timeout(function(){
          resizeTree();
        })
      })

      Business.individual.getFamily(scope.personId).then(function(family){
        console.log('family', family);
        scope.family = family? family: [];
        var base = element.find("#treeHolder");
        var list = base.find('.tree');
        var root = list.append('<ul></ul>').find('ul');
        var person = root.append('<li><a class="zoomable"><individual classes="" person="'+scope.personId+'" mode="picture" zoomable="true" initialsize="150px"></individual></a></li>').find('li');
        addParents(family.parents, person, 125);
        var e = angular.element(base);
        $compile(e.contents())(scope);


        element.replaceWith(e);
        var allImgs = document.getElementById("treeHolder").getElementsByTagName("img");
        var allImgsLength = allImgs.length;
        var i;
        var eventCallback = function() {
          if ( !(--allImgsLength)) {
            resizeTree();
          }
        };
        console.log('allImgsLength', allImgsLength);
        
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
