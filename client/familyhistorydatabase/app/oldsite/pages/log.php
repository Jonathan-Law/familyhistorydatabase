<?php 
//make sure they're going through our controller!
// require_once("http://test.familyhistorydatabase.org/includes/initialize.php");     // Include all Necissary Files
if (class_exists('mySession'))
{
   $session = mySession::getInstance();            // get the session
}
else
   header("Location: http://test.familyhistorydatabase.org/");

   if ($session->isLoggedIn())
   {
      redirect_home();
   }
?>


<!DOCTYPE HTML>
<html lang="en-US">
<head>
   <?php // Grab the Session Object FIRST ^
   include_module('head.php');
   ?>
   <title>Familyhistorydatabase - Family History Research Website</title>
</head>
<body id="body" onload="load();" onresize="load();" style="background: white;">


   <?php 
   include_module('menu.php'); 
   ?>

   <div class="offset">

      <?php include_module('top.php');?>

      <!-- This is where all the content will go.  Just edit this Content div to get your content looking nice -->
      <div class="content">
         <div id="mainContent">
         <?php
         
         if($session->isLoggedIn())
         {
            $user = User::current_user();
            $user = recast('User', $user);
            
         }
         ?>
            <header>
               <div id="header">
                  <div id="logo_wrap">
                     <!-- <a href="/"><img id="logo" src="images/Card-Access-Logo.png" alt="Logo"/></a> -->
                     <div id="login_wrap" class="clearfix">

                        <!-- log in time -->
                        <?php
                        {
                           if ($session->isLoggedIn())
                           {
                              redirect_home();
                           }
                           else
                           {
                              include_window('login.php'); 
                           }
                        }
                        ?>
<!-- 
                        <a class="button2" href="/?controller=user&action=profile">test</a>
                     -->
                  </div>
               </div>
            </div>
         </header>

      </div>
   </div>

   <?php
   if ($session->isLoggedIn())
   {
      echo '<div id="login">';
      $user = User::current_user();
      $user = recast('User', $user);
      echo "Welcome <a href='/?controller=user&action=profile'>".$user->first_name." ".$user->last_name."</a> | ";
      echo '   <a class="button2" href="/?controller=user&action=logout">Log Out</a>';
      echo '</div>';
   }
   else
   {
      echo '<div id="login">';
      echo "<a href='/?controller=index&action=log'>Login for more access</a>";
      echo '</div>';
   }
   ?>
<!--    <div id="caLogo" style="position: absolute; width:227px; left: 50%; margin-left: -114px; bottom: 50px; z-index: 6;">
      <img src="http://alawfamily.com/images/Card-Access-Logo.png" title="" alt="" />
   </div> -->
   <?php include_module('bottom.php');?>

</div>

<!-- This is where the individual menu bars on the right will go that deal with the individual's stuff. -->
<div id="profile" class="profileBorder">
   <div class="scrolling">
      <?php include_module('side.php'); ?>
      <!-- This will be the profile bar -->
   </div>
</div>

</body>
</html>