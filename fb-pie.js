var fb_friends_url = "https://www.facebook.com/ajax/typeahead/search/first_degree.php?__a=1&filter[0]=user&lazy=0&viewer="+Env.user+"&token=&stale_ok=0";

jQuery.ajax({

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

		var display = $("<div id='friend-edge-display'></div><div id='default' class='graph' style='width:900px;height:700px;'></div>");		
		var data = [];
		for(var i = 0; i < 25; i++){
			data[i] = { label: friends[i].text, data: friends[i].index*-1};
		}
		$('body').append(display);

		var title = $("<div id='friend-edge-title'>Facebook Friend Rankings</div>");
		display.prepend(title);
		console.log(data);

		$('#graph').css('width: 900px;');
		$('#graph').css('height: 700px;');

		$('#friend-edge-title').css('font', '20px bold "helvetica neue"');
		$('#friend-edge-title').css('margin-bottom', '10px');


		$('#friend-edge-display').css('position', 'absolute');
		$('#friend-edge-display').css('top', '100px');
		$('#friend-edge-display').css('width', '900px');
		$('#friend-edge-display').css('left', '50px');
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
