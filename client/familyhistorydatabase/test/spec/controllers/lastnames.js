'use strict';

describe('Controller: LastnamesCtrl', function () {

  // load the controller's module
  beforeEach(module('familyhistorydatabaseApp'));

  var LastnamesCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    LastnamesCtrl = $controller('LastnamesCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
