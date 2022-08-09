$(document).ready(function(){
	
	if ($(this).scrollTop() > 400) {
		//$('.scrollup').show();
		$('.scrollup').stop().fadeIn();
		//$('.scrollup').css('display', 'inline-block');
	}
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 400) {
			$('.scrollup').stop().fadeIn();
			//$('.scrollup').css('display', 'inline-block');
		} else {
			$('.scrollup').stop().fadeOut();
		}
	});
 
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
 
});

