'use strict';

describe('Controller: IndividualCtrl', function () {

  // load the controller's module
  beforeEach(module('familyhistorydatabaseApp'));

  var IndividualCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    IndividualCtrl = $controller('IndividualCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
