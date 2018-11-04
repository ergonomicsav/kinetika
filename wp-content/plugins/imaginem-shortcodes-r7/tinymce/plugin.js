(function ()
{
	tinymce.PluginManager.add('mtheme_button', function(ed, url) {
	    ed.addCommand("mthemePopup", function ( a, params )
	    {
	        var popup = 'shortcode-generator';
	 
	        if(typeof params != 'undefined' && params.identifier) {
	            popup = params.identifier;
	        }
	        
	        jQuery('#TB_window').hide();
	 
	        // load thickbox
	        tb_show("Theme Shortcodes", url + "/popup.php?popup=" + popup + "&width=" + 820);
	    });
	 
	    // Add a button that opens a window
	    ed.addButton('mtheme_button', {
	        text: '',
	        title : 'mtheme Shortcode Generator',
	        icon: true,
	        image: mtheme_shortcodegen_url +"/images/icon.png",
	        cmd: 'mthemePopup'
	    });
	});
})();