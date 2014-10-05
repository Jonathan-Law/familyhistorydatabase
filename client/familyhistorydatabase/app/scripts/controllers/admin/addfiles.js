'use strict';

app.controller('AdminAddfilesCtrl', ['$scope', 'business', '$location', function ($scope, Business, $location) {
  if (!Business.user.getIsAdmin()) {
    $location.path('/');
  }
  $scope.$on('$LOGOUT', function() {
    $location.path('/');
  })


  $scope.goTo = function(path) {
    $location.search({});
    $location.path(path);
  }

  $scope.dropzoneConfig = {
    'options': { // passed into the Dropzone constructor
      'url': 'http://familyhistorydatabase.org/v2/api/v1/file',
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
