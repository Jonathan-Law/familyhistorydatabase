'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:NavCtrl
* @description
* # NavCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('NavCtrl', ['$scope', '$aside', 'business', function ($scope, $aside, Business) { /*jshint unused:false*/
  $scope.awesomeThings = [
  'HTML5 Boilerplate',
  'AngularJS',
  'Karma'
  ];

  $scope.aside = {
    'title': 'Title',
    'content': 'Hello Aside<br />This is a multiline message!'
  };

  $scope.logout = function() {
    Business.user.logout();
  }
   // Pre-fetch an external template populated with a custom scope
  // var myOtherAside = $aside({scope: $scope, template: 'views/navAside.html'});
  // // Show when some event occurs (use $promise property to ensure the template has been loaded)
  // myOtherAside.$promise.then(function() {
  //   myOtherAside.show();
  // })
}]);
