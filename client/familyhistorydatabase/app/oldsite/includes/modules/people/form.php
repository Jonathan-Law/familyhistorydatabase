<div class='text-left'>
   <script src="javascript/form.js"></script>
   <script src="javascript/countries.js"></script>
   <script src="javascript/admin.js"></script>

   <form style="width: 100%; margin-top: 10px;" method="post" action="." id="individual_form" onreset="resetForm();">
      <input type="reset" class='btn btn-warning'>

      <input list="addition_names" type="text" name="individual" id="individual" class="name_size" value="New Individual" onClick="this.value='' ";>
      <input type='hidden' name='update' id='update'>
      <input type="hidden" list="addition_names" class="name" id="addition" name="addition">
      <datalist id="addition_names" name="addition_names">
      </datalist>
      <input type="hidden" list="town" class="place" id="temp_place_town" name="temp_place_town">
      <datalist id="town" name="town">
      </datalist>
      <input type="hidden" list="county" class="place" id="temp_place_county" name="temp_place_county">
      <datalist id="county" name="county">
      </datalist>
      <input type="hidden" list="state" class="place" id="temp_place_state" name="temp_place_state">
      <datalist id="state" name="state">
      </datalist>
      <input type="hidden" list="country" class="country" id="temp_place_country" name="temp_place_country">
      <datalist id="country" name="country">
      </datalist>
      <input type="hidden" list="cemetary" class="place" id="temp_place_cemetary" name="temp_place_cemetary">
      <datalist id="cemetary" name="cemetary">
      </datalist>
      <input type="button" class='btn btn-warning' value="Reload (grab new name list)" onClick="document.location.reload(true)">
      <br/>
      <br/>
      <input type="button" class='btn btn-danger' value="Delete Individual" id="deleteIndividual">
      <br/>
      <br/>
      <table>
         <tr>
            <td>
               <input type="text" list="first_name" placeholder="First Name" id='fninput' name='fninput' >
               <datalist id="first_name" value="" name="first_name">
               </datalist>
            </td>
            <td>
               <input type="text" list="middle_name" placeholder="Middle Name" id='mninput' name='mninput' >
               <datalist id="middle_name" value="" name="middle_name">
               </datalist>
            </td>
            <td>
               <input type="text" list="last_name" placeholder="Last Name" id='lninput' name='lninput' >
               <datalist id="last_name" value="" name="last_name">
               </datalist>
            </td>
         </tr>
      </table>
      <table>
         <tr>
            <td><input type="radio" name="sex" id="male" value="male">&nbsp;male&nbsp;&nbsp;</td>
            <td><input type="radio" name="sex" id="female" value="female">&nbsp;female&nbsp;&nbsp;</td>
            <td><input type="text" placeholder="Relationship to Michele Law" name="relationship_to_michele" id="relationship_to_michele"/></td>
            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <hr/>
      <table>
         <tr><td><span>Birth Date: </span></td></tr>
         <tr>
            <td><label for="birth_date">Date : </label><input class="txtDate" id="birth_date" name="birth_date" type="text" value="" placeholder="dd/mm/yyyy"/></td>
            <td style='position: relative; top: 10px !important;'><input type="checkbox" name="birth_date_overide" id="birth_date_overide" value="true">&nbsp;Approximate?(checked = yes)<br></td>
            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <table>
         <tr>
            <td><input list='town' type="text" value=""  placeholder="Birth Place Town" id='bp_town' name='bp_town'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='county' type="text" value=""  placeholder="Birth Place County" id='bp_county' name='bp_county'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='state' type="text" value=""  placeholder="Birth Place State" id='bp_state' name='bp_state'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='country' type="text" value="" class="country" placeholder="Birth Place Country" id='bp_country' name='bp_country'/></td>

            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <hr/>
      <table>
         <tr><td><span>Death Date: </span></td></tr>
         <tr>
            <td><label for="death_date">Date : </label><input class="txtDate" id="death_date" name="death_date" type="text" value="" placeholder="dd/mm/yyyy"/></td>
            <td style='position: relative; top: 10px !important;'><input type="checkbox" name="death_date_overide" id="death_date_overide" value="true">&nbsp;Approximate?(checked = yes)<br></td>
            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <table>
         <tr>
            <td><input list='town' type="text" value=""  placeholder="Death Place Town" id='dp_town' name='dp_town'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='county' type="text" value=""  placeholder="Death Place County" id='dp_county' name='dp_county'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='state' type="text" value=""  placeholder="Death Place State" id='dp_state' name='dp_state'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='country' type="text" value="" class="country" placeholder="Death Place Country" id='dp_country' name='dp_country'/></td>

            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <hr/>
      <table>
         <tr><td><span>Burial Date: </span></td></tr>
         <tr>
            <td><label for="burial_date"> Date : </label><input class="txtDate" id="burial_date" name="burial_date" type="text" value="" placeholder="dd/mm/yyyy"/></td>
            <td style='position: relative; top: 10px !important;'><input type="checkbox" name="burial_date_overide" id="burial_date_overide" value="true">&nbsp;Approximate?(checked = yes)<br></td>
            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <table>
         <tr>
            <td><input list='cemetary' type="text" value="" placeholder="Burial Cemetary" id='bup_cemetary' name='bup_cemetary'/></td>
         </tr>
      </table>
      <table>
         <tr>
            <td class="hidden"><span>Error::</span></td>
            <td><input list='town' type="text" value=""  placeholder="Burial Place Town" id='bup_town' name='bup_town'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='county' type="text" value=""  placeholder="Burial Place County" id='bup_county' name='bup_county'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='state' type="text" value=""  placeholder="Burial Place State" id='bup_state' name='bup_state'/></td>

            <td class="hidden"><span>Error::</span></td>
            <td><input list='country' type="text" value="" class="country" placeholder="Burial Place Country" id='bup_country' name='bup_country'/></td>

            <td class="hidden"><span>Error::</span></td>
         </tr>
      </table>
      <input style="font-size: 18px;" type="submit" class='btn btn-success' value='Make Changes/Add Individual'>
      <hr/>
      <table id="parent_table">
         <input type="button" class='btn btn-info' id="addparent" name="addparent" value="Add a Parent">
      </table>
      <input type="button" class='btn btn-info' id="saveparent" name="saveparent" value="Save Parent Data">
      <hr/>

      <table id="spouse_table">
         <input type="button" class='btn btn-info' id="addspouse" name="addspouse" value="Add a Spouse">
      </table>
      <input type="button" class='btn btn-info' id="savespouse" name="savespouse" value="Save Spouse Data">
      <input type="hidden" name='action' id='action' value='makeChanges'>
      <input type="hidden" name='formtype' id='individual' value='individual'>
      <input type="hidden" name='controller' id='controller' value='admin'>
   </form>
   <!-- <div id='form_completion'></div> -->
</div>

<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Insert People Page");
});
</script>