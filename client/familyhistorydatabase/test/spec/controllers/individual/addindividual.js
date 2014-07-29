'use strict';

describe('Controller: IndividualAddindividualCtrl', function () {

  // load the controller's module
  beforeEach(module('familyhistorydatabaseApp'));

  var IndividualAddindividualCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    IndividualAddindividualCtrl = $controller('IndividualAddindividualCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
