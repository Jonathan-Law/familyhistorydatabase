<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
// [controller] => individual
// [action] => photo_album
// [id] => 663
$person = Person::getById($session->getVar('indvidual_id'));
// echo "<pre>";
// print_r($person);
// //echo this;
// echo "</pre>";
// exit;
?>
<div class="photo_body">
   <div class='greenlink little text-center' style='margin-top:10px; margin-bottom: -10px'>
      <a href="/?controller=individual&amp;action=homepage&amp;id=<?php echo $session->getVar('indvidual_id');?>">Back to "<?php
      echo $person->firstName." ";
      if ($person->middleName)
      {
         echo $person->middleName." ";
      }
      echo $person->lastName;
      ?>"</a> ||
      <a href="/?controller=index&amp;action=people&amp;last_name=<?php echo $session->getVar('lastname');?>">Back to "<?php echo ucfirst($session->getVar('lastname'));?>"</a> ||
      <a href="/?controller=index&amp;action=people&amp;letter=<?php echo $session->getVar('letter');?>">Back to "<?php echo ucfirst($session->getVar('letter'));?>"</a> ||
      <a href="/?controller=index&amp;action=people">Back to the alphabet</a>
   </div>
   <div id="header">
      <div class="page">
         <div id="header-text">
            <h1>Photo Gallery For
               <?php
               echo $person->firstName." ";
               if ($person->middleName)
               {
                  echo $person->middleName." ";
               }
               echo $person->lastName;
               ?>
            </h1>
         </div>
      </div>
   </div>
   <div id="container">
      <!-- Start Advanced Gallery Html Containers -->
      <div class="navigation-container">
         <div id="thumbs" class="navigation inline_reset" style="opacity: 1;">
            <div class="da-thumbs-container inline" style="padding: 0px !important; width: 90% !important;">
               <a class="pageLink prev" style="visibility: hidden; opacity: 0.67;" href="#" title="Previous Page"></a>
               <a class="pageLink next" style="visibility: <?php if (!empty($photos)) echo "visible"; else echo "hidden"?>; opacity: 0.67; float:right" href="#" title="Next Page"></a>
               <ul class="thumbs"  style="float:none; margin: 0px auto !important">
                  <?php
                  $photos = File::getPhotos($person->id);
                  if (!empty($photos))
                  {
                     foreach($photos as $photo)
                     {
                        if (!empty($photo->thumblink))
                        {
                           echo "<li>";
                           echo "<a class=\"thumb\" href=\"".$photo->viewlink."\" alt=\"".$photo->title."\" title=\"".$photo->title."\">";
                           echo "<img src=\"".$photo->thumblink."\" alt=\"".$photo->title."\" style='max-width: 75px; max-height: 75px;'/>";
                           echo "</a>";
                           echo "<div class=\"caption\">";
                           echo "   <div class=\"download\" style='margin-right: 8px;'><a href=\"".$photo->link."\" target=\"_blank\">Download Original</a></div>";
                           if ($session->isLoggedIn())
                           {
                              $user = User::current_user();
                              $user = recast("User", $user);
                              if ($user->rights == "admin" || $user->rights == "super")
                              {
                                 if ($person->profile_pic == $photo->id)
                                 {
                                    echo "   <div class=\"download\" style='width: 100px; margin-right: 15px;'><a href='#' alt='Set Profile Picture' id='".$photo->id."' onclick='return setProfilePic(this);'>Profile Picture</a></div>";
                                 }
                                 else
                                 {
                                    echo "   <div class=\"download\" style='width: 100px; margin-right: 15px;'><a href='#' alt='Set Profile Picture' id='".$photo->id."' onclick='return setProfilePic(this);'>Set as Profile Picture</a></div>";
                                 }
                              }
                           }
                           echo "   <div class=\"image-title\" style='text-decoration: underline;'><span style=\"margin-right: -203px !important\">".$photo->title."</span></div>";
                           echo "   <div class=\"image-title\">".$photo->comments."</div>";
                           echo "   <div class=\"image-desc\">Photo by ".$photo->author.".</div>";
                           echo "</div>";
                           echo "</li>";
                        }
                     }
                  }
                  else
                  {
                     echo "<li>";
                     echo "<a class=\"thumb\" href=\"images/familytree.jpg\" alt=\"Family Tree\" title=\"Family Tree\">";
                     echo "<img src=\"images/familytree.jpg\" alt=\"Family Tree\" width='75' height='auto' />";
                     echo "</a>";
                     echo "<div class=\"caption\">";
                     echo "<div class=\"download\" style='margin-right: 8px;'><a href=\"images/familytree.jpg\" target=\"_blank\">Download Original</a></div>";
                     echo "<div class=\"image-title\" style='text-decoration: underline;'><span style=\"margin-right: -96px !important\">Family Tree</span></div>";
                     echo "<div class=\"image-title\">Add to this individual's family tree by registering for the site, validating your email address and uploading your own contributions.</div>";
                     echo "<div class=\"image-desc\">Photo found by google search.</div>";
                     echo "</div>";
                     echo "</li>";
                     echo "<h1>There are no images uplaoded for this individual. If you'd like to contribute to their collection please contact the website owner Michele Law.</h1>";
                  }
                  ?>
               </ul>
            </div>
         </div>
      </div>
      <div class="content" style="display: block;">
         <div id="slideshow-container" class="slideshow-container">
            <div id="controls" class="controls"><div class="ss-controls"><a href="#play" class="play" title="Play Slideshow">Play Slideshow</a></div><div class="nav-controls"><a class="prev" rel="history" title="‹ Previous Photo" href="#24">‹ Previous Photo</a><a class="next" rel="history" title="Next Photo ›" href="#drop">Next Photo ›</a></div></div>
            <div class="photo-index">Photo 1 of many</div>
            <div id="loading" class="loader" style="display: none;"></div>
            <div id="slideshow" class="slideshow"><span class="image-wrapper current" style="opacity: 1;"><a class="advance-link" rel="history" href="#drop" title="Family Tree">&nbsp;<img alt="Family Tree" src="images/familytree.jpg"></a></span></div>
         </div>
         <div id="caption" class="caption-container">
            <span class="image-caption current" style="opacity: 1;"><div class="caption">
               <div class="image-title">The Family Tree</div>
               <div class="image-desc">Description</div>
               <div class="download">
                  <a href="images/familytree.jpg">Download Original</a>
               </div>
            </div></span></div>
         </div>
         <!-- End Gallery Html Containers -->
         <div style="clear: both;"></div>
      </div>
   </div>

   <script type="text/javascript">
   function setProfilePic(element)
   {
      personId = <?php echo $person->id;?>;
      $.ajax(
      {
         type: "POST",
         url: "/",
         data:
         {
            controller: "individual",
            action:     "setProfilePic",
            pic_id:     element.id,
            person_id:  personId
         },
         success: function(response, textStatus, jqXHR)
         {
            if (response != "Failure")
            {
               showResponse(response);
            }
            else
            {
               showResponse("There was an setting this individual's profile picture.");
            }
            return false;
         },
         error: function(response, textStatus, jqXHR)
         {
            showResponse(response);
         }
      });
      return false;
   }

   jQuery(document).ready(function($) {
            // We only want these styles applied when javascript is enabled
            $('div.content').css('display', 'block');

            // Initially set opacity on thumbs and add
            // additional styling for hover effect on thumbs
            var onMouseOutOpacity = 0.67;
            $('#thumbs ul.thumbs li, div.navigation a.pageLink').opacityrollover({
               mouseOutOpacity:   onMouseOutOpacity,
               mouseOverOpacity:  1.0,
               fadeSpeed:         'fast',
               exemptionSelector: '.selected'
            });
            // console.log($(window).width());
            // Initialize Advanced Galleriffic Gallery
            var gallery = $('#thumbs').galleriffic({
               delay:                     2500,
               numThumbs:                 10,
               preloadAhead:              10,
               enableTopPager:            false,
               enableBottomPager:         false,
               imageContainerSel:         '#slideshow',
               controlsContainerSel:      '#controls',
               captionContainerSel:       '#caption',
               loadingContainerSel:       '#loading',
               renderSSControls:          true,
               renderNavControls:         true,
               playLinkText:              'Play Slideshow',
               pauseLinkText:             'Pause Slideshow',
               prevLinkText:              '&lsaquo; Previous Photo',
               nextLinkText:              'Next Photo &rsaquo;',
               nextPageLinkText:          'Next &rsaquo;',
               prevPageLinkText:          '&lsaquo; Prev',
               enableHistory:             true,
               autoStart:                 false,
               syncTransitions:           true,
               defaultTransitionDuration: 900,
               onSlideChange:             function(prevIndex, nextIndex) {
                  // 'this' refers to the gallery, which is an extension of $('#thumbs')
                  this.find('ul.thumbs').children()
                  .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                  .eq(nextIndex).fadeTo('fast', 1.0);

                  // Update the photo index display
                  $('#slideshow-container').find('div.photo-index')
                  .html('Photo '+ (nextIndex+1) +' of '+ this.data.length);
               },
               onPageTransitionOut:       function(callback) {
                  this.fadeTo('fast', 0.0, callback);
               },
               onPageTransitionIn:        function() {
                  var prevPageLink = this.find('a.prev').css('visibility', 'hidden');
                  var nextPageLink = this.find('a.next').css('visibility', 'hidden');

                  // Show appropriate next / prev page links
                  if (this.displayedPage > 0)
                     prevPageLink.css('visibility', 'visible');

                  var lastPage = this.getNumPages() - 1;
                  if (this.displayedPage < lastPage)
                     nextPageLink.css('visibility', 'visible');

                  this.fadeTo('fast', 1.0);
               }
            });

/**************** Event handlers for custom next / prev page links **********************/

gallery.find('a.prev').click(function(e) {
   gallery.previousPage();
   e.preventDefault();
});

gallery.find('a.next').click(function(e) {
   gallery.nextPage();
   e.preventDefault();
});

/****************************************************************************************/

/**** Functions to support integration of galleriffic with the jquery.history plugin ****/

            // PageLoad function
            // This function is called when:
            // 1. after calling $.historyInit();
            // 2. after calling $.historyLoad();
            // 3. after pushing "Go Back" button of a browser
            function pageload(hash) {
               // alert("pageload: " + hash);
               // hash doesn't contain the first # character.
               if(hash) {
                  $.galleriffic.gotoImage(hash);
               } else {
                  gallery.gotoIndex(0);
               }
            }

            // Initialize history plugin.
            // The callback is called at once by present location.hash.
            $.historyInit(pageload, "advanced.html");

            // set onlick event for buttons using the jQuery 1.3 live method
            $("a[rel='history']").on('click', function(e) {
               if (e.button != 0) return true;

               var hash = this.href;
               hash = hash.replace(/^.*#/, '');

               // moves to a new page.
               // pageload is called at once.
               // hash don't contain "#", "?"
               $.historyLoad(hash);

               return false;
            });

            /****************************************************************************************/
         });
</script>

</div>

<script type="text/javascript">
$(document).ready(function()
{
   var name = <?php echo '"'.$person->firstName.' ';
      // if ($person->middleName != '')
      // {
         //    echo $person->middleName.' ';
         // }
         echo $person->lastName.' ';
         if ($person->yearBorn != '0')
         {
            echo $person->yearBorn.'-'.$person->yearDead.'";';
         }
         else
         {
            echo '";';
         }
         ?>
   $("#page_name").html(name);
   words = new Array();
   words.push("Familyhistorydatabase.org");
   words.push("family");
   words.push("history");
   words.push("<?php echo $person->lastName; ?>");
   words.push("<?php echo $person->firstName; ?>");
   setKeywords(words);
   setTitle(name);
});
</script>
