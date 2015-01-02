<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
// [controller] => individual
// [action] => photo_album
// [id] => 663
$person = Person::getById($session->getVar('indvidual_id'));
$person = recast("Person", $person);
$documents = File::getDocuments($person->id);
// echo "<pre>";
// print_r($documents);
// //echo this;
// echo "</pre>";
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
?>
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
<?php
echo "<div style='margin-top: 10px' class='text-center'>";
echo "<h1>Documents for: ".$person->displayName()."</h1>";
echo "</div>";
echo "<hr/>";
$i = 0;
$len = count($documents);
if ($len > 0)
{
   function cmp($a, $b)
   {
      return strcmp($a->title, $b->title);
   }

   usort($documents, "cmp");
   echo "<div style='margin-left: 20px; margin-right: 20px'>";
   foreach ($documents as $key) 
   {
      $date = date("F j, Y, g:i a", strtotime($key->date));
      echo ($i+1).".&nbsp;<a href=\"".$key->link."\" target=\"_blank\">".$key->title."</a><br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&nbsp;".$key->comments."</span>";
      if ($key->author)
      {
         echo "<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&nbsp;Author: ".$key->author."&nbsp;&mdash;&nbsp;Date Uploaded: ".$date;
      }
      else
      {
         echo "<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&nbsp;Date uploaded: ".$date;
      }

      echo "</span>";
      if ($i != $len - 1)
      {
         echo "<hr class='style-four'>";
      }
      $i++;
   }
   echo "</div>";
}
else
{
   echo "<div style='text-align: center !important'><h3>Sorry, there are no documents for this individual yet. If you'd like to contribute to their portfolio, please contact Michele Law!</h3></div>";
}
?>


<script type="text/javascript">
$(document).ready(function()
{
   var name = <?php echo '"'.$person->firstName.' ';
      // if ($person->middleName != '')
      // {
         //    echo $person->middleName.' ';
         // }
         echo $person->lastName.' ';
         if ($person->yearBorn != '0')
         {
            echo $person->yearBorn.'-'.$person->yearDead.'";';
         }
         else
         {
            echo '";';
         }
         ?>
   $("#page_name").html(name);
   words = new Array();
   words.push("Familyhistorydatabase.org");
   words.push("family");
   words.push("history");
   words.push("<?php echo $person->lastName; ?>");
   words.push("<?php echo $person->firstName; ?>");
   setKeywords(words);
   setTitle(name);

});
</script>