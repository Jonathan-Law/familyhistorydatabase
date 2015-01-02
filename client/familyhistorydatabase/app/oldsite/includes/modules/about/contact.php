<?php 
echo "<div class='hero-unit text-center' style='margin-top: 10px'>";
echo "<h1>Contact Info</h1>";
echo "<hr/>";
echo "<div class='full text-left'>";
echo "<div style=\"width:190px; float: left; margin-right: -190px;\">";
echo "<img src=\"images/michelesimmons.jpg\" alt=\"Michele Law\">";
echo "</div>";
echo "<div class='full right textleft'>";
echo "<div style=\"margin-left: 200px; padding: 0 30px 0 0; font-size: 18px;\">";
echo "<strong style=\"font-size: 22px;\">This website is maintained by me, I'm Michele Simmons Law.<br/> You may contact me at lawpioneer@gmail.com.</strong>";
echo "<p>I always collect information about my family members. If you have information or photos you want to share please feel free to share them with me and I may add them to the website. I always try to put the name of the person who provided the information next to their articles, but occasionally that is not possible because the source has not been passed on to me. </p>";
echo "<p>Copyrights are important to me. If you see anything in this website that is copyrighted, please let me know so I can get permission to print. </p>";
echo "<p>I also try very hard not to put up pictures of people who are still alive. </p>";
echo "</div>";
echo "</div>";
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