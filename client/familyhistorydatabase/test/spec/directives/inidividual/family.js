'use strict';

describe('Directive: inidividual/family', function () {

  // load the directive's module
  beforeEach(module('familyhistorydatabaseApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<inidividual/family></inidividual/family>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the inidividual/family directive');
  }));
});
