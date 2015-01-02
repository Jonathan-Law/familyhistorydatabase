<?php 
$session = mySession::getInstance();
$page = $session->getPage();
$key  = $session->getKey();
$value = $session->getValue();
echo "<p style='margin-top: 10px; color:red; text-align: center; font-size: 20px;'>".$session->message()."</p>";
$session->resetMessage();

if ($key == 'letter' || $key == 'lastname')
{
   if ($key == 'letter')
   {
      $letter = $value;
   }
   else if ($key == 'lastname')
   {
      $lastname = $value;
   }
   $session->delete('key');
   $session->delete('value');
   include_module('letter.php');
}
else
{
   echo "<div class='text-center'>";
   echo "<h3>Just click on a letter to search for your individual!!!</h3>";
   echo "<h5>Entries are indexed by last name or place name.</h5>";
   $session->save("page", "people");
   include_module('people/individual/ind.php');
   echo "</div>";
}

if ($page == 'home')
{
   echo "<div class='inline_reset text-center'>";
   echo "<img src='images/Ernest Albert Law Family.jpg' alt='Ernest' title'Ernest Albert Law Family' class='inline' style='width: inherit; max-width: 100%; height: auto; padding: 0px !important'  >";
   echo "</div>";
}
?>

<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Individuals Page");
});
</script>