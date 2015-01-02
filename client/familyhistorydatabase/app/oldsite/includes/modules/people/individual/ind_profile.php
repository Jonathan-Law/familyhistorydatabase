<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}

$person = Person::getById($session->getVar('indvidual_id'));
$person = recast('Person', $person);

$parents = $person->getParents();
if (!empty($parents))
{
   if ($parents[0]->gender == "father")
   {
      $father = Person::getById($parents[0]->parentId);
      if ($father)
      {
         $father = recast('Person', $father);
         if ($parents[1])
         {
            $mother = Person::getById($parents[1]->parentId);
            if ($mother)
            {
               $mother = recast('Person', $mother);
            }
         }
      }
   }
   else
   {
      $mother = Person::getById($parents[0]->parentId);
      if ($mother)
      {
         $mother = recast('Person', $mother);
         if ($parents[1])
         {
            $father = Person::getById($parents[1]->parentId);
            if ($father)
            {
               $father = recast('Person', $father);
            }
         }
      }
   }
}
//echo "<img style='position: absolute; bottom: 0px; z-index -1000;  width: inherit; min-width: 100%; height: auto;' src='images/et.jpg' alt='Ernest' title'Ernest Albert Law Family'>";
?>

<div class="fullSpan2 pull-left sizeme hide-on-smallest fixedLeft" style="font-size: 12px;">
   <div class='text-center'style="margin-top: 10px;">
      <?php
      if (isset($person->profile_pic))
      {
         $photo = File::getById($person->profile_pic);
         if (!empty($photo))
         {
            echo "<img class='img-rounded' src='".$photo->viewlink."' width='200' height='auto' style='margin-left: -2px;'>";
         }
      }

      echo "<h2 class='text-center'>Information</h2>";
      echo "<hr class='style-four'/>";
      ?>
   </div>
   <table>
      <tr>
         <td style='padding-left: 4px; padding-right: 4px;'>First Name:</td>
         <td>
            <?php echo $person->firstName;?>
         </td>
      </tr>
      <?php
      if ($person->middleName != "")
      {
         echo "<tr>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>Middle Name:</td>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>";
         echo "      $person->middleName";
         echo "   </td>";
         echo "</tr>";
      }
      ?>
      <tr>
         <td style='padding-left: 4px; padding-right: 4px;'>Last Name:</td>
         <td style='padding-left: 4px; padding-right: 4px;'>
            <?php echo $person->lastName;?>
         </td>
      </tr>
   </table>
   <hr class='style-four'/>
   <table>
      <tr>
         <td style='padding-left: 4px; padding-right: 4px;'>Year Born:</td>
         <td style='padding-left: 4px; padding-right: 4px;'>
            <?php echo $person->yearBorn;?>
         </td>
      </tr>
      <?php
      $ddate = explode("/", $person->yearDead);
      if ($ddate[0] <= date("Y") && $ddate[0] != "00")
      {
         echo "<tr>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>Year Died:</td>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>";
         {
            if ($person->yearD == 1)
               echo "(About)&nbsp;";
            echo $person->yearDead;
         }
         echo "   </td>";
         echo "</tr>";
      }
      if ($person->relationship != "" && $person->relationship != null)
      {
         echo "</table>";
         echo "<hr class='style-four'/>";
         echo "<table>";
         echo "<tr>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>Relationship to Michele or Marvin Law:</td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td style='padding-left: 4px; padding-right: 4px;'>";
         echo "&nbsp;&nbsp;&nbsp;&nbsp;".$person->relationship;
         echo "   </td>";
         echo "</tr>";
      }
      ?>
   </table>
   <hr class='style-four'/>

  <!--  <?php
   // if (isset($father))
   // {
   //    echo "<pre>";
   //    print_r($father);
   //    echo "</pre>";
   // }
   // if (isset($mother))
   // {
   //    echo "<pre>";
   //    print_r($mother);
   //    echo "</pre>";
   // }
  ?> -->
</div>




<div class='sidebar'>

</div>
