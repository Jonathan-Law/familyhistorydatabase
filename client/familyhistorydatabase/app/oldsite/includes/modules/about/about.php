<?php 
echo "<div class='hero-unit text-center' style='margin-top: 10px'>";
echo "<h1>Website Info</h1>";
echo "<hr/>";
echo "<div class='full text-left'>";
echo "<p>This website is made to caiter to the family history needs of the Law and Simmons family and all of their relatives.  If you are one of them, or are interested in knowing more about them, please register for this website! We'd love to keep you up to date on all of the cool new things we find!</p>";
echo "<p>If you would like to contribute to this website, please register and contact Michele Law about the contributions you have to offer! (See the <a href='?controller=index&amp;action=contact'>contact info</a> page for more details)</p>";
echo "<p>If you have any questions, or have found problems in our website or the content found therein, we would love to hear from you! We try very hard to present correct information, but we cannot gaurantee that everything is correct.  Please help us in our indeavor.</p>";
echo "</div>";
echo "</div>";
if (!isset($session))
{
   $session = mySession::getInstance();
}
echo "<p style='color:red; text-align: center;'>".$session->message()."</p>";
$session->resetMessage();

?>

<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Contact Page");
}
</script>