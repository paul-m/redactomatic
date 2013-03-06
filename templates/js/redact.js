// var intervalID = window.setInterval(func, delay[, param1, param2, ...]);


// Set up an interval, have jquery grab the newest, 
// grab the 
//make a private dom tree,
// put the new and old in the new dom tree, sort the tree, 

"use strict";


function populateStatuses (statusesArray) {
  var domStatuses = $('.statusItem');
  domStatuses.each(
    function(index) {
      var statusItem = domStatuses[index];
      var thingie = $(statusItem).data('object');
      var json = statusesArray.$(statusItem).data('id_str');
//      statuses.($(statusItem).attr('data-id_str')) =
//        $(statusItem).attr('data-json').html()
    }
  );
  console.log(statusesArray);
}


/*

You can also use JSON syntax in data attributes, like so:
<div data-foobar='{"foo":"bar"}'></div>
Note that the attribute uses single quotes while the key:value pair inside are in double quotes; this is required to be valid JSON syntax. To access this with jQuery, just add the key name as an object at the end of the string:
var baz = $('div').data('foobar').foo;
This will once again instruct the variable baz to have the value ‘bar’.

*/

//foo.each(function (index) { console.log( index + ": " + $(this).data('id_str')) })