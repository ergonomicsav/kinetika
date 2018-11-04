jQuery(document).ready(function(e) {

	jQuery(".system-table tr:odd").addClass("odd");
	jQuery(".system-table tr:even").addClass("even");

	// if clicked on import data button
	jQuery('.button-install-demo').live('click', function(e) {
		var selected_demo = jQuery(this).data('demo-id');

		jQuery('#' + selected_demo + '-demo-tab').removeClass('selectable');
		jQuery('#' + selected_demo + '-demo-tab').toggleClass('overlay-active');
		jQuery('.theme-demo-browser').toggleClass('demo-importing-in-progress');

		console.log('#' + selected_demo + '-demo-tab');

		var data = {
			action: 'imaginem_import_demo_data',
			demo_type: selected_demo
		};

		console.log(data);

		jQuery('.importer-notice').hide();

		jQuery.post(ajaxurl, data, function(response) {
			if( response && response.indexOf('imported') == -1 ) {
				jQuery('.importer-notice-1').attr('style','display:block !important');

			} else {
				jQuery('.importer-notice-2').attr('style','display:block !important');

				jQuery('#' + selected_demo + '-demo-tab').addClass('selectable');
				jQuery('#' + selected_demo + '-demo-tab').toggleClass('overlay-active');
				jQuery('.theme-demo-browser').toggleClass('demo-importing-in-progress');
			}
		}).fail(function() {
			jQuery('.importer-notice-3').attr('style','display:block !important');
			
			jQuery('#' + selected_demo + '-demo-tab').addClass('selectable');
			jQuery('#' + selected_demo + '-demo-tab').toggleClass('overlay-active');
			jQuery('.theme-demo-browser').toggleClass('demo-importing-in-progress');
		});

		e.preventDefault();
	});
});
