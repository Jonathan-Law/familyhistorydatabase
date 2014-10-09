'use strict';

app.filter('partition', function () {
  // first we make sure that the cache is empty
  var cache = {};
  var filter = function(arr, size) {
    // if we don't have an array to search return...
    if (!arr) { return; }
    
    // otherwise start out empty
    var newArr = [];
    
    // and for every piece in the array,
    for (var i=0; i<arr.length; i+=size) {
      // push portions of the array sliced by the input size
      newArr.push(arr.slice(i, i+size));
    }

    // then stringify the array
    var arrString = JSON.stringify(arr);

    // set up the cache
    var fromCache = cache[arrString+size];

    // and from the cache, return the results
    if (JSON.stringify(fromCache) === JSON.stringify(newArr)) {
      return fromCache;
    }
    cache[arrString+size] = newArr;
    return newArr;
  };
  return filter;
});
