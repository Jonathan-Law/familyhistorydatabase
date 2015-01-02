<?php
if (!isset($session))
{
	$session = mySession::getInstance();
}

$person = Person::getById($session->getVar('indvidual_id'));
?>
<script type="text/javascript" src="javascript/angular.js"></script>
<script type="text/javascript" src="javascript/underscore.js"></script>
<script type="text/javascript" src="javascript/angular-1.2.1/angular-route.js"></script>
<script type="text/javascript" src="javascript/angular-1.2.1/angular-animate.js"></script>
<script type="text/javascript" src="javascript/underscore.js"></script>
<link rel="stylesheet" href="javascript/app/loadingBar/build/loading-bar.css">
<script type="text/javascript" src="javascript/app/loadingBar/build/loading-bar.js"></script>
<script type="text/javascript" src="javascript/app/app.js"></script>
<script type="text/javascript" src="javascript/app/modules/base/services/localCache.js"></script>
<script type="text/javascript" src="javascript/app/modules/base/services/services.js"></script>
<script type="text/javascript" src="javascript/app/modules/familyChart/familyChart.js"></script>
<div class='greenlink little text-center' style='margin-top:10px; margin-bottom: -10px'>
   <a href="/?controller=individual&amp;action=homepage&amp;id=<?php echo $session->getVar('indvidual_id');?>">Back to "<?php 
   echo $person->firstName." ";
   if ($person->middleName)
   {
      echo $person->middleName." ";
   }
   echo $person->lastName;
   ?>"</a> || 
   <a href="/?controller=index&amp;action=people&amp;last_name=<?php echo $session->getVar('lastname');?>">Back to "<?php echo ucfirst($session->getVar('lastname'));?>"</a> || 
   <a href="/?controller=index&amp;action=people&amp;letter=<?php echo $session->getVar('letter');?>">Back to "<?php echo ucfirst($session->getVar('letter'));?>"</a> || 
   <a href="/?controller=index&amp;action=people">Back to the alphabet</a>
</div>
<hr class=""/>
<div class='inline_reset text-center'>









	<div ng-app="base" class="personId container-fluid" >
		<div ng-controller="familyChartCtrl" class="row-fluid fChart">
         <!-- <pre ng-bind="testing"></pre> -->
      <!--          <div ng-if="children.length < 1" >There are no children<br/>Unknown or not recorded yet</div>
         <div ng-repeat="child in children">
            <h1>Children</h1 class="fcnode">
            <span class="primary-item">{{child.id}}  </span>
            <span class="course-grade">{{child.firstName}} {{child.lastName}}</span>
         </div>  
      -->
      <div class="span3">
         <h4 >individual</h4>
         <div >
            <a href="?controller=individual&amp;action=homepage&amp;id={{individual.id}}">
               <div class="individual fcnode individual" id="{{individual.id}}">
                  <span class="course-grade">{{individual.firstName}} {{individual.lastName}}</span>
                  <br />
                  <span ng-if"individual.yearBorn != '0'">Born--{{individual.yearBorn}} |</span>
                  <span ng-if"individual.yearDead != '0'"> Died--{{individual.yearDead}}</span>
               </div>  
            </a>
         </div>  
         <h4>Spouse</h4>
         <div ng-if="spouse.length < 1" class="fcnode spouse" >Spouse<br/>Unknown or not recorded yet</div>
         <div ng-repeat="spo in spouse" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{spo.id}}">
               <div class="indiv-course fcnode spouse" id="{{spo.id}}">
                  <span class="course-grade">{{spo.firstName}} {{spo.lastName}}</span>
                  <br />
                  <span ng-if"spo.yearBorn != '0'">Born--{{spo.yearBorn}} |</span>
                  <span ng-if"spo.yearDead != '0'"> Died--{{spo.yearDead}}</span>
               </div>  
            </a>
         </div>  
      </div>



      <div class="span3">
         <h4>Parents</h4>
         <div ng-if="parents.father < 1"  class="father fcnode lfather">Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="father in parents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{father.id}}">
               <div class="father fcnode lfather" id="{{father.id}}">
                  <span class="course-grade">{{father.firstName}} {{father.lastName}}</span>
                  <br />
                  <span ng-if"father.yearBorn != '0'">Born--{{father.yearBorn}} |</span>
                  <span ng-if"father.yearDead != '0'"> Died--{{father.yearDead}}</span>
               </div>  
            </a>
         </div>  
         <div ng-if="parents.mother < 1" class="mother fcnode lmother">Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mother in parents.mother" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mother.id}}">
               <div class="mother fcnode lmother" id="{{mother.id}}">
                  <span class="course-grade">{{mother.firstName}} {{mother.lastName}}</span>
                  <br />
                  <span ng-if"mother.yearBorn != '0'">Born--{{mother.yearBorn}} |</span>
                  <span ng-if"mother.yearDead != '0'"> Died--{{mother.yearDead}}</span>
               </div>  
            </a>
         </div>  
      </div>



      <div class="span3">
         <h4>Grand Parents</h4>
         <div ng-if="fparents.father < 1"  class="gparents fcnode ffather">Father's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="ffather in fparents.father"  >
            <a href="?controller=individual&amp;action=homepage&amp;id={{ffather.id}}">
               <div class="gparents fcnode ffather" id="{{ffather.id}}">
                  <span class="course-grade">{{ffather.firstName}} {{ffather.lastName}}</span>
                  <br />
                  <span ng-if"ffather.yearBorn != '0'">Born--{{ffather.yearBorn}} |</span>
                  <span ng-if"ffather.yearDead != '0'"> Died--{{ffather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="fparents.mother < 1" class="gparents fcnode fmother">Father's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="fmother in fparents.mother" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{fmother.id}}">
               <div class="gparents fcnode fmother" id="{{fmother.id}}">
                  <span class="course-grade">{{fmother.firstName}} {{fmother.lastName}}</span>
                  <br />
                  <span ng-if"fmother.yearBorn != '0'">Born--{{fmother.yearBorn}} |</span>
                  <span ng-if"fmother.yearDead != '0'"> Died--{{fmother.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="mparents.father < 1" class="gparents2 fcnode mfather">Mother's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mfather in mparents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mfather.id}}">
               <div class="gparents2 fcnode mfather" id="{{mfather.id}}">
                  <span class="course-grade">{{mfather.firstName}} {{mfather.lastName}}</span>
                  <br />
                  <span ng-if"mfather.yearBorn != '0'">Born--{{mfather.yearBorn}} |</span>
                  <span ng-if"mfather.yearDead != '0'"> Died--{{mfather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="mparents.mother < 1" class="gparents fcnode mmother">Mother's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mmother in mparents.mother" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mmother.id}}">
               <div class="gparents fcnode mmother" id="{{mmother.id}}">
                  <span class="course-grade">{{mmother.firstName}} {{mmother.lastName}}</span>
                  <br />
                  <span ng-if"mmother.yearBorn != '0'">Born--{{mmother.yearBorn}} |</span>
                  <span ng-if"mmother.yearDead != '0'"> Died--{{mmother.yearDead}}</span>
               </div>  
            </a>
         </div>  
      </div>  




      <div class="span3">
         <h4>Great Grand Parents</h4>
         <div ng-if="ffparents.father < 1" class="ggparents fcnode fffather" >Father's Father's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="ffather in ffparents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{ffather.id}}">
               <div class="ggparents fcnode fffather" id="{{ffather.id}}">
                  <span class="course-grade">{{ffather.firstName}} {{ffather.lastName}}</span>
                  <br />
                  <span ng-if"ffather.yearBorn != '0'">Born--{{ffather.yearBorn}} |</span>
                  <span ng-if"ffather.yearDead != '0'"> Died--{{ffather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="ffparents.mother < 1" class="fcnode ffmother" >Father's Father's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="fmother in ffparents.mother" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{fmother.id}}">
               <div class="fcnode ffmother" id="{{fmother.id}}">
                  <span class="course-grade">{{fmother.firstName}} {{fmother.lastName}}</span>
                  <br />
                  <span ng-if"fmother.yearBorn != '0'">Born--{{fmother.yearBorn}} |</span>
                  <span ng-if"fmother.yearDead != '0'"> Died--{{fmother.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="fmparents.father < 1" class="fcnode fmfather" >Father's Mother's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="ffather in fmparents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{ffather.id}}">
               <div class="fcnode fmfather" id="{{ffather.id}}">
                  <span class="course-grade">{{ffather.firstName}} {{ffather.lastName}}</span>
                  <br />
                  <span ng-if"ffather.yearBorn != '0'">Born--{{ffather.yearBorn}} |</span>
                  <span ng-if"ffather.yearDead != '0'"> Died--{{ffather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="fmparents.mother < 1" class="fcnode fmmother" >Father's Mother's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="fmother in fmparents.mother">
            <a href="?controller=individual&amp;action=homepage&amp;id={{fmother.id}}">
               <div  class="fcnode fmmother" id="{{fmother.id}}">
                  <span class="course-grade">{{fmother.firstName}} {{fmother.lastName}}</span>
                  <br />
                  <span ng-if"fmother.yearBorn != '0'">Born--{{fmother.yearBorn}} |</span>
                  <span ng-if"fmother.yearDead != '0'"> Died--{{fmother.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="mfparents.father < 1" class="ggparents2 fcnode mffather" >Mother's Father's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mfather in mfparents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mfather.id}}">
               <div class="ggparents2 fcnode mffather" id="{{mfather.id}}">
                  <span class="course-grade">{{mfather.firstName}} {{mfather.lastName}}</span>
                  <br />
                  <span ng-if"mfather.yearBorn != '0'">Born--{{mfather.yearBorn}} |</span>
                  <span ng-if"mfather.yearDead != '0'"> Died--{{mfather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="mfparents.mother < 1" class="fcnode mfmother" >Mother's Father's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mmother in mfparents.mother" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mmother.id}}">
               <div class="fcnode mfmother" id="{{mmother.id}}">
                  <span class="course-grade">{{mmother.firstName}} {{mmother.lastName}}</span>
                  <br />
                  <span ng-if"mmother.yearBorn != '0'">Born--{{mmother.yearBorn}} |</span>
                  <span ng-if"mmother.yearDead != '0'"> Died--{{mmother.yearDead}}</span>
               </div>  
            </a>
         </div>  
         <div ng-if="mmparents.father < 1" class="fcnode mmfather" >Mother's Mother's Father<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mfather in mmparents.father" >
            <a href="?controller=individual&amp;action=homepage&amp;id={{mfather.id}}">
               <div class="fcnode mmfather" id="{{mfather.id}}">
                  <span class="course-grade">{{mfather.firstName}} {{mfather.lastName}}</span>
                  <br />
                  <span ng-if"mfather.yearBorn != '0'">Born--{{mfather.yearBorn}} |</span>
                  <span ng-if"mfather.yearDead != '0'"> Died--{{mfather.yearDead}}</span>
               </div>
            </a>
         </div>
         <div ng-if="mmparents.mother < 1" class="fcnode mmmother" >Mother's Mother's Mother<br/>Unknown or not recorded yet</div>
         <div ng-repeat="mmother in mmparents.mother">
            <a href="?controller=individual&amp;action=homepage&amp;id={{mmother.id}}">
               <div class="fcnode mmmother" id="{{mmother.id}}">
                  <span class="course-grade">{{mmother.firstName}} {{mmother.lastName}}</span>
                  <br />
                  <span ng-if"mmother.yearBorn != '0'">Born--{{mmother.yearBorn}} |</span>
                  <span ng-if"mmother.yearDead != '0'"> Died--{{mmother.yearDead}}</span>
               </div>  
            </a>
         </div>  
      </div> 



   </div>
</div>












</div>
<script type="text/javascript">
var history = new Array();
var index = 0;
history.push(<?php echo $person->id?>);
$(document).ready(function()
{
  $("#page_name").html("<?php echo $person->firstName.' ';
    // if ($person->middleName != '')
    // {
      //    echo $person->middleName.' ';
      // }
      echo $person->lastName;
      $reverse = strrev( $person->lastName );

      // Echo or do whatever with it

      if ($reverse[0] != 's')
      {
        echo '\'s';
     }
     else
     {
        echo '\'';
     }
     ?> Family Page");
      var name =  <?php 
      if ($type == 'lastnames')
      {
         echo '"Family names starting with '.ucfirst($letter);
      }
      else if ($type == 'firstnames')
      {
         echo '"'.ucfirst($lastname).' Family';
      }
      if ($type == 'lastnames' || $type == 'firstnames')
         echo '";';
      else
         echo "'';";
      ?>
      setTitle(name);

});
</script>
