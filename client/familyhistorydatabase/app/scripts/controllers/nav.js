'use strict';

/**
* @ngdoc function
* @name familyhistorydatabaseApp.controller:NavCtrl
* @description
* # NavCtrl
* Controller of the familyhistorydatabaseApp
*/
app.controller('NavCtrl', ['$rootScope', '$scope', '$aside', 'business', '$location', '$timeout', function ($rootScope, $scope, $aside, Business, $location, $timeout) { /*jshint unused:false*/
  $scope.user       = $rootScope.user;
  $scope.searchKey  = null;

  $scope.loggedIn   = false;

  if ($scope.user) {
    $scope.user.admin = false;
  }

  $scope.aside = {
    'title': 'Title',
    'content': 'Hello Aside<br />This is a multiline message!'
  };

  $scope.$on('$NOTLOGGEDIN', function(){
    $scope.logout();
  })
  $scope.$on('$LOGGEDIN', function(event, user){
    if (user) {
      $scope.user = angular.copy(user);
      $scope.loggedIn = true;
      $scope.user.admin = $scope.user.rights === 'super' || $scope.user.rights === 'admin';
    }
  })

  $scope.getUserName = function(){
    if ($scope.user && $scope.user.displayableName) {
      return $scope.user.displayableName;
    } else if ($scope.loggedIn) {
    }
    return 'Login/Register'
  }

  $scope.logout = function() {
    Business.user.logout();
    $scope.$emit('$triggerEvent', '$LOGOUT');
    $scope.user = null;
    $rootScope.user = null;
    $scope.loggedIn = false;
  };

  $scope.login = function() {
    $scope.$emit('$triggerEvent', '$triggerModal',   {
      'nav': {
        'bars': [
        {
          'title': 'Login',
          'include': 'views/auth/login.html'
        },
        {
          'title': 'Register',
          'include': 'views/auth/register.html'
        }
        ],
        'current': 'Login'
      },
      'showFooter': false,
      'classes': [
      'hasNav',
      'darkTheme'
      ]
    });
  };

  $scope.onSelect = function(item, model, something) {
    if (typeof $scope.searchKey === 'object' && $scope.searchKey){
      console.log('searchKey', $scope.searchKey);
      if ($scope.searchKey.id)
      {
        $location.search({
          'individual': $scope.searchKey.id,
          'tab': 'default'
        });
        $location.path('/individual');
        // Business.individual.getIndData($scope.searchKey.id).then(function(result) {
          // console.log('Typeahead Item Found: ', $scope.searchKey);
          // console.log('Individual: ', result);
        // });
}
} else {
      // console.log('searchKey', $scope.searchKey);
    }
  };

  $scope.goTo = function(location) {
    $location.search({});
    $location.path(location);
  }

  $scope.checkLogin().then(function(response){
    if (response) {
      // console.log('response', response);
      
      $scope.loggedIn = true;
      $scope.user = response;
    }
  });


  var closeMenu = function() {
    var menuItems = $('.side-wrapper-nav');
    var dropdowns = $('.sidebar-nav li .dropdown.open a[dropdowntoggle]');
    menuItems.each(function() {
      $(this).removeClass('active');
    });
    dropdowns.each(function(){
      var id = $(this).attr('dropdown-tog');
      $scope.$emit('$TRIGGEREVENT', '$TOGDROP', id);
    })
  }
  var openMenu = function() {
    var menuItems = $('.side-wrapper-nav');
    menuItems.each(function() {
      $(this).addClass('active');
    });
  }

  $(document).ready(function() {
    $('#sidebar-wrapper').on('mouseleave', function(e) {
      closeMenu();
    });
    $("#menu-toggle").on( 'click, mouseenter', function(e) {
      // e.stopPropagation();
      openMenu();
    });
    $(document).on('click', function(e) {
      var attr = $(e.target).attr('dropdowntoggle');
      if (('menu-toggle' !== $(e.target).attr('id'))
        && ( 'sideNavSearch' !== $(e.target).attr('id'))
        && ( 'sidebar-brand' !== $(e.target).attr('id'))
        && !(typeof attr !== typeof undefined && attr !== false)) {
        closeMenu();
        //
      } else {
        e.stopPropagation();
      }
    });

  });

  // Pre-fetch an external template populated with a custom scope
  // var myOtherAside = $aside({scope: $scope, template: 'views/navAside.html'});
  // // Show when some event occurs (use $promise property to ensure the template has been loaded)
  // myOtherAside.$promise.then(function() {
  //   myOtherAside.show();
  // })
}]);
