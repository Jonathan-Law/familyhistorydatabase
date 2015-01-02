<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
?>

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
<script type="text/javascript" src="javascript/app/modules/data/dataController.js"></script>

<div ng-app="base" class="top-Buffer" ng-controller='dataController'>
   <div >
      <input ng-enter="doSearch()" auto-complete ui-items="names" ng-model="selected" ng-change="updateNames()" class="ui-autocomplete-input" style="width: 80%" placeholder="Enter your search criteria here">
      <button ng-click="doSearch()">Search</button>
   </div>
   <div class="tabbable">
      <ul class="nav nav-tabs top-Buffer">
         <li>
            <span class="fake-Nav-Link">Search in: </span> 
         </li>
         <li ng-class="{active: main.active.tab == 'documents'}" ng-init="main.active.tab = 'documents'">
            <a ng-click='main.active.tab = "documents"; page = "documents"'>Documents
            </a>
         </li>
         <li ng-class="{active: main.active.tab == 'other'}">
            <a ng-click='main.active.tab = "other"; page = "other"'>Other
            </a>
         </li>
         <li ng-class="{active: main.active.tab == 'people'}">
            <a ng-click='main.active.tab = "people"; page = "people"'>People
            </a>
         </li>
      </ul>
      <div class="tab-content top-Buffer">
         <div class="animate-switch-container" ng-switch='main.active.tab'>
            <div class="animate-switch" ng-switch-when='people'>
               <div class='inline_reset' style="text-align: left !important; white-space: nowrap">
                  <button ng-disabled="currentPagePeople == 0" ng-click="currentPagePeople=currentPagePeople-1; resetPopover();" class="lastPage">
                     Previous
                  </button>
                  Page {{currentPagePeople+1}} of {{numberOfPagesPeople()}}
                  <button ng-disabled="currentPagePeople >= people.length/pageSize - 1" ng-click="currentPagePeople=currentPagePeople+1; resetPopover();" class="nextPage">
                     Next
                  </button>
                  <div ng-show="!loaded"><div class="loading pull-left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading Search Results. Please Wait...&nbsp;&nbsp;&nbsp;</div></div>
                  <ul class="noBullets">
                     <li ng-if="people.length < 0">{{noResults}}</li>
                     <li ng-repeat="item in people | startFrom:this | limitTo:pageSize" class="peopleItem clip" >
                        <div>
                           <a ng-if="item.profilePic == null" href="?controller=individual&amp;action=homepage&amp;id={{item.id}}">{{item.dName}}</a>
                           <a ng-if="item.profilePic != null" href="?controller=individual&amp;action=homepage&amp;id={{item.id}}" class="addPop" id='{{item.id}}'>{{item.dName}}</a>
                           -- Born: {{item.yearBorn}} | Died: {{item.yearDead}} 
                           <br />
                           &nbsp;&nbsp;&nbsp;&nbsp;Relationship to Michele/Marvin: <span ng-if="item.relationship != ''">{{item.relationship}}</span><span ng-if="item.relationship == ''">{{noRelationship}}</span>
                           <br />
                           <div ng-if="item.parents.length < 1"> &nbsp;&nbsp;&nbsp;&nbsp;{{noParents}} </div>
                           <div ng-if="item.parents.length > 0" ng-switch="item.parents[0].sex">
                              <div ng-switch-when="male"> 
                                 <span ng-if="item.parents.length > 1">&nbsp;&nbsp;&nbsp;&nbsp;Father: {{item.parents[0].dName}} | Mother: {{item.parents[1].dName}}</span> 
                                 <span ng-if="item.parents.length < 2">&nbsp;&nbsp;&nbsp;&nbsp;Father: {{item.parents[0].dName}} | {{noMother}}</span> 
                              </div>
                              <div ng-switch-when="female"> 
                                 <span ng-if="item.parents.length > 1">&nbsp;&nbsp;&nbsp;&nbsp;Father: {{item.parents[1].dName}} | Mother: {{item.parents[2].dName}}</span> 
                                 <span ng-if="item.parents.length < 2">&nbsp;&nbsp;&nbsp;&nbsp;{{noFather}} | Mother: {{item.parents[2].dName}}</span> 
                              </div>
                           </div>
                           <br />
                        </div>
                     </li>
                  </ul>
                  <br/>
                  <button ng-disabled="currentPagePeople == 0" ng-click="currentPagePeople=currentPagePeople-1; resetPopover();" class="lastPage">
                     Previous
                  </button>
                  Page {{currentPagePeople+1}} of {{numberOfPagesPeople()}}
                  <button ng-disabled="currentPagePeople >= people.length/pageSize - 1" ng-click="currentPagePeople=currentPagePeople+1; resetPopover();" class="nextPage">
                     Next
                  </button>
               </div>
            </div>
            <div class="animate-switch" ng-switch-default>
               <button ng-disabled="currentPageDocuments == 0" ng-click="currentPageDocuments=currentPageDocuments-1">
                  Previous
               </button>
               {{currentPageDocuments+1}}/{{numberOfPagesDocuments()}}
               <button ng-disabled="currentPageDocuments >= documents.length/pageSize - 1" ng-click="currentPageDocuments=currentPageDocuments+1">
                  Next
               </button>
               <div style="margin-top: 10px" ng-show="!loaded" id="loadingSpinnerAddon"><div class="loading pull-left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pleas enter some data file search criteria and click on "Search"...&nbsp;&nbsp;&nbsp;</div><div id="loading-bar-spinner" ng-show="loading"><div class="spinner-icon"></div></div><div class="clear_both"></div></div>
               <ul style="list-style-type: none; padding-top: 10px">
                  <li ng-if="documents.length < 0">{{noResults}}</li>
                  <li ng-repeat="document in documents | startFrom:this | limitTo:pageSize">
                     <div ng-if='document.viewlink != null'>
                        <a href="{{document.link}}">
                           <div class="clear_both pull-left inline_reset results_Document" >
                              <img class="inline" src="{{document.viewlink}}" alt="{{document.title}}" title="{{document.title}}" style="margin: 0px !important; padding: 0px;" height="90px" width="auto">
                           </div>
                        </a>
                        <div style="height: 97px; margin-left: 135px;" >
                           <div style="height: 85px; padding-top: 5px; overflow: auto;">
                              Description: {{document.comments}} 
                              <br />
                              &nbsp;&nbsp;&nbsp;&nbsp;--Date: {{document.date}}
                           </div>
                        </div>
                     </div>
                     <div ng-if='document.viewlink == null'>
                        <a href="{{document.link}}">
                           <div class="clear_both pull-left inline_reset results_Document" >
                              <img class="inline" src="/images/doc_error.png" alt="{{document.title}}" title="{{document.title}}" style="margin: 0px !important; padding: 0px;" height="90px" width="auto">
                           </div>
                        </a>
                        <div style="height: 97px; margin-left: 135px;" >
                           <div style="height: 85px; padding-top: 5px; overflow: auto;">
                              Description: {{document.comments}} 
                              <br />
                              &nbsp;&nbsp;&nbsp;&nbsp;--Date: {{document.date}}
                           </div>
                        </div>
                     </div>

                     <a type="button" class="btn btn-primary" style="margin-top: -5px; margin-bottom: 5px; width: 107px;" href="/?controller=admin&amp;action=editFile&amp;id={{document.id}}">Edit this</a>

                  </li>
               </ul>
               <button ng-disabled="currentPageDocuments == 0" ng-click="currentPageDocuments=currentPageDocuments-1">
                  Previous
               </button>
               {{currentPageDocuments+1}}/{{numberOfPagesDocuments()}}
               <button ng-disabled="currentPageDocuments >= documents.length/pageSize - 1" ng-click="currentPageDocuments=currentPageDocuments+1">
                  Next
               </button>
            <!-- <div class='inline_reset'>
               <?php
      //          $count = 0;
      //          foreach ($search_result_file as $result)
      //          {
      //             echo "<div class='inline text-left search_data_child'>";
      //             if (isset($result->profile_pic))
      //             {
      //                $photo = File::getById($result->profile_pic);
      //                if (!empty($photo))
      //                {
      //                   echo "<div class='pull-left' style=''>";
      //                   echo "<img class='img-rounded' src='".$photo->viewlink."' width='auto' height='75' style='margin-left: -2px; max-height: 80px !important;'>";
      //                   echo "</div>";
      //                }
      //             }
      //             echo "<div class='' style='white-space: nowrap; overflow-x: auto'>";
      //             echo "Name: ";
      //             echo $result->firstName." ";
      //             if ($result->middleName != "")
      //             {
      //                echo $result->middleName." ";
      //             }
      //             echo $result->lastName;
      //             echo "<br/>";
      //             echo "&nbsp;&nbsp;&nbsp;Born: ".$result->yearBorn;
      //             echo "<br/>";
      //             echo "&nbsp;&nbsp;&nbsp;Died: ".$result->yearDead;
      //             echo "</div>";
      // // print_r($result);
      //             echo "</div>";
      //          }
               ?> -->
               <!-- </div> -->
            </div>
            <div class="animate-switch" ng-switch-when="other">
               <ul>
                  <li ng-if="other.length < 1">{{noResults}}</li>
                  <li ng-repeat="document in other | startFrom:this | limitTo:pageSize">
                     {{document}}
                  </li>
               </ul>
               <button ng-disabled="currentPageOther == 0" ng-click="currentPageOther=currentPageOther-1">
                  Previous
               </button>
               {{currentPageOther+1}}/{{numberOfPagesOther()}}
               <button ng-disabled="currentPageOther >= other.length/pageSize - 1" ng-click="currentPageOther=currentPageOther+1">
                  Next
               </button>
<!--           <div class='inline_reset'>
               <?php
      //          $count = 0;
      //          foreach ($search_result_other as $result)
      //          {
      //             echo "<div class='inline text-left search_data_child'>";
      //             if (isset($result->profile_pic))
      //             {
      //                $photo = File::getById($result->profile_pic);
      //                if (!empty($photo))
      //                {
      //                   echo "<div class='pull-left' style=''>";
      //                   echo "<img class='img-rounded' src='".$photo->viewlink."' width='auto' height='75' style='margin-left: -2px; max-height: 80px !important;'>";
      //                   echo "</div>";
      //                }
      //             }
      //             echo "<div class='' style='white-space: nowrap; overflow-x: auto'>";
      //             echo "Name: ";
      //             echo $result->firstName." ";
      //             if ($result->middleName != "")
      //             {
      //                echo $result->middleName." ";
      //             }
      //             echo $result->lastName;
      //             echo "<br/>";
      //             echo "&nbsp;&nbsp;&nbsp;Born: ".$result->yearBorn;
      //             echo "<br/>";
      //             echo "&nbsp;&nbsp;&nbsp;Died: ".$result->yearDead;
      //             echo "</div>";
      // // print_r($result);
      //             echo "</div>";
      //          }
               ?>
            </div> -->
         </div>
      </div>
   </div>
</div>
</div>