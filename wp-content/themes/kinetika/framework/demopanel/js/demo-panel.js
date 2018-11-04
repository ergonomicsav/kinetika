jQuery(document).ready(function($){

	"use strict";

// **********************************************************************
// DEMO Panel Selectors. Only used in Demo
// **********************************************************************

	jQuery('.demo-target-link').live("click", function(){
		//dashboard toggle
		var scrollelement = jQuery(this).closest('.demo-target-base');
		var fromtop = scrollelement.offset().top;
		var scrolltobase = scrollelement[0].scrollHeight + fromtop - 150;
		jQuery('body,html').animate({
			scrollTop: scrolltobase
		}, 800);
	});
	
	var panelClose = jQuery('#demopanel .closedemo');
	var panelOpen = jQuery('#demopanel .opendemo');
	var panelWrap = jQuery('#demopanel');
	
	jQuery('#demopanel .closedemo').click(function() {
		 panelClose.css('display', 'none');
		 panelOpen.css('display', 'block');
		 panelWrap.stop().animate({ right: '-275'}, {duration: 'fast'});
	});
	jQuery('#demopanel .opendemo').click(function() {
		 panelClose.css('display', 'block');
		 panelOpen.css('display', 'none');
		 panelWrap.stop().animate({ right: '0'}, {duration: 'fast'});
	});
});