<!-- This is for when people ARE logged in -->
<!-- <div id="menu" class="menuBorder">
// <?php
// if (!isset($session))
// {
// $session = mySession::getInstance();
   
// }
// if (!$session->isLoggedIn())
// {
//    echo "<span class=\"splitter\"></span>";
//    echo "<div class=\"menuBar\"><a href=\"/?controller=index&action=log\" title=\"Login or Sign Up for more access to this site's content\"><div class=\"text\"><span>Login/signup</span></div></a></div>";
// }
?>
<span class="splitter"></span>
<div class="menuBar"><a href="/"><div class="text"><span>Home</span></div></a></div>
<span class="splitter"></span>
<div class="menuBar"><a href="/?controller=index&amp;action=people"><div class="text"><span>People</span></div></a></div>
<span class="splitter"></span>
<div class="menuBar"><a href="/?controller=index&amp;action=place"><div class="text"><span>Places</span></div></a></div>
<span class="splitter"></span>
<div class="menuBar"><a href="/?controller=index&amp;action=cemetary"><div class="text"><span>Cemeteries
      </span></div></a></div>
<span class="splitter"></span>
<div class="menuBar"><a href="/?controller=index&amp;action=mayflower"><div class="text"><span>Mayflower</span></div></a></div>
<span class="splitter"></span>
<div class="menuBar"><a href="/?controller=index&amp;action=contact"><div class="text"><span>Contact Info</span></div></a></div>
<span class="splitter"></span>
<?php 

// echo "<img style='position: absolute; bottom: 0px; left: 0px; z-index -1000; width: inherit; min-width: 100%; height: auto;' src='http://familyhistorydatabase.org/public/images/Gma_Law_2.jpg' alt='Ernest' title'Ernest Albert Law Family'>";
// echo "<p></p>";

?>
</div> -->

<div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
      <div class='text-right pull-right hide-on-small' id='login' style='width: 360px; margin-top: 2px; padding-right: 10px;'>
         <form class="navbar-search pull-left hide-on-small" id="site-search" method="get" action="/" style=" margin-top: 5px; ">
            <input type="hidden" name="controller" value="search">
            <input type="hidden" name="action" value="main-search">
            <input type="text" class="search-query" style="line-height: 20px; width: 180px; height: 20px;" placeholder="Search" name="search" id="search-query">
         </form>
         <?php
         if (!isset($session))
         {
            $session = mySession::getInstance();
         }
         if ($session->isLoggedIn())
         {
            echo '<div id="login">';
            $user = User::current_user();
            $user = recast('User', $user);
            //echo "<span style='position: relative; top: 3px;'>Welcome <a href='/?controller=user&action=profile'>".$user->first_name." ".$user->last_name."</a> | </span>";
            echo '   <button class="btn" id="logMeOut">Log Out</button>';
            echo '</div>';
         }
         else
         {
            echo "<a href=\"#logmein\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Login</a>";
            echo "<a href=\"#register\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Register</a>";
         }
         ?>
      </div>
      <!-- ========================================================== Modals ========================================================== -->
      <div id="logmein" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Login</h3>
         </div>
         <div class="modal-body">
            <!--  Usefull sign in form================================================================= -->
            <form class="navbar-form inline_reset text-center">
               <table class="inline">
                  <tr>
                     <td>
                        <input id="login-email" name="login-email" class="span2" style="width: 200px !important;" type="text" placeholder="Email or Username">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <input id="login-password" name="login-password" class="span2" style="width: 200px !important;" type="password" placeholder="Password">
                     </td>
                  </tr>
               </table>
            </form>
         </div>
         <div class="modal-footer" style='text-align: center'>
            <button class="btn" aria-hidden="true" onclick='submitLogin();'>Login</button>
            <button class="btn btn-primary" id="login-register">Register</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
         </div>
      </div>

      <div id="register" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Register</h3>
         </div>
         <div class="modal-body text-center">
            <!--  Usefull sign in form
            ================================================================= -->
            <form class="navbar-form inline_reset text-center">
               <table class='inline'>
                  <tr>
                     <td class='text-right'>
                        <label for="register-first-name">First Name:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-first-name' style="width: 200px !important;" name='register-first-name' type="text" placeholder="First Name">
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-last-name">Last Name:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-last-name' style="width: 200px !important;" name='register-last-name' type="text" placeholder="Last Name">
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-username">Username:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-username' style="width: 200px !important;" name='register-username' type="text" placeholder="Username">
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-email">Email:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-email' style="width: 200px !important;" name='register-email' type="email" placeholder="Email">
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-gender">Email:</label>
                     </td>
                     <td style="text-align: left !important">
                        <input id='register-gender' name='register-gender' type="radio" value="anonymous" checked="checked" style="vertical-align: middle; margin-top: -4px;" >anonymous<br/>
                        <input name='register-gender' type="radio" value="male" style="vertical-align: middle; margin-top: -4px;" >male<br/>
                        <input name='register-gender' type="radio" value="female" style="vertical-align: middle; margin-top: -4px;" >female
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-password">Password:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-password' style="width: 200px !important;" name='register-password' type="password" placeholder="Password">
                     </td>
                  </tr>
                  <tr>
                     <td class='text-right'>
                        <label for="register-password2">Repeat Password:</label>
                     </td>
                     <td>
                        <input class="span2" id='register-password2' style="width: 200px !important;" name='register-password2' type="password" placeholder="Repeat Password">
                     </td>
                  </tr>
               </table>
            </form>
         </div>
         <div class="modal-footer" style='text-align: center'>
            <button class="btn"jonl aria-hidden="true" onclick='submitRegister();'>Register</button>
            <button class="btn btn-primary" id="register-login">Login</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
         </div>
      </div>
      <div class="container-fluid">
         <a data-target="#menu" data-toggle="collapse" class="btn btn-navbar" style="color: black; width: 65px; margin-top: -1px; margin-bottom: -1px;"><span class="pull-right" style="font-size: 16px; margin-top: -2px;">MENU</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
         <!-- <a data-target="#admin" data-toggle="collapse" class="btn btn-navbar" style="color: black; width: 65px; margin-top: -1px; margin-bottom: -1px;"><span class="pull-right" style="font-size: 16px; margin-top: -2px;">ADMIN</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> -->
         <div style='width: 300px; position: absolute; top: -8px; height: 41px; line-height: 20px; left: 50%; margin-left: -135px;' class='text-center titleBar'><a href="/" class="brand show-on-small" style="padding-bottom:0px !important"><img class='titleBar'src="images/title.png" alt="FamilyHistoryDatabse" style="width: 250px; height: 41px;"/></a></div>
         <div class="nav-collapse collapse navbar-responsive-collapse " id="menu">
            <ul class="nav inline_reset" id="mainMenu" style="width: 240px; margin-left: -20px !important;">
               <!--                    
               <li class="active">
               <a href="#">Home</a>
               </li>
               <li>
                  <a href="#">Link</a>
               </li>
               <li>
                  <a href="#">Link</a>
               </li> -->
               <li class="hide-on-small">
                  <a href="/" class="popover_profile" data-placement="bottom" alt="Click here to return to the home page">Home</a>
               </li>
               <li class="hide-on-small">
                  <a href="/?controller=index&amp;action=people" class="popover_profile" data-placement="bottom" alt="Click here to find the individual you're looking for">People</a>
               </li>
               <li class="dropdown text-left hide-on-small">
                  <a data-toggle="dropdown" id="menu_button" class="dropdown-toggle popover_profile" data-placement="bottom" alt="Click here to view other menu options" href="#">Other<span>&nbsp;</span><i class="icon-th-list"></i></a>
                  <ul class="dropdown-menu hide-on-small">
                     <li>
                        <a href="#" class="popover_profile" data-placement="right" alt="Click here to view Places information">Places</a>
                        <!-- <a href="/?controller=index&amp;action=place">Places</a> -->
                     </li>
                     <li>
                        <a href="#" class="popover_profile" data-placement="right" alt="Click here to view the Cemeteries page">Cemeteries</a>
                        <!-- <a href="/?controller=index&amp;action=cemetary">Cemeteries</a> -->
                     </li>
                     <li>
                        <a href="#" class="popover_profile" data-placement="right" alt="Click here to view the Mayflower page">Mayflower</a>
                        <!-- <a href="/?controller=index&amp;action=mayflower">Mayflower</a> -->
                     </li>
                     <li class="dropdown-submenu">
                        <a tabindex="-1" href="/?controller=index&amp;action=about" class="popover_profile" data-placement="bottom" alt="Click here to go to the about section for this website">About</a>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="/?controller=index&amp;action=contact" class="popover_profile" data-placement="right" alt="Click here to view contact information">Contact Info</a>
                           </li>
                           <li>
                              <a tabindex="-1" href="/?controller=index&amp;action=about" class="popover_profile" data-placement="right" alt="Click here to view information about this website">More info</a>
                           </li>
                        </ul>
                     </li>
                     <li>
                        <a href="/?controller=search&amp;action=showMainSearch" class="popover_profile" data-placement="right" alt="Click here to go to the Search Page">Search</a>
                        <!-- <a href="/?controller=index&amp;action=contact">Contact Info</a> -->
                     </li>
                     <?php
                     if ($session->isLoggedIn())
                     {

                        echo "<li>";
                        echo "   <a href='/?controller=user&amp;action=profile' class=\"popover_profile\" data-placement=\"right\" alt=\"Click here to edit profile information\">".$user->first_name." ".$user->last_name."</a>";
                        echo "   <!-- <a href=\"/?controller=index&amp;action=contact\">Contact Info</a> -->";
                        echo "</li>";
                     }
                     ?>
                     <!--
                     <li class="divider">
                     </li>
                     <li class="nav-header">
                        Nav header
                     </li> 
                  -->
                     <!--
                     <li>
                        <a href="#">Separated link</a>
                     </li>
                     <li>
                        <a href="#">One more separated link</a>
                     </li>
                     <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">More options</a>
                        <ul class="dropdown-menu">
                           <li><a tabindex="-1" href="#">Second level link</a></li>
                           <li><a tabindex="-1" href="#">Second level link</a></li>
                           <li><a tabindex="-1" href="#">Second level link</a></li>
                           <li><a tabindex="-1" href="#">Second level link</a></li>
                           <li><a tabindex="-1" href="#">Second level link</a></li>
                        </ul>
                     </li>
                  -->
               </ul>
               <li class="show-on-small ">
                  <a href="/?controller=index&amp;action=home">Home</a>
               </li>
               <li class="show-on-small ">
                  <a href="/?controller=index&amp;action=people">People</a>
               </li>
               <li class="show-on-small ">
                  <a href="#">Places</a>
                  <!-- <a href="/?controller=index&amp;action=place">Places</a> -->
               </li>
               <li class="show-on-small ">
                  <a href="#">Cemeteries
                  </a>
                  <!-- <a href="/?controller=index&amp;action=cemetary">Cemeteries
               </a> -->
            </li>
            <li class="show-on-small ">
               <a href="#">Mayflower</a>
               <!-- <a href="/?controller=index&amp;action=mayflower">Mayflower</a> -->
            </li>
            <li class="show-on-small ">
               <a href="/?controller=index&amp;action=contact">Contact Info</a>
               <!-- <a href="/?controller=index&amp;action=contact">Contact Info</a> -->
            </li>
            <li class="show-on-small ">
               <a href="/?controller=index&amp;action=about">More info</a>
               <!-- <a href="/?controller=index&amp;action=contact">Contact Info</a> -->
            </li>
            <li class="show-on-small ">
               <a href="/?controller=search&amp;action=showMainSearch">Search</a>
               <!-- <a href="/?controller=index&amp;action=contact">Contact Info</a> -->
            </li>
            <li class="show-on-small ">
               <?php
               if (!isset($session))
               {
                  $session = mySession::getInstance();
               }
               if ($session->isLoggedIn())
               {
                  echo "<a href='/?controller=user&action=profile'>".$user->first_name." ".$user->last_name."</a>";
                  echo '</li><li class="show-on-small ">';
                  echo '<a href="javascript:void(0);" onclick="logout();">Log Out</a>';
               }
               else
               {
                  echo "<a href=\"#logmein\" data-toggle=\"modal\">Login/Register</a>";
               }
               ?>


            </li>
         </li>
      </ul>
   </div>
   <?php
   if (!isset($session))
   {
      $session = mySession::getInstance();
   }
   if ($session->isLoggedIn())
   {

      $user = User::current_user();
      $user = recast('User', $user);
      if ($user->rights == "admin" || $user->rights == "super")
      {
         echo "<div class=\"nav-collapse collapse navbar-responsive-collapse \" id=\"admin\">";
         echo "   <ul class=\"nav\" id=\"adminMenu\">";
         echo "      <li class=\"dropdown inline text-left\" >";
         echo "         <a data-toggle=\"dropdown\" id=\"admin_button\" class=\"dropdown-toggle hide-on-small\" href=\"#\">ADMIN<span>&nbsp;</span><i class=\"icon-th-list\"></i></a>";
         echo "         <ul class=\"dropdown-menu hide-on-small\">";
         echo "            <li>";
         echo "               <a href='/?controller=admin'><span>Admin Home</span></a>";
         echo "            </li>";
         echo "            <li class=\"dropdown-submenu\">";
         echo "               <a tabindex=\"-1\" href='/?controller=admin&action=individuals'>Data</a>";
         echo "               <ul class=\"dropdown-menu\">";
         echo "                  <li>";
         echo "                     <a tabindex=\"-1\" href='/?controller=admin&action=individuals'><span>Add or Update Family Info</span></a>";
         echo "                  </li>";
         echo "                  <li class='has-sub'>";
         echo "                     <a tabindex=\"-1\" href='/?controller=admin&action=upload'><span>Upload Files</span></a>";
         echo "                  </li>";
         echo "                  <li class='has-sub'>";
         echo "                     <a tabindex=\"-1\" href='/?controller=admin&action=editFiles'><span>Edit Files</span></a>";
         echo "                  </li>";
         echo "               </ul>";
         echo "            </li>";
         echo "            <li class=\"dropdown-submenu\">";
         echo "               <a tabindex=\"-1\" href=\"/?controller=admin&action=users\">Users</a>";
         echo "               <ul class=\"dropdown-menu\">";
         echo "                  <li>";
         echo "                     <a  tabindex=\"-1\" href='/?controller=admin&action=users'><span>Add or Update Users</span></a>";
         echo "                  </li>";
         echo "               </ul>";
         echo "            </li>";
            // echo "            <li><a href='#'><span>Contact</span></a></li>";
         echo "         </ul>";
         echo "      </li>";
         echo "   </ul>";
         echo "</div>";
      }
   }
   ?>
   <div style='width: 300px; position: absolute; top: -8px; height: 41px; line-height: 20px; left: 50%; margin-left: -135px;' class='text-center scoot'><a href="/" class="brand hide-on-small" style="padding-bottom:0px !important"><img src="images/title.png" alt="FamilyHistoryDatabase" style="width: 250px; height: 41px;"/></a></div>

</div>

</div>
</div>