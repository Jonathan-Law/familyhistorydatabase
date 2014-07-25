'use strict';

describe('Directive: myModal', function () {

  // load the directive's module
  beforeEach(module('familyhistorydatabaseApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<my-modal></my-modal>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the myModal directive');
  }));
});
