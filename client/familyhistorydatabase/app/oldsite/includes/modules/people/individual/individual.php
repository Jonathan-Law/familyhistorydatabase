<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
$person = Person::getById($session->getVar('indvidual_id'));
?>
<div class='greenlink little text-center' style='margin-top:10px;'>
   <a href="/?controller=index&amp;action=people&amp;last_name=<?php echo $session->getVar('lastname');?>">Back to "<?php echo ucfirst($session->getVar('lastname'));?>"</a> || 
   <a href="/?controller=index&amp;action=people&amp;letter=<?php echo $session->getVar('letter');?>">Back to "<?php echo ucfirst($session->getVar('letter'));?>"</a> || 
   <a href="/?controller=index&amp;action=people">Back to the alphabet</a>
</div>
<?php echo "<h1 class='text-center'>".$person->firstName." ";
if ($person->middleName != "")
{
   echo $person->middleName." ";
}
echo $person->lastName."</h1>";
?>
<hr class=""/>
<div class='inline_reset text-center'>
   <a href="/?controller=individual&amp;action=photo_album&amp;id=<?php echo $person->id; ?>" class="btn inline" id="photo_album_buttom" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url("<?php if ($person->profile_pic){echo File::getById($person->profile_pic)->viewlink.'") !important;';echo ' background-size: auto 130px; background-repeat: no-repeat; background-position: 50% 50%; ';}else{echo 'http://test2.familyhistorydatabase.org/images/familytree.jpg") !important; background-size: cover;';}?>'><div style=" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;">Pictures</div></a>
   <a href="/?controller=individual&amp;action=documents&amp;id=<?php echo $person->id; ?>" class="btn inline" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url("http://test2.familyhistorydatabase.org/images/stories.jpg") !important; background-size: cover;'><div style=" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;">Stories and Evidence</div></a>
   <a href="/?controller=individual&amp;action=family&amp;id=<?php echo $person->id; ?>" class="btn inline" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url("http://test2.familyhistorydatabase.org/images/familytree.jpg") !important; background-size: cover;'><div style=" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;">Family Information</div></a>
   <?php
   $session = mySession::getInstance();
   if ($session->isLoggedIn())
   {
      $user = User::current_user();
      $user = recast('user', $user);
      $check = Favorites::getFavorites($user->id, $person->id);
      if (!$check)
      {
         if ($user->rights == "normal")
         {
            echo "<a href='#' class=\"btn inline\" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px;background-image: url(\"http://test2.familyhistorydatabase.org/images/favoritesButton.jpg\") !important; background-size: cover;'><div style=\" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;\">Login or verify your account in order to add this individual to your favorites list</div></a>";
         }
         else
         {
            echo "<a href='#' class=\"btn inline add_to_favorites\" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url(\"http://test2.familyhistorydatabase.org/images/favoritesButton.jpg\") !important; background-size: cover;'' value='".$person->id."'><div style=\" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;\">Add to Favorites</div></a>";
         }
      }
      else
      {
         echo "<a href='/?controller=user&amp;action=favorites' class=\"btn inline\" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px;background-image: url(\"http://test2.familyhistorydatabase.org/images/favoritesButton.jpg\") !important; background-size: cover;'><div style=\" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;\">View Favorites List</div></a>";
      }
   }
   else
   {
      if ($session->isLoggedIn())
      {
         echo "<a class=\"btn inline\" href=\"#\" role=\"button\" data-toggle=\"modal\" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url(\"http://test2.familyhistorydatabase.org/images/favoritesButton.jpg\") !important; background-size: cover;'><div style=\" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;\">Verify your account in order to add this individual to your favorites list</div></a>";
      }
      else
      {
         echo "<a class=\"btn inline\" href=\"#logmein\" role=\"button\" data-toggle=\"modal\" style='vertical-align:text-top; cursor: pointer; margin-top: 4px; width: 150px; height: 100px; background-image: url(\"http://test2.familyhistorydatabase.org/images/favoritesButton.jpg\") !important; background-size: cover;'><div style=\" border-radius: 4px; padding: 2px; background-color:rgba(255,255,255,0.6); font-weight: bold;\">Login in order to add this individual to your favorites list</div></a>";
      }
   }
   ?>
</div>
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