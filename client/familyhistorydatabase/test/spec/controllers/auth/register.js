'use strict';

describe('Controller: AuthRegisterCtrl', function () {

  // load the controller's module
  beforeEach(module('familyhistorydatabaseApp'));

  var AuthRegisterCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AuthRegisterCtrl = $controller('AuthRegisterCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
