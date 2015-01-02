<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
?>
<script text="text/javascript">
var fileID = <?php echo $session->get("fileID"); ?>;
</script>
<script type="text/javascript" src="javascript/angular-1.2.1/angular.js"></script>
<script type="text/javascript" src="javascript/underscore.js"></script>
<link rel="stylesheet" href="javascript/app/loadingBar/build/loading-bar.css">
<link rel="stylesheet" href="javascript/jquery-ui/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css">
<script type="text/javascript" src="javascript/angular-1.2.1/angular-route.js"></script>
<script type="text/javascript" src="javascript/angular-1.2.1/angular-animate.js"></script>
<script type="text/javascript" src="javascript/underscore.js"></script>
<link rel="stylesheet" href="javascript/app/loadingBar/build/loading-bar.css">
<script type="text/javascript" src="javascript/app/loadingBar/build/loading-bar.js"></script>
<script type="text/javascript" src="javascript/app/app.js"></script>
<script type="text/javascript" src="javascript/jquery-ui/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="javascript/app/modules/base/services/localCache.js"></script>
<script type="text/javascript" src="javascript/app/modules/base/services/services.js"></script>
<script type="text/javascript" src="javascript/app/modules/base/directives/autocomplete.js"></script>

<script type="text/javascript" src="javascript/app/modules/data/dataEditController.js"></script>

<div ng-app="base" class="top-Buffer" ng-controller='dataEditController'>
   <div>
      <div style="margin-top: 10px" ng-show="!loaded" id="loadingSpinnerAddon">
         <div class="loading pull-left" >
         </div>
         <div id="loading-bar-spinner" ng-show="loading">
         </div>
         <div class="clear_both">
         </div>
      </div>
      <div>
         <div style="width: 100%; min-height: 100px;">
            <div ng-if='file.file.viewlink != null'>
               <a href="{{file.file.link}}">
                  <div class="clear_both pull-left inline_reset results_Document" >
                     <img class="inline" src="{{file.file.viewlink}}" alt="{{file.file.title}}" title="{{file.file.title}}" style="margin: 0px !important; padding: 0px;" height="90px" width="auto">
                  </div>
               </a>
               <div style=" margin-left: 135px;" >
                  <div style=" padding-top: 5px; overflow: auto;">
                     <strong>
                        Description/Comments:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.comments"></textarea>
                     <br />
                     <strong>
                        Title:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.title"></textarea>
                     <br />
                     <strong>
                        Author:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.author"></textarea> 
                     <br />
                     &nbsp;&nbsp;&nbsp;&nbsp;--Date uploaded: {{file.file.date}}
                     <div>
                        <button ng-click="updateFileData()" class="btn btn-success">Save Changes <i class="icon-ok"></i></button>
                        <button ng-click="grabData()" class="btn btn-warning">Revert Changes <i class="icon-remove"></i></button>
                     </div>
                  </div>
               </div>
            </div>
            <div ng-if='file.file.viewlink == null'>
               <a href="{{file.file.link}}">
                  <div class="clear_both pull-left inline_reset results_Document" >
                     <img class="inline" src="/images/doc_error.png" alt="{{file.file.title}}" title="{{file.file.title}}" style="margin: 0px !important; padding: 0px;" height="90px" width="auto">
                  </div>
               </a>
               <div style="margin-left: 135px;" >
                  <div style=" padding-top: 5px; overflow: auto;">
                     <strong>
                        Description/Comments:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.comments"></textarea>
                     <br />
                     <strong>
                        Title:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.title"></textarea>
                     <br />
                     <strong>
                        Author:
                     </strong>
                     <textarea style="width: calc(100% - 20px);" ng-model="file.file.author"></textarea> 
                     <br />
                     &nbsp;&nbsp;&nbsp;&nbsp;--Date uploaded: {{file.file.date}}
                  </div>
                  <div>
                     <button ng-click="updateFileData()" class="btn btn-success">Save Changes <i class="icon-ok"></i></button>
                     <button ng-click="grabData()" class="btn btn-warning">Revert Changes <i class="icon-remove"></i></button>
                  </div>
               </div>
            </div>
         </div>
         <div>
            <strong>Tags:</strong>
         </div>
         <table class="table table-striped" style="background: white;">
            <tr ng-repeat="item in file.tags">
               <td>
                  {{item.name}} ({{item.type}})<button class="btn btn-danger pull-right addButtonPopover" style="min-width: 100px" ng-click="deleteTag(item.id)" ><i class="icon-remove"></i></button>
               </td>
            </tr>
         </table>
         <div>
            <strong>Add Tags (works only for images):</strong>
         </div>
         <div class='typeaheadDiv'>
            <input class="typeahead first" ng-model="addTagPerson"/>
            <button class="btn btn-success" ng-click="addTag(file.file.id, 'image')">Add image tag <i class="icon-ok"></i></button>
            <button class="btn btn-success" ng-click="addTag(file.file.id, 'other')">Add other tag <i class="icon-ok"></i></button>
         </div>
      </div>
   </div>
</div>