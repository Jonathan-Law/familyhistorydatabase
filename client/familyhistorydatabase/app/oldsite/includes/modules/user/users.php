<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
if ($session->isLoggedIn())
{
   $user = User::current_user();
   $user = recast("User", $user);
   // echo "<pre>";
   // print_r($user);
   // //echo this;
   // echo "</pre>";
   if (!($user->rights == "admin" || $user->rights == "super"))
   {
      redirect_home();
   }
   else
   {
      $flag = true;
   }
}
else
{
   redirect_home();
}

if ($flag)
{
   $all_users = User::getAllUsers();
   if (!empty($all_users))
   {
      echo "<div class='inline_reset'>";
      echo "<h1 class='inline'>";
      echo "Current Users:";
      echo "</h1>";
      echo "</div>";
      echo "<hr/>";
      echo "<table class=\"table table-hover table-condensed\">";
      foreach ($all_users as $aUser)
      {
         echo "<tr>";
         $count = -1;
         foreach ($aUser as $key => $value) 
         {
            if ($count % 2 == 0 && $count != 0 && $count > 0)
            {
               echo "</tr>";
               echo "<tr>";
               echo "<td></td>";
               echo "<td></td>";
               $count = 0;
            }
            echo "<td><label for='".$key."_".$value."'' style='font-weight: bold;'>".$key.":</label></td>";
            echo "<td id='".$key."_".$value."'>".$value."</td>";
            # code...
            $count++;
         }
         echo "</tr>";
         echo "<tr>";
         echo "<td>&nbsp;</td>";
         echo "<td>&nbsp;</td>";
         echo "<td>&nbsp;</td>";
         echo "<td>&nbsp;</td>";
         echo "<td>&nbsp;</td>";
         echo "<td>&nbsp;</td>";
         echo "</tr>";
      }
      echo "</table>";
   }
}
?>

<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Users Page");
});
</script>