<?php
$session = mySession::getInstance();

// exit;
if ($session->isLoggedIn())
{
   echo "<script src=\"javascript/onload.js\"></script>";
   echo "<script src=\"includes/dropzone-master/downloads/dropzone.js\"></script>";
   echo "<link rel=\"stylesheet\" type='text/css' href=\"/includes/dropzone-master/downloads/css/dropzone.css\"/>";
   echo "<div id=\"dropzone\" style='margin-top: 10px !important'>";
   // /?controler=upload"
   echo "<div id=\"uploadDrop\" class=\"uploadDrop clickable\" action=\"\">"; 
   echo "<input type=\"hidden\" list=\"people\" class=\"people\" id=\"addition\" name=\"addition\">";
   echo "<datalist id=\"people\" name=\"people\">";
   echo "</datalist>";
   echo "<input type=\"hidden\" list=\"uploadPlace\" class=\"uploadPlace\" id=\"places\" name=\"places\">";
   echo "<datalist id=\"uploadPlace\" name=\"uploadPlace\">";
   echo "</datalist>";
   echo "<div class=\"default message\"><span>Drop files here to upload</span>";
   echo "</div>";
   echo "<input class=\"save btn btn-success\" style=\"position: absolute; bottom: 5px; left: 5px; z-index: 5000;\" type='button' id='clickme' name='clickme' value='Save Uploads'>";
   echo "</div>";
   echo "</div>";
}
?>
<script type="text/javascript">
$(document).ready(function()
{
   $("#page_name").html("Upload Page");
});
</script>