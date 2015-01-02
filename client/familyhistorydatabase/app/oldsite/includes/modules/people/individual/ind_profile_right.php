<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
$individual = Person::getById($session->getVar('indvidual_id'));
$individual = recast('Person', $individual);


$parents = $individual->getParents();
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


$spouse = $individual->getSpouse();
$spouses = array();
if (!empty($spouse))
{
   foreach ($spouse as $key)
   {
      $person = Person::getById($key->spouse);
      $person = recast("Person", $person);
      $spouses[] = $person;
   }
}
else
{
   $person = null;
}

$temp_children = $individual->getChildren();
$children = array();
foreach ($temp_children as $instance)
{
   $children[] = Person::getById($instance->child);
}

usort($children, function($a, $b)
{
  return strcmp($b->sex, $a->sex);
});
//echo "<img style='position: absolute; bottom: 0px; z-index -1000;  width: inherit; min-width: 100%; height: auto;' src='images/et.jpg' alt='Ernest' title'Ernest Albert Law Family'>";
?>

<div class="fullSpan2 pull-right sizeme hide-on-small fixedRight" id="right-side">
   <h2 class="text-center">Family</h2>
   <hr class="style-four"/>
   <div class='text-center'style="margin-top: 10px;">
      <?php
      if (!empty($father))
      {
         $displayName = $father->firstName." ";
         if ($father->middleName)
         {
            $displayName .= $father->middleName." ";

         }
         $displayName .= $father->lastName;
         echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$father->id."'><p>Father: ".$displayName."</p></a>";
         $displayName = $mother->firstName." ";
      }
      if (!empty($mother))
      {
         $displayName = $mother->firstName." ";
         if ($mother->middleName)
         {
            $displayName .= $mother->middleName." ";

         }
         $displayName .= $mother->lastName;
         echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$mother->id."'><p>Mother: ".$displayName."</p></a>";
      }
      if (!empty($father))
      {
         if (isset($father) && isset($father->profile_pic))
         {
            $photo = File::getById($father->profile_pic);
            if (!empty($photo))
               echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$father->id."'><img class='img-rounded' style=' vertical-align:text-top; ' id='father' src='".$photo->viewlink."' width='100' height='auto' style='margin-left: -2px;'></a>";
            else
               echo "<img class='img-rounded' style=' vertical-align:text-top; ' id='mother' src='images/familytree.jpg' width='100' height='auto'>";
         }
      }

      if (!empty($mother))
      {
         if (isset($mother) && isset($mother->profile_pic))
         {
            $photo = File::getById($mother->profile_pic);
            if (!empty($photo))
               echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$mother->id."'><img class='img-rounded' style=' vertical-align:text-top; ' id='mother' src='".$photo->viewlink."' width='100' height='auto' style='margin-left: -2px;'></a>";
            else
               echo "<img class='img-rounded' style=' vertical-align:text-top; ' id='mother' src='images/familytree.jpg' width='100' height='auto'>";
         }
      }
      ?>
   </div>
   <div class='text-center'style="margin-top: 10px;">
      <?php
      if (!empty($spouses))
      {
         foreach ($spouses as $person)
         {
            # code...
            $displayName = $person->firstName." ";
            if ($person->middleName)
            {
               $displayName .= $person->middleName." ";

            }
            $displayName .= $person->lastName;
            echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$person->id."'><label for='spouse'>Spouse: ".$displayName."</label></a>";
            if (isset($person->profile_pic))
            {
               $photo = File::getById($person->profile_pic);
               if (!empty($photo))
               {
                  echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$person->id."'><img class='img-rounded' id='spouse' src='".$photo->viewlink."' width='130' height='auto' style='margin-left: -2px;'></a>";
               }
            }
         }
      }
      if (!empty($children))
      {

         foreach ($children as $child)
         {
            // echo "<pre>";
            // print_r($child);
            // echo "</pre>";
            if ($child)
            {

               $displayName = $child->firstName." ";
               if ($child->middleName)
               {
                  $displayName .= $child->middleName." ";

               }
               $displayName .= $child->lastName;
               echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$child->id."'><label for='".$child->id."' style='margin-top: 10px;'>";
               if ($child->sex == 'male')
               {
                  echo "Son: ";
               }
               else
               {
                  echo "Daughter: ";
               }
               echo $displayName."</label></a>";
               if ($child->profile_pic)
               {
                  $photo = File::getById($child->profile_pic);
                  if (!empty($photo))
                  {
                     echo "<a href='/?controller=individual&amp;action=homepage&amp;id=".$child->id."'><img class='img-rounded' id='".$child->id."' src='".$photo->viewlink."' width='100' height='auto' style='margin-left: -2px;'></a>";
                  }
               }
            }
         }
      }
      ?>
   </div>
   <?php
   // if (isset($children))
   // {
   //    echo "<pre>";
   //    print_r($children);
   //    echo "</pre>";
   // }
   ?>
</div>




<div class='sidebar'>

</div>
