<?php
//make sure they're going through our phpController!
// require_once("http://test.familyhistorydatabase.org/includes/initialize.php");     // Include all Necissary Files
if (class_exists('mySession'))
{
   if (!isset($session))
   {
      $session = mySession::getInstance();            // get the session
   }
}

else
   header("Location: http://test.familyhistorydatabase.org/");
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
   <title>FamilyHistoryDatabase.org</title>
   <meta name="description" content="A Family history database website dedicated to accurate representation of deceased people related to Marvin and Michele Law and their relatives. This website contains stories, pictures, personal biographies, poetry and other interesting documents created by or concerning these loved deceased family members. Contributions to this website are welcomed, and Michele Law is constantly striving to improve the quality of the information offered by this constant work in progress." />
   <meta name="keywords" content="Law, Simmons, Hillman, Andrus" />
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
            <?php
            $content = $session->getVar("content");
            $phpController = getRequest("controller");
            $id = getRequest("id");
            if ($phpController == "individual" && !empty($id))
            {
               include_module("people/individual/ind_profile.php");
            }
            else
            {
               echo "<div id='left_img_div' class=\"fullSpan2 pull-left sizeme hide-on-smallest fixedLeft  inline_reset\">";
               echo "</div>";
            }
            ?>
            <?php echo "<!--We made it...-->"; ?>

            <!-- This is the right side panel -->
            <!-- fullSpan2 is the side panel holder, pull makes it float to a side, and sizeme is used in the onload js to resize its height -->
            <!-- hide-on-* makes it hide depending on size of width, fixed makes it not move when middle scrolls -->
            <?php
            if ($phpController == "individual" && !empty($id))
            {
               include_module("people/individual/ind_profile_right.php");
            }
            else
            {
               echo "<div id='right_img_div' class=\"fullSpan2 pull-right sizeme hide-on-small fixedRight inline_reset\">";
               echo "</div>";
            }
            ?>

            <!-- this is the middel. -->
            <!-- fullSpan8 is the full width css for the middle sizeme is used in the onload js to resize the height -->
            <div class="fullSpan8 sizeme">

               <!-- mainContent is used as a scrollable div with css that fills the background and creates shadows -->
               <!-- sizeme is used for min-height, so the shadow doesn't look wierd. -->
               <div class='mainContent sizeme'>
                  <!-- This is the main content RIGHT HERE!!!  It comes from an included module. -->
                  <!--[if IE]>
                  <h1 class="alert alert-error text-center">Internet Explorer isn't compatible with this website.<br/>We suggest you try <a href="https://www.mozilla.org/en-US/firefox/new/?icn=tabz" alt="" title="Firefox Download Link">Firefox</a> or <a href="https://www.google.com/intl/en/chrome/browser/?&brand=CHMB&utm_campaign=en&utm_source=en-ha-na-us-sk&utm_medium=ha" alt="" title="Google Chrome Download Link">Google Chrome</a>!</h1>
                  <![endif]-->
                  <!-- This is the optional admin menu... -->
                  <?php

                  if($session->isLoggedIn())
                  {
                     $user = User::current_user();
                     $user = recast('User', $user);
                  }

                  ?>

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
                  if ($content != NULL)
                  {
                     include_module($content);
                  }
                  else
                  {
                     include_module('home.php');
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
            <a href="#" class="brand strong-text-center hide-on-small text-center" style='width: 300px; position: absolute; bottom: 0px; left: 50%; margin-left: -175px; color:#663;' id="page_name">Home Page</a>
         </div>
      </div>
   </div>

   <!-- besides jQuery, the rest of the scripts should be put here. -->
   <!-- jQuery is used for the letter generation and therefore must be present before it is created -->
   <?php include_module("footer.php")?>

</body>
</html>
