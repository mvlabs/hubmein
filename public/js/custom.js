// initialise plugins

jQuery(function(){


	/*Rating*/
	$('.popularity').raty({
	  half:  true,
	  start: 0
	});
	$('.popularity-big').raty({
		half:true,
		size:24,
		starOff:'big-hub-off.png',
		starOn:	'big-hub-on.png',
		starHalf:'big-hub-half.png'
	});
	
});
