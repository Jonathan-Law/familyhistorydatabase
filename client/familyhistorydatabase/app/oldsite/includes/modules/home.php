<?php 
$session = mySession::getInstance();
$page = $session->getPage();
$key  = $session->getKey();
$value = $session->getValue();
echo "<p style='color:red; text-align: center; font-size: 20px; margin-top: 10px;'>".$session->message()."</p>";
$session->resetMessage();

if ($page == 'people' || $page == 'home')
   $pagename = 'family/person';
else
   $pagename = $page;
echo "<div class='text-center'>";
echo "<a href='http://old.familyhistorydatabase.org' class='btn btn-info' title='Old Family History Database Website' alt='old familyhistorydatabase website'>Go back to the old family history website.</a>";
echo "<h3>Just click on a letter to search for your $pagename!!!</h3>";
echo "<h5>Entries are indexed by last name or place name.</h5>";
$session->save("page", "people");
include_module('people/individual/ind.php');
echo "</div>";

// || $page == 'mayflower'
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
   $("#page_name").html("Home Page");
});
</script>
