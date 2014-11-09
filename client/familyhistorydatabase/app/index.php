<?php 

require_once("api/library/paths.php");

// Load the Config File
require_once(LIBRARY."config.php");

// Load the functions so that everything can use them
require_once(LIBRARY."functions.php");

// Load the core objects
// require_once(CLASSES."mysqli_database.php");

require_once(OBJECTS."birth.php");
require_once(OBJECTS."death.php");
require_once(OBJECTS."burial.php");
require_once(OBJECTS."parents.php");
require_once(OBJECTS."person.php");
require_once(OBJECTS."spouse.php");
require_once(OBJECTS."place.php");
require_once(OBJECTS."file.php");
require_once(OBJECTS."tag.php");
require_once(OBJECTS."dropzone.php");
require_once(OBJECTS."connections.php");


require_once(TOOLS."user.php");
require_once(TOOLS."favorites.php");
require_once(TOOLS."pagination.php");
require_once(TOOLS."url.php");
require_once(TOOLS."mySession.conf.php");
require_once(TOOLS."mySession.class.php");
require_once(TOOLS."cbSQLConnect.class.php");

$session = mySession::getInstance();

?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="openstorefrontApp"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" ng-app="openstorefrontApp"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" ng-app="openstorefrontApp"> <![endif]-->
<!--[if gt IE 8]><!--> <html xmlns:ng="http://angularjs.org" id="ng-app" class="no-js" > <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
  <!-- build:css(.) styles/vendor.css -->
  <!-- bower:css -->
  <link rel="stylesheet" href="bower_components/angular-motion/dist/angular-motion.css" />
  <link rel="stylesheet" href="bower_components/fontawesome/css/font-awesome.css" />
  <!-- endbower -->
  <!-- endbuild -->
  <!-- build:css(.tmp) styles/main.css -->
  <link rel="stylesheet" href="styles/main.css">
  <!-- endbuild -->
  <link rel="stylesheet" type="text/css" href="styles/ng-tags-input.min.css" />
  <link rel="stylesheet" type="text/css" href="styles/bootstrap-additions.min.css">
  <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
</head>
<body ng-app="familyhistorydatabaseApp">
  <!--[if lt IE 9]>
  <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <!-- Add your site or application content here -->

  <div ng-include="'views/nav.html'"></div>


  <div class="container-fluid" id="mainContent">
    <!-- <div class="header"> -->
    <!-- <h3 class="text-muted">familyhistorydatabase</h3> -->
    <!-- </div> -->

    <div ng-view="" style="height:100%"></div>

    <!-- <div class="footer"> -->
      <!-- <p><span class="glyphicon glyphicon-heart"></span> from the Yeoman team</p> -->
    <!-- </div> -->
  </div>

  <my-modal></my-modal>

  <!-- <div ng-include="'views/background.html'"></div> -->


  <!-- Google Analytics: change UA-XXXXX-X to be your site's ID -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52176517-1', 'familyhistorydatabase.org');
  ga('send', 'pageview');
  </script>

  <!--[if lt IE 9]>
  <script src="bower_components/es5-shim/es5-shim.js"></script>
  <script src="bower_components/json3/lib/json3.min.js"></script>
  <![endif]-->



  <!-- Extra js -->
  <script type="text/javascript" src="scripts/common/hoverdirModernizr.js"></script>
  <script type="text/javascript" src="scripts/common/dropzone.js"></script>



  <!-- build:js(.) scripts/vendor.js -->
  <!-- bower:js -->
  <script src="bower_components/jquery/dist/jquery.js"></script>
  <script src="bower_components/angular/angular.js"></script>
  <script src="bower_components/json3/lib/json3.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js"></script>
  <script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js"></script>
  <script src="bower_components/angular-resource/angular-resource.js"></script>
  <script src="bower_components/angular-cookies/angular-cookies.js"></script>
  <script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
  <script src="bower_components/angular-animate/angular-animate.js"></script>
  <script src="bower_components/angular-touch/angular-touch.js"></script>
  <script src="bower_components/angular-route/angular-route.js"></script>
  <script src="bower_components/underscore/underscore.js"></script>
  <script src="bower_components/moment/moment.js"></script>
  <script src="bower_components/jquery-waypoints/waypoints.js"></script>
  <script src="bower_components/SHA-1/sha1.js"></script>
  <script src="bower_components/angulartics/src/angulartics.js"></script>
  <script src="bower_components/angulartics/src/angulartics-adobe.js"></script>
  <script src="bower_components/angulartics/src/angulartics-chartbeat.js"></script>
  <script src="bower_components/angulartics/src/angulartics-flurry.js"></script>
  <script src="bower_components/angulartics/src/angulartics-ga-cordova.js"></script>
  <script src="bower_components/angulartics/src/angulartics-ga.js"></script>
  <script src="bower_components/angulartics/src/angulartics-gtm.js"></script>
  <script src="bower_components/angulartics/src/angulartics-kissmetrics.js"></script>
  <script src="bower_components/angulartics/src/angulartics-mixpanel.js"></script>
  <script src="bower_components/angulartics/src/angulartics-piwik.js"></script>
  <script src="bower_components/angulartics/src/angulartics-scroll.js"></script>
  <script src="bower_components/angulartics/src/angulartics-segmentio.js"></script>
  <script src="bower_components/angulartics/src/angulartics-splunk.js"></script>
  <script src="bower_components/angulartics/src/angulartics-woopra.js"></script>
  <script src="bower_components/angulartics/src/angulartics-marketo.js"></script>
  <script src="bower_components/angulartics/src/angulartics-intercom.js"></script>
  <script src="bower_components/lodash/dist/lodash.compat.js"></script>
  <!-- endbower -->
  <!-- endbuild -->

  <!-- build:js({.tmp,app}) scripts/scripts.js -->
  <script type="text/javascript" src="scripts/app.js"></script>

  <script type="text/javascript" src="scripts/controllers/main.js"></script>
  <script type="text/javascript" src="scripts/controllers/about.js"></script>
  <script type="text/javascript" src="scripts/controllers/nav.js"></script>
  <script type="text/javascript" src="scripts/controllers/auth/login.js"></script>
  <script type="text/javascript" src="scripts/controllers/auth/register.js"></script>
  <script type="text/javascript" src="scripts/controllers/background.js"></script>
  <script type="text/javascript" src="scripts/controllers/individual/addindividual.js"></script>
  <script type="text/javascript" src="scripts/controllers/admin.js"></script>
  <script type="text/javascript" src="scripts/controllers/admin/addfiles.js"></script>
  <script type="text/javascript" src="scripts/controllers/admin/edit.js"></script>
  <script type="text/javascript" src="scripts/controllers/route/families.js"></script>
  <script type="text/javascript" src="scripts/controllers/route/lastnames.js"></script>
  <script type="text/javascript" src="scripts/controllers/route/individual.js"></script>
  <script type="text/javascript" src="scripts/controllers/files/editfile.js"></script>

  <script type="text/javascript" src="scripts/services/localcache.js"></script>
  <script type="text/javascript" src="scripts/services/business.js"></script>
  <script type="text/javascript" src="scripts/services/userservice.js"></script>
  <script type="text/javascript" src="scripts/services/authservice.js"></script>
  <script type="text/javascript" src="scripts/services/individualservice.js"></script>
  <script type="text/javascript" src="scripts/services/fileservice.js"></script>

  <script type="text/javascript" src="scripts/directives/individual.js"></script>
  <script type="text/javascript" src="scripts/directives/enterevent.js"></script>
  <script type="text/javascript" src="scripts/directives/mymodal.js"></script>
  <script type="text/javascript" src="scripts/directives/place.js"></script>
  <script type="text/javascript" src="scripts/directives/date.js"></script>
  <script type="text/javascript" src="scripts/directives/individual/editindividual.js"></script>
  <script type="text/javascript" src="scripts/directives/dynamichtml.js"></script>
  <script type="text/javascript" src="scripts/directives/box.js"></script>
  <script type="text/javascript" src="scripts/directives/spouse.js"></script>
  <script type="text/javascript" src="scripts/directives/dropzone.js"></script>
  <script type="text/javascript" src="scripts/directives/massdropzone.js"></script>
  <script type="text/javascript" src="scripts/directives/files/editfile.js"></script>
  <script type="text/javascript" src="scripts/directives/individual/content.js"></script>
  <script type="text/javascript" src="scripts/directives/individual/catchkey.js"></script>
  <script type="text/javascript" src="scripts/directives/individual/breadcrumbs.js"></script>
  <script type="text/javascript" src="scripts/directives/individual/photoalbum.js"></script>
  
  <script type="text/javascript" src="scripts/filters/partition.js"></script>

  <script type="text/javascript" src="scripts/common/sessionpolyfill.js"></script>
  <script type="text/javascript" src="scripts/common/angular-pageslide-directive.js"></script>
  <script type="text/javascript" src="scripts/common/common.js"></script>
  <script type="text/javascript" src="scripts/common/jquery.event.frame.js"></script>
  <script type="text/javascript" src="scripts/common/jquery.parallax.js"></script>
  <script type="text/javascript" src="scripts/common/jquery.hoverdir.js"></script>
  <script type="text/javascript" src="scripts/common/angular-strap.js"></script>
  <script type="text/javascript" src="scripts/common/angular-strap.tpl.js"></script>
  <script type="text/javascript" src="scripts/common/ui-bootstrap-tpls.js"></script>
  <script type="text/javascript" src="scripts/common/ng-tags-input.js"></script>
  <!-- endbuild -->

</body>
</html>
