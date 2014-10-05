'use strict';

/**
* @ngdoc directive
* @name familyhistorydatabaseApp.directive:myModal
* @description
* # myModal
*/

/**************************************************
* The object expected by this modal when displayed is one of the two objects
* displayed here:
*
*   {
*     "nav": {
*       "bars": [
*         {
*           "title": "Login",
*           "include": "views/login/form.html"
*         },
*         {
*           "title": "Register",
*           "include": "views/login/form.html"
*         }
*       ],
*       "current": "Login"
*     },
*     "showFooter": false,
*     "classes": [
*       "hasNav",
*       "darkTheme"
*     ]
*   }
*
*
*   {
*     "modalTitle": "This is my title",
*     "modalBody": "views/login/form.html",
*     "showFooter": false,
*     "classes": [
*       "fullmodal",
*       "darkTheme"
*     ]
*   }
*************************************************/
app.directive('myModal', ['$timeout', function ($timeout) {
  return {
    restrict: 'AE',
    scope: {},
    template: '<div class="modal fade {{classes}}" id="{{id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> <div ng-include="header"></div> </div> <div class="modal-body"> <div ng-include src="body"></div> </div> <div ng-show="showFooter" class="modal-footer"> <div ng-include="footer"></div> </div> </div> </div </div>',
    link: function postLink(scope, element, attrs) { /*jshint unused:false*/
      
      scope.getTagTypeahead = scope.$parent.getTagTypeahead;

      scope.header = 'views/modalDefaults/header.html';

      scope.footer = 'views/modalDefaults/footer.html';

      scope.body = 'views/modalDefaults/body.html';

      scope.id = 'globalModal';

      scope.nav = null;

      scope.$on('$triggerModal', function (event, content) { /*jshint unused:false*/
        if (content) {
          $('#'+scope.id).modal('show');
          if (content.showFooter === false) {
            scope.showFooter = false;
          } else {
            scope.showFooter = true;
          }
          if (content.classes){
            scope.classes = content.classes.join(' ');
          } else {
            scope.classes = [];
          }
          if (content.nav) {
            scope.nav = content.nav;
          } else {
            scope.nav = null;
            if (content.modalTitle) {
              scope.modalTitle = content.modalTitle;
            }
            if (content.modalBody) {
              scope.modalBody = content.modalBody;
            } else if (content.modalBodyContent) {
              scope.modalBodyContent = content.modalBodyContent;
            }
          }
        } else {
          console.error('A Content object is required for the modal to work');
        }
      });
      scope.$on('$triggerModalClose', function (event) { /*jshint unused:false*/
        $('#'+scope.id).modal('hide');
      });

      scope.$on('$includeContentLoaded', function() {
        $timeout(function () {
          element.find('[autofocus]').focus();
        });
      });

      $timeout(function(){
        $('#'+scope.id).on('shown.bs.modal', function(){
          $timeout(function () {
            element.find('[autofocus]').focus();
          });
        });
      });

    }
  };
}]);
