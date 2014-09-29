'use strict';

describe('Directive: massDropzone', function () {

  // load the directive's module
  beforeEach(module('familyhistorydatabaseApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<mass-dropzone></mass-dropzone>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the massDropzone directive');
  }));
});
