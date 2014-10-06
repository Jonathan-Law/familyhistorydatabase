'use strict';

describe('Directive: individual/catchkey', function () {

  // load the directive's module
  beforeEach(module('familyhistorydatabaseApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<individual/catchkey></individual/catchkey>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the individual/catchkey directive');
  }));
});
