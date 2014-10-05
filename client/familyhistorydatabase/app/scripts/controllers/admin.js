'use strict';

app.controller('AdminCtrl', ['$scope', 'business', '$location', function ($scope, Business, $location) {
  
  if (!Business.user.getIsAdmin()) {
    $location.path('/');
  }
  $scope.$on('$LOGOUT', function() {
    $location.path('/');
  })
  
  $scope.tools = [
  {'name': 'Add people or files', 'route': 'admin/add'},
  {'name': 'Edit people or files', 'route': 'admin/edit'},
  ];
  
  $scope.goToTool = function(tool){
    $location.search({});
    $location.path(tool.route);
  }

}]);
