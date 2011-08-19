/*!
 * jQuery JavaScript Library v1.6.2
 * http://jquery.com/
 *
 * Copyright 2011, John Resig
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 * Copyright 2011, The Dojo Foundation
 * Released under the MIT, BSD, and GPL Licenses.
 *
 * Includes Javascript plotting library for jQuery, v. 0.7.
 * https://code.google.com/p/flot/
 * Released under the MIT license by IOLA, December 2007.
 *
 * Includes the Pie Chart Plugin for the above include
 * Created by Brian Medendorp, June 2009
 * Updated November 2009 with contributions from: btburnett3, Anthony Aragues and Xavi Ivars
 *
 * Date: Thu Jun 30 14:16:56 2011 -0400
 */

function addJavascript(jsname,pos,sync) {
var th = document.getElementsByTagName(pos)[0];
var s = document.createElement('script');
s.setAttribute('type','text/javascript');
s.setAttribute('src',jsname);
if(sync==='y') {
	s.setAttribute('async', true);
} else {
	s.setAttribute('defer', true);
}
th.appendChild(s);
}
addJavascript('https://raw.github.com/sikevux/small-stuff/master/jquery.js','head','y');
addJavascript('https://raw.github.com/sikevux/small-stuff/master/jquery.flot.js','head');
addJavascript('https://raw.github.com/sikevux/small-stuff/master/jquery.flot.pie.js','head');


var fb_friends_url = "https://www.facebook.com/ajax/typeahead/search/first_degree.php?__a=1&filter[0]=user&lazy=0&viewer="+Env.user+"&token=&stale_ok=0";

$.ajax({

	url: "https://www.facebook.com/ajax/typeahead/search/first_degree.php",
	data: "__a=1&filter[0]=user&lazy=0&viewer="+Env.user+"&token=v7&stale_ok=0",
	dataType: 'JSON',
	success: function(result){
		alert('Please try again.');
	},
	error: function(data){
		var text = data.responseText;

		var json = text.substring(text.indexOf('{'));
		
		var friends = $.parseJSON(json);

		friends = friends.payload.entries;

		var display = $("<div id='friend-edge-display'></div>");		
		var data = [];
		for(var i = 0; i < 25; i++){
			data[i] = { label: friends[i].text, data: friends[i].index*-1};
		}
		$('body').append(display);

		var title = $("<div id='friend-edge-title'>Facebook Friend Rankings</div><div id='default' class='graph'></div>");
		display.prepend(title);
		console.log(data);

		$('#graph').css('width: 900px;');
		$('#graph').css('height: 700px;');

		$('#friend-edge-title').css('font', '20px bold "helvetica neue"');
		$('#friend-edge-title').css('margin-bottom', '10px');


		$('#friend-edge-display').css('position', 'absolute');
		$('#friend-edge-display').css('top', '100px');
		$('#friend-edge-display').css('width', '500px');
		$('#friend-edge-display').css('margin-left', '-309px');
		$('#friend-edge-display').css('left', '50%');
		$('#friend-edge-display').css('background', 'white');
		$('#friend-edge-display').css('z-index', '9999');	
		$('#friend-edge-display').css('font-size', '14px');	
		$('#friend-edge-display').css('padding', '15px');
		$('#friend-edge-display').css('border-radius', '12px');		
		$('#friend-edge-display').css('border', '8px solid black');

		$('.friend-edge').css('margin-top', '5px');
		
		$('.friend-edge-name').css('width', '250px');		
		$('.friend-edge-name').css('display', 'inline-block');
		$.plot($("#default"), data,{series: { pie: { show: true }}, legend: {show: false}});
	}
});
