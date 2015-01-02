<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
else
   header("Location: http://familyhistorydatabase.org/");
if (class_exists('Url'))
{
   if (Url::full() == Url::base()."pages/home.php")// send them home if this is true.
   redirect_home();
}
$person = Person::getById($session->getVar('indvidual_id'));
?>

<?php 
//make sure they're going through our controller!
// require_once("http://familyhistorydatabase.org/includes/initialize.php");     // Include all Necissary Files
if (class_exists('mySession'))
{
   $session = mySession::getInstance();            // get the session
}
else
   header("Location: http://familyhistorydatabase.org/");
if (class_exists('Url'))
{
   if (Url::full() == Url::base()."pages/home.php")// send them home if this is true.
   redirect_home();
}
?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Document</title>
   <?php include_module("head.php"); ?>

</head>
<body>
   <!-- fluid row holding everything :) -->
   <div class="row-fluid">
      <!-- include the menu -->
      <?php include_module("menu.php"); ?>
      <!-- between is the stuff between the header and the footer. -->
      <div class="between">

         <!-- fluid row holding everything :) -->
         <div class="row-fluid">

            <!-- This is the left side panel -->
            <!-- fullSpan2 is the side panel holder, pull makes it float to a side, and sizeme is used in the onload js to resize its height -->
            <!-- hide-on-* makes it hide depending on size of width, fixed makes it not move when middle scrolls -->
            <div class="fullSpan2 pull-left sizeme hide-on-smallest fixedLeft ">
               <div class='sidebar'>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
               </div>
            </div>

            <!-- This is the right side panel -->
            <!-- fullSpan2 is the side panel holder, pull makes it float to a side, and sizeme is used in the onload js to resize its height -->
            <!-- hide-on-* makes it hide depending on size of width, fixed makes it not move when middle scrolls -->
            <div class="fullSpan2 pull-right sizeme hide-on-small fixedRight ">
               <div class='sidebar'>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
               </div>
            </div>

            <!-- this is the middel. -->
            <!-- fullSpan8 is the full width css for the middle sizeme is used in the onload js to resize the height -->
            <div class="fullSpan8 sizeme">

               <!-- mainContent is used as a scrollable div with css that fills the background and creates shadows -->
               <!-- sizeme is used for min-height, so the shadow doesn't look wierd. -->
               <div class='mainContent sizeme'>
                  <!-- This is the optional admin menu... -->
                  <?php

                  if($session->isLoggedIn())
                  {
                     $user = User::current_user();
                     $user = recast('User', $user);
                  }
                  ?>

                  <!-- This is the main content RIGHT HERE!!!  It comes from an included module. -->
                  <?php
                  // if ($session->isLoggedIn())
                  // {
                  //    $user = User::current_user();
                  //    $user = recast('User', $user);
                  //    if ($user->id == 3 || $user->id == 2)
                  //    {
                  //       echo "<div class='textcenter'>";
                  //       echo "<a href='http://static.fjcdn.com/pictures/You+re+Awesome...+..because+you+come+to+FunnyJunk.+High-Fives+all+around_944fd6_3414580.jpg'><h1 class='btn btn-success'>Internet High Five!!!!</h1></a>";
                  //       echo "</div>";
                  //    }
                  // }
                  $content = $session->getVar("content");
                  if ($content != NULL)
                  {
                     include_module($content);
                  }
                  else
                  {
                     include_module('people/individual/individual.php'); 
                  }
                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- footer: Needs to be changed per page because it shows current location. -->
   <div class="navbar navbar-fixed-bottom hide-on-small" id="footer">
      <div class="navbar-inner hide-on-small">
         <div class='container-fluid hide-on-small'>
            <a href="#" class="brand strong-text-center hide-on-small" style='color: #888888; font-size: 10px;'>Website designed by Jonathan Law</a>
            <a href="#" class="brand strong-text-center hide-on-small" style='width: 300px; position: absolute; bottom: 0px; left: 50%; margin-left: -150px; color:#663;'>Home Page</a>
         </div>
      </div>
   </div>

   <!-- besides jQuery, the rest of the scripts should be put here. -->
   <!-- jQuery is used for the letter generation and therefore must be present before it is created -->
   <?php include_module("footer.php")?>

</body>
</html>


<!-- <!DOCTYPE HTML>
<html lang="en-US">
<head>
   <?php // Grab the Session Object FIRST ^
   // include_module('head.php');
   ?>
   <title>Familyhistorydatabase - Family History Research Website</title>
</head>
<body id="body" onload="load();" onresize="load();" style="background: white;">


   <?php 
   // include_module('menu.php'); 
   ?>

   <div class="offset">

      <?php
       // include_module('top.php');
       ?>

      <div class="content">
         <div id="mainContent">
         <?php
         
         // if($session->isLoggedIn())
         // {
         //    $user = User::current_user();
         //    $user = recast('User', $user);
            
         // }
         ?>
            <header>
               <div id="header">
                  <div id="logo_wrap">
                     <div id="login_wrap" class="clearfix">

                        <?php
                        // {
                        //    include_module('individual.php'); 
                        // }
                        ?>
                  </div>
               </div>
            </div>
         </header>

      </div>
   </div>

   <?php
   // if ($session->isLoggedIn())
   // {
   //    echo '<div id="login">';
   //    $user = User::current_user();
   //    $user = recast('User', $user);
   //    echo "Welcome <a href='/?controller=user&action=profile'>".$user->first_name." ".$user->last_name."</a> | ";
   //    echo '   <a class="button2" href="/?controller=user&action=logout">Log Out</a>';
   //    echo '</div>';
   // }
   // else
   // {
   //    echo '<div id="login">';
   //    echo "<a href='/?controller=index&action=log'>Login for more access</a>";
   //    echo '</div>';
   // }
   ?>
      <img src="http://alawfamily.com/images/Card-Access-Logo.png" title="" alt="" />
   <?php
    // include_module('bottom.php');
    ?>

</div>

<div id="profile" class="profileBorder">
   <div class="scrolling">
      <?php
       // include_module('ind_profile.php');
        ?>
   </div>
</div>

</body>
</html>
 -->