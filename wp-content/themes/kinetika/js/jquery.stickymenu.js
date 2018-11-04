jQuery(document).ready(function($){
	"use strict";
	
	var stickyzone = $('.stickymenu-zone');
	var stickyNavTop = 10;

	var stickyNav = function(){
		var scrollTop = $(window).scrollTop();
		     
		if (scrollTop > stickyNavTop) { 
		   stickyzone.addClass('sticky-menu-activate');
		   $('body').addClass('sticky-menu-on');
		} else {
		   stickyzone.removeClass('sticky-menu-activate'); 
		   $('body').removeClass('sticky-menu-on');
		}
	};

	stickyNav();

	$(window).scroll(function() {
		stickyNav();
	});
});
