'use strict';

app.controller('MyFamilyCtrl', ['$scope', '$location', 'business', '$timeout', function ($scope, $location, Business, $timeout) {
  $scope.test = 'test me';
  $timeout(function(){
    Business.user.checkLoggedIn().then(function(result){
      if (!result) {
        $location.path('/');
      }
    })
  },100)

  $scope.$on('$NOTLOGGEDIN', function(){
    $location.path('/');
  });
  $scope.$on('$LOGOUT', function(){
    $location.path('/');
  })
  $scope.getMySubmissions = function(){
    Business.individual.getMySubmissions().then(function(result){
      if (result && result.length && result !== 'null') {
        _.each(result, function(submission){
          Business.user.getUserInfoId(submission.submitter).then(function(data){
            if (data){
              submission.displayableName = data.displayableName;
            }
          })
        });
      }
      $scope.approveThese = result;
    }, function(){
      console.log('something broke');
    })
  }
  $scope.getMySubmissions();
}]);
