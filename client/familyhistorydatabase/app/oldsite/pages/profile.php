<!DOCTYPE HTML>
<html lang="en-US">
<head>
   <?php // Grab the Session Object FIRST
   include_module('head.php');
   ?>
</head>
<body id="body" onload="load();" onresize="load();" style="background: white;">


   <?php 
   $session = mySession::getInstance();
   if(!$session->isLoggedIn()){ ?>
   <?php include_module('menuempty.php');?>
   <?php } else { ?>
   <!-- is logged in -->
   <?php include_module('menu.php'); ?>
   <?php } ?>

   <div class="offset">

      <?php include_module('top.php');?>


      <!-- This is where all the content will go.  Just edit this Content div to get your content looking nice -->
      <div class="content">
         <?php
         
         if($session->isLoggedIn())
         {
            $user = User::current_user();
            $user = recast('User', $user);
         }
         ?>
         <div id="mainContent">
            <header>
               <div id="header">
                  <div id="logo_wrap">
                     <!-- <a href="/"><img id="logo" src="images/Card-Access-Logo.png" alt="Logo"/></a> -->
                     <div id="login_wrap" class="clearfix">

                        <!-- log in time -->
                        <?php if(!$session->isLoggedIn())
                        { 
                           include_window('login.php'); 
                        }
                        else 
                        {
                           include_module('profile.php'); 
                        }
                        ?>
<!-- 
                        <a class="button2" href="/?controller=user&action=profile">test</a>
                     -->
                     <?php 
                     ?>
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