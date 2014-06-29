/*
* Copyright 2014 Jonathan Law.
*
* Licensed under the Apache License, Version 2.0 (the 'License');
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an 'AS IS' BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
'use strict';


/* exported setupPopovers, setupTypeahead, toggleclass, setUpDropdown*/

/***************************************************************
* Speed up calls to hasOwnProperty (somewhat of an hasOwnPropert override)
***************************************************************/
var hasOwnProperty2 = Object.prototype.hasOwnProperty;

/***************************************************************
* This function checks to see if the object is empty
* params: obj -- the object to check
* returns: boolean -- a true or false value of whether the object is empty or not
***************************************************************/
function isEmpty(obj) {
  // null and undefined are 'empty'
  if (obj === null || obj === undefined) {
    return true;
  }

  // Assume if it has a length property with a non-zero value
  // that that property is correct.
  if (obj.length > 0) {
    return false;
  }

  if (obj.length === 0) {
    return true;
  }

  // Otherwise, does it have any properties of its own?
  // Note that this doesn't handle
  // toString and valueOf enumeration bugs in IE < 9
  for (var key in obj) {
    if (hasOwnProperty2.call(obj, key)) {
      return false;
    }
  }

  return true;
}

var setupParallax = function() {
  jQuery('#parallax .parallax-layer')
  .parallax({
    xparallax: '100px',
    mouseport: jQuery('body')
  });
}
