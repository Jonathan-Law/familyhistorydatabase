'use strict';

app.controller('MyFamilyCtrl', ['$scope', '$location', 'business', function ($scope, $location, Business) {
  $scope.test = 'test me';

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
