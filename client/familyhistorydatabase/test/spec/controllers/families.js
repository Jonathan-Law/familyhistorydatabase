'use strict';

describe('Controller: FamiliesCtrl', function () {

  // load the controller's module
  beforeEach(module('familyhistorydatabaseApp'));

  var FamiliesCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    FamiliesCtrl = $controller('FamiliesCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
