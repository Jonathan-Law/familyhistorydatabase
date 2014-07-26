'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:NavCtrl
* @description
* # NavCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('NavCtrl', ['$rootScope', '$scope', '$aside', 'business', function ($rootScope, $scope, $aside, Business) { /*jshint unused:false*/

  $scope.user       = $rootScope.user;
  $scope.searchKey  = null;

  $scope.loggedIn   = false;

  $scope.aside = {
    'title': 'Title',
    'content': 'Hello Aside<br />This is a multiline message!'
  };

  $scope.logout = function() {
    Business.user.logout();
    $scope.$emit('$loggedOut');
  }

  $scope.login = function() {
    $scope.$emit('$triggerEvent', '$triggerModal',   {
      "nav": {
        "bars": [
        {
          "title": "Login",
          "include": "views/auth/login.html"
        },
        {
          "title": "Register",
          "include": "views/auth/register.html"
        }
        ],
        "current": "Login"
      },
      "showFooter": false,
      "classes": [
      "hasNav",
      "darkTheme"
      ]
    });
  }

  $rootScope.$watch('user', function() {
    $scope.user = $rootScope.user;
    if ($scope.user) {
      $scope.loggedIn = true;
    } else {
      $scope.loggedIn = false;
    }
  });

  $scope.$watch('searchKey', function() {
    if (typeof $scope.searchKey === 'object' && $scope.searchKey){
      console.log('Typeahead Item Found: ', $scope.searchKey);
    }
  });

  $scope.checkLogin().then(function(response){
    if (response) {
      $scope.loggedIn = true;
      $scope.user = response;
    }
  });


  // Pre-fetch an external template populated with a custom scope
  // var myOtherAside = $aside({scope: $scope, template: 'views/navAside.html'});
  // // Show when some event occurs (use $promise property to ensure the template has been loaded)
  // myOtherAside.$promise.then(function() {
  //   myOtherAside.show();
  // })
}]);
