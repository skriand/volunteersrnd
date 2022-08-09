function menu_open() {
	var div = document.getElementById('menu');
	var label = document.getElementById('menu-under');
	if (div.style.visibility != "visible") { 
		div.style.visibility = "visible";
		div.style.opacity = "1";
		label.style.visibility = "visible";
		label.style.opacity = "1";
		$("body").css("overflow","hidden");		
	}
	else {
		div.style.visibility = "hidden";
		div.style.opacity = "0";
		label.style.visibility = "hidden";
		label.style.opacity = "0";
		$("body").css("overflow","auto"); 
	}
}
function add_news_button() {
	var divs=document.getElementsByTagName("DIV");
	for (var i=0; i<divs.length; i++) {
		if(divs[i].className=="add-news-pop"){
			if (divs[i].style.visibility != "visible") { 
				divs[i].style.visibility = "visible";
				divs[i].style.opacity = "1";
			}else{
				divs[i].style.visibility = "hidden";
				divs[i].style.opacity = "0";
			}
		}
	}
	
}

//if (document.getElementById('add-news-close-button') != undefined ) {
//	document.getElementById('add-news-close-button').onclick = function(){

//	}
//}

function participants() {
	if ($(".participants-list").css("display") == "none"){
		$(".participants-list").css("display","block");
		$(".participants-arrow").css("transform","rotate(0)");
	}
	else {
		$(".participants-list").css("display","none"); 
		$(".participants-arrow").css("transform","rotate(180deg)");
	}
}

$(window).resize(function() {
	if(window.innerWidth < 700.5) {
		
	}
	if(window.innerWidth > 700.5) {
		
	}
});

