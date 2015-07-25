'use strict';

app.controller('AdminEditCtrl', ['$scope', 'business', '$location', '$timeout', function ($scope, Business, $location, $timeout) {
  $timeout(function(){
    Business.user.checkLoggedIn().then(function(){
      Business.user.getIsAdmin().then(function(result){
        console.log('result', result);
        if (!result) {
          $location.path('/');
        }
      })
    })
  },100)
  $scope.$on('$LOGOUT', function() {
    $location.path('/');
  })

  $scope.goTo = function(path) {
    $location.search({});
    $location.path(path);
  }

  $scope.searchTypes = [
  {name:'Title and Comments', value:'default'},
  {name:'Person Tag', value:'person'},
  {name:'Place Tag', value:'place'},
  {name:'Collection Tag', value:'collection'},
  ];
  $scope.fileSearchType = $scope.searchTypes[0];

  $scope.individual;
  $scope.file;

  $scope.getAllSubmissions = function(){
    Business.individual.getAllSubmissions().then(function(result){
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
  $scope.getAllSubmissions();

  $scope.getSubmitterName = function(id){

  }
  

  $scope.deleteInd = function(ind){
    var cont = confirm("Delete this individual?\n"+ind.typeahead+"\nIndividual ID: "+ind.id);
    if (cont) {
      Business.individual.deleteInd(ind.id).then(function(result){
        $scope.getAllSubmissions();
        delInd = '';
      });
    }
  }

}]);
