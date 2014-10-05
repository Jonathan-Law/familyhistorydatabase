'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:MainCtrl
* @description
* # MainCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('MainCtrl', ['$scope', 'business', '$location', function ($scope, Business, $location) {

  var convertDate = function (v) {
    var d = v? new Date(v): new Date();
    var curr_date  = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year  = d.getFullYear();
    return curr_month + "/" + curr_date + "/" + curr_year;
  };
  $scope.newDate = moment('1700-1-1').toDate();

  $scope.list = [];

  for (var i = 1; i < 27; i++)
  {
    var current = String.fromCharCode(i + 96);
    $scope.list.push({overlay: ''+ current + '.' + current + '.jpg', base: '' + current + '.jpg', letter: current});
  }

  $scope.clicked = function(letter) {
    $location.search({
      'letter': letter
    })
    $location.path('/families');
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

}]);
