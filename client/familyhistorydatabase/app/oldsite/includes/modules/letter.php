<?php
$session = mySession::getInstance();
$type = $session->getType();

global $people;
if ($type == 'lastnames')
{
   $letter = $session->getVar('letter');
   echo "<h1 class='text-center'>People with the Last Name starting with: ".ucfirst($letter)."</h1>";
   include_module('letters.php');
   echo "<hr/>";
   echo "<div class='container-fluid text-center inline_reset'>";
   echo "<div class='inline textleft greenlink'>";
   foreach ($people as $person => $value) 
   {
      echo "   <a href='/?controller=index&action=people&last_name=".strtolower($value['lastName'])."''>".strtoupper($value['lastName'])."</a> <br/>";
   }      
   echo "</div>";
   echo "</div>";
}
else if ($type == 'firstnames')
{
   $lastname = $session->getVar('lastname');
   echo "<h1 class='text-center'>People with the Last Name starting with: ".ucfirst($lastname)."</h1>";
   include_module('letters.php');
   echo "<hr/>";
   echo "<div class='container-fluid text-center inline_reset'>";
   echo "<div class='inline textleft greenlink'>";
   echo "<table>";
   foreach ($people as $person => $value) 
   {
      $ddate = explode("/", $value['yearDead']);
      echo "<tr>";
      if ($value['middleName'] != '')
      {
         $name = $value['firstName']." ".$value['middleName']." ".$value['lastName'];
      }
      else
      {
         $name = $value['firstName']." ".$value['lastName'];
      }
      if ($ddate[0] <= date("Y") && $ddate[0] != "00")
      {

         echo "   <td><a href='/?controller=individual&action=homepage&id=".$value['id']."'>".$name.
         "</a></td><td><span style='color: #5c5c5c !important; font-size: 12px;'>-- Born: ".$value['yearBorn']." || Died: ".$value['yearDead']."</span></td>";
      }
      else
      {
         echo "   <td><a href='/?controller=individual&action=homepage&id=".$value['id']."'>".$name.
         "</a></td><td><span style='color: #5c5c5c !important; font-size: 12px;'>-- Born: ".$value['yearBorn']."</span></td>";
      }
      echo "</tr>";
   } 
   echo "</table>";     
   echo "</div>";
   echo "</div>";
}
?>

<script type="text/javascript">
$(document).ready(function()
{
   var name = 
   <?php 
   if ($type == 'lastnames')
   {
      echo '"Family names starting with '.ucfirst($letter);
   }
   else if ($type == 'firstnames')
   {
      echo '"'.ucfirst($lastname).' Family';
   }
   echo '";';
   ?>
   setTitle(name);
});
</script>