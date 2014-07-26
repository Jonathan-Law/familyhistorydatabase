'use strict';

describe('Service: individualService', function () {

  // load the service's module
  beforeEach(module('familyhistorydatabaseApp'));

  // instantiate service
  var individualService;
  beforeEach(inject(function (_individualService_) {
    individualService = _individualService_;
  }));

  it('should do something', function () {
    expect(!!individualService).toBe(true);
  });

});
