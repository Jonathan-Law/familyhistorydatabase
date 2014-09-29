/**
* An AngularJS directive for Dropzone.js, http://www.dropzonejs.com/
* 
* Usage:
* 
* <div ng-app="app" ng-controller="SomeCtrl">
*   <button dropzone="dropzoneConfig">
*     Drag and drop files here or click to upload
*   </button>
* </div>
* 
*  ...
*
*  Option
*  url --- Has to be specified on elements other than form (or when the form doesn't have an action attribute)
*  method --- Defaults to "post" and can be changed to "put" if necessary.
*  parallelUploads --- How many file uploads to process in parallel (See the Enqueuing file uploads section for more info)
*  maxFilesize --- in MB
*  paramName --- The name of the file param that gets transferred. Defaults to file. NOTE: If you have the option uploadMultiple set to true, then Dropzone will append [] to the name.
*  uploadMultiple --- Whether Dropzone should send multiple files in one request. If this it set to true, then the fallback file input element will have the multiple attribute as well. This option will also trigger additional events (like processingmultiple). See the events section for more information.
*  headers --- An object to send additional headers to the server. Eg: headers: { "My-Awesome-Header": "header value" }
*  addRemoveLinks --- This will add a link to every file preview to remove or cancel (if already uploading) the file. The dictCancelUpload, dictCancelUploadConfirmation and dictRemoveFile options are used for the wording.
*  previewsContainer --- defines where to display the file previews – if null the Dropzone element is used. Can be a plain HTMLElement or a CSS selector. The element should have the dropzone-previews class so the previews are displayed properly.
*  clickable --- If true, the dropzone element itself will be clickable, if false nothing will be clickable. Otherwise you can pass an HTML element, a CSS selector (for multiple elements) or an array of those.
*  createImageThumbnails 
*  maxThumbnailFilesize --- in MB. When the filename exceeds this limit, the thumbnail will not be generated
*  thumbnailWidth --- if null, the ratio of the image will be used to calculate it.
*  thumbnailHeight --- the same as thumbnailWidth. If both are null, images will not be resized.
*  maxFiles --- if not null defines how many files this Dropzone handles. If it exceeds, the event maxfilesexceeded will be called. The dropzone element gets the class dz-max-files-reached accordingly so you can provided visual feedback.
*  resize --- is the function that gets called to create the resize information. It gets the file as first parameter and must return an object with srcX, srcY, srcWidth and srcHeight and the same for trg*. Those values are going to be used by ctx.drawImage().
*  init --- is a function that gets called when Dropzone is initialized. You can setup event listeners inside this function.
*  acceptedMimeTypes --- Deprecated in favor of acceptedFiles
*  acceptedFiles --- The default implementation of accept checks the file's mime type or extension against this list. This is a comma separated list of mime types or file extensions. Eg.: image/*,application/pdf,.psd. If the Dropzone is clickable this option will be used as accept parameter on the hidden file input as well.
*  accept --- is a function that gets a file and a done function as parameter. If the done function is invoked without a parameter, the file will be processed. If you pass an error message it will be displayed and the file will not be uploaded. This function will not be called if the file is too big or doesn't match the mime types.
*  enqueueForUpload --- Deprecated in favor of autoProcessQueue.
*  autoProcessQueue --- When set to false you have to call myDropzone.processQueue() yourself in order to upload the dropped files. See below for more information on handling queues.
*  previewTemplate --- is a string that contains the template used for each dropped image. Change it to fulfill your needs but make sure to properly provide all elements.
*  forceFallback --- defaults to false. If true the fallback will be forced. This is very useful to test your server implementations first and make sure that everything works as expected without dropzone if you experience problems, and to test how your fallbacks will look.
*  fallback --- is a function that gets called when the browser is not supported. The default implementation shows the fallback input field and adds a text.
*  
*  
*  to translate dropzone, you can also provide these options:
*  
*  Option --- Description
*  dictDefaultMessage --- The message that gets displayed before any files are dropped. This is normally replaced by an image but defaults to "Drop files here to upload"
*  dictFallbackMessage --- If the browser is not supported, the default message will be replaced with this text. Defaults to "Your browser does not support drag'n'drop file uploads."
*  dictFallbackText --- This will be added before the file input files. If you provide a fallback element yourself, or if this option is null this will be ignored. Defaults to "Please use the fallback form below to upload your files like in the olden days."
*  dictInvalidFileType --- Shown as error message if the file doesn't match the file type.
*  dictFileTooBig --- Shown when the file is too big. and will be replaced.
*  dictResponseError --- Shown as error message if the server response was invalid. `` will be replaced with the servers status code.
*  dictCancelUpload --- If addRemoveLinks is true, the text to be used for the cancel upload link.
*  dictCancelUploadConfirmation --- If addRemoveLinks is true, the text to be used for confirmation when cancelling upload.
*  dictRemoveFile --- If addRemoveLinks is true, the text to be used to remove a file.
*  dictMaxFilesExceeded --- If maxFiles is set, this will be the error message when it's exceeded.
*
*  ...
*
* angular.module('app').controller('SomeCtrl', function ($scope) {
*   $scope.dropzoneConfig = {
*     'options': { // passed into the Dropzone constructor
*       'url': 'upload.php'
*     },
*     'eventHandlers': {
*       'sending': function (file, xhr, formData) {  // Called just before each file is sent. Gets the xhr object and the formData objects as second and third parameters, so you can modify them (for example to add a CSRF token) or add additional data.
*       },
*       'success': function (file, response) { // The file has been uploaded successfully. Gets the server response as second argument. (This event was called finished previously)
*       },
*       'maxfilesreached': function(file) {  // maxfilesreached  Called when the number of files accepted reached the maxFiles limit.
*       },
*       'maxfilesexceeded': function(file) {  // Called for each file that has been rejected because the number of files exceeds the maxFiles limit.
*       },
*       'uploadprogress': function(file) {  // Gets called periodically whenever the file upload progress changes. Gets the progress parameter as second parameter which is a percentage (0-100) and the bytesSent parameter as third which is the number of the bytes that have been sent to the server. When an upload finishes dropzone ensures that uploadprogress will be called with a percentage of 100 at least once. Warning: This function can potentially be called with the same progress multiple times.
*       },
*       'addedfile': function(file) {  // Gets called when a file is added
*       },
*       'removedfile': function(file) {  // Called whenever a file is removed from the list.
*       }
*     }
*   };
* });
*/

'use strict';

app.directive('massDropzone', ['$http', '$compile', 'business', '$timeout', function ($http, $compile, Business, $timeout) {
  var getTemplate = function(element, attrs) {
    return attrs.templateurl;
  }
  var index = 1;
  return {
    restrict: 'E',
    scope: {
      config: '='
    },
    templateUrl: getTemplate,
    link: function postLink(scope, element, attrs) {
      scope.type = 'image';
      // here we need to make sure we grab the typeahead function... it doesn't
      // persist.
      scope.getTypeahead = scope.$parent.getTypeahead;      
      scope.getTagTypeahead = scope.$parent.getTagTypeahead;

      // console.log('scope.config', scope.config);
      var config, dropzone;
      config = scope.config;

      // we could allow the user to pass in their own event handlers, but since
      // this is a directive, we will just keep a hold of it 
      config.eventHandlers = {};

      // Here we hendle adding extra functionality to each file as it is loaded
      // when a file is added, handle it.
      config.eventHandlers.addedfile = function(file) {
        var dropzone = this;
      };

      // when a file is about to send do this with the formData
      config.eventHandlers.sending = function(file, xhr, formData) {
        if (scope.data) {
          console.log('scope.data', scope.data);
          
          var data = angular.copy(scope.data);
          var dropzone = this;
          var upFile = {};

          if (!data.newName || data.newName === '') {
            dropzone.cancelUpload(file)
          } else {
            // console.log('scopeNgModel', scope[ngModel]);
            upFile.height = file.height;
            upFile.width = file.width;
            upFile.size = file.size;
            upFile.type = file.type;
            upFile.name = file.name;
            data.fileInfo = upFile;
            data.newName = scope.data.newName + ' ' + index;
            if (data.title) {
              data.title = scope.data.title + ' ' + index;
            }
            index = index + 1;
            console.log('scope.index', scope.index);
            
            data.new = true;

            formData.append('info', JSON.stringify(data));
          }
        } else {
          dropzone.cancelUpload(file)
        }
      };

      // when the upload succeeds, make sure to handle the response
      config.eventHandlers.success =  function (file, response) {
        if (response && response.scopeId) {
          // clean up the scope after the file is saved so that we don't have to
          // worry about the scope getting HUGE
          delete scope[response.scopeId];
        }
        console.log('file', file);
        console.log('response', response);
        // var dropzone = this;
        // dropzone.processQueue.bind(dropzone);
      }

      // when a file is done uploading do this.
      config.eventHandlers.complete = function(file) {
        var dropzone = this;
        if (file.status === Dropzone.CANCELED) {
          file.status = Dropzone.QUEUED;
        } else {
          this.removeFile(file);
          if (dropzone.autoProcessQueue) {
            return dropzone.processQueue();
          }
        }
      };

      // when a file is done uploading do this.
      config.eventHandlers.canceled = function(file) {
        console.log('file', file.status);
      };

      // create a Dropzone for the element with the given options
      dropzone = new Dropzone($(element).find('div.dropzone')[0], config.options);

      // bind the given event handlers
      angular.forEach(config.eventHandlers, function (handler, event) {
        dropzone.on(event, handler);
      });
      scope.saveAll = function(){
        dropzone.autoProcessQueue = true;
        dropzone.processQueue();
      }

      // this is necessary for the typeahead selects for tags.
      scope.onSelect = function(item, model, something) {
        if (typeof scope.searchKey === 'object' && scope.searchKey){
          Business.individual.getIndData(scope.searchKey.id).then(function(result) {
            // console.log('Typeahead Item Found: ', $scope.searchKey);
            // console.log('Individual: ', result);
          });
        } else {
          // console.log('searchKey', $scope.searchKey);
        }
      };
    }
  };
}]);
