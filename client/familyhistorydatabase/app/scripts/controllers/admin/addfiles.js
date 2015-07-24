'use strict';

app.controller('AdminAddfilesCtrl', ['$scope', 'business', '$location', '$timeout', function ($scope, Business, $location, $timeout) {
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

  $scope.dropzoneConfig = {
    'options': { // passed into the Dropzone constructor
      'url': '/api/v1/file',
      'parallelUploads': 1,
      // 'createImageThumbnails': true,
      // 'thumbnailWidth': 70,
      'autoProcessQueue': false,
      'uploadMultiple': true,
      'previewTemplateUrl': 'views/dropzone/dropzoneTemplate.html'
    }
  };
  $scope.mass = false;
}]);
