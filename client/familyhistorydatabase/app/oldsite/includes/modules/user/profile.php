<!-- this is the profile changing form -->
<script src="javascript/form.js"></script>

<div id="edit_profile">
   <h3 style="margin-top: 10px;">Notes:</h3>
   <p style="margin-top:-8px; font-size: 12px !important;">Leave fields blank, or with their default values if you don't want them to change. (there will be no check marks next to the values that will not change)</p>
   <p style="margin-top:-8px; font-size: 12px !important;">Changes are verified when you see the green check mark.</p>
   <p style="margin-top:-8px; font-size: 12px !important;">If the email is changed you will have to reverify it.  There will be an email in your inbox with the link for reverification.</p>
   <p style="margin-top:-8px; font-size: 12px !important;">To reset a password, email <a href="mailto:lawpioneer@gmail.com?subject=Password Change Request!" alt="Mail to Michele Law" title="Email Michele">Michele Law</a>
      <!-- <a href=""><span style="color:red; font-weight: bold;">click here.</span></a> -->
   </p>
   <!-- send it to our index so the URL class can take care of it -->
   <form style="margin-top: 50px;" id='profile_change' action='.' method='post'>      
      <table>
         <?php
         $user = User::current_user();
         $user = recast('User', $user);
         echo "<input type='hidden' id='id' name='id' value='";
         echo $user->id;
         echo "' hidden/>";
         
         // username
         echo "<tr>";
         echo "<th>";
         echo "<label for='username'>";
         echo 'Username';
         echo "</label>";
         echo "</th>";
         echo "<td>";
         echo "<input type='text' id='username_reset' name='username_reset' value='";
         echo $user->username;
         echo "' required />";
         echo "</td>";
         echo "<td id='user_check'>";
         echo "<img style='visibility:hidden;' src='/images/check.png' height='20px;' width = 'auto' style='height: 20px !important' alt='check'/>";
         echo "</td>";
         echo "</tr>";

         // email
         echo "<tr>";
         echo "<th>";
         echo "<label for='email'>";
         echo 'Email';
         echo "</label>";
         echo "</th>";
         echo "<td>";
         echo "<input type='email' id='email_reset' name='email_reset' value='";
         echo $user->email;
         echo "' required />";
         echo "</td>";
         echo "<td id='email_check'>";
         echo "<img style='visibility:hidden;' src='/images/check.png' height='20px;' width = 'auto' style='height: 20px !important' alt='check'/>";
         echo "</td>";
         echo "</tr>";

         // first name
         echo "<tr>";
         echo "<th>";
         echo "<label for='first_name'>";
         echo 'First Name';
         echo "</label>";
         echo "</th>";
         echo "<td>";
         echo "<input type='text' id='first_reset' name='first_reset' value='";
         echo $user->first_name;
         echo "' required/>";
         echo "</td>";
         echo "<td id='first_check'>";
         echo "<img style='visibility:hidden;' src='/images/check.png' height='20px;' width = 'auto' style='height: 20px !important' alt='check'/>";
         echo "</td>";
         echo "</tr>";

         // last name
         echo "<tr>";
         echo "<th>";
         echo "<label for='last_name'>";
         echo 'Last Name';
         echo "</label>";
         echo "</th>";
         echo "<td>";
         echo "<input type='text' id='last_reset' name='last_reset' value='";
         echo $user->last_name;
         echo "' required/>";
         echo "</td>";
         echo "<td id='last_check'>";
         echo "<img style='visibility:hidden;' src='/images/check.png' height='20px;' width = 'auto' style='height: 20px !important' alt='check'/>";
         echo "</td>";
         echo "</tr>";

         // Company Position
         echo "<tr>";
         echo "<th>";
         echo "<label for='company_position'>";
         echo 'Company Position';
         echo "</label>";
         echo "</th>";
         echo "<td>";
         echo "<input type='text' id='company_reset' name='company_reset' value='";
         echo $user->company_position;
         echo "'/>";
         echo "</td>";
         echo "<td id='company_check'>";
         echo "<img style='visibility:hidden;' src='/images/check.png' height='20px;' width = 'auto' style='height: 20px !important' alt='check'/>";
         echo "</td>";
         echo "</tr>";
         ?>
         <tr>
            <td> 
               <!-- and then the submit button -->
               <input type="submit" id="profile_submit" name="submit" class="btn btn-success" value="Make Changes"/>
            </td>
         </tr>
      </table>
   </form>
</div>
<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Profile Page");
});
</script>