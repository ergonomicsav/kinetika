<?php
/**
 * Aqua Page Builder Config
 *
 * This file handles various configurations
 * of the page builder page
 *
 */
function mtheme_page_builder_config() {

	$config = array(); //initialise array
	
	/* Page Config */
	$config['menu_title'] = __('iMaginem Page Builder', 'mthemelocal');
	$config['page_title'] = __('iMaginem Page Builder', 'mthemelocal');
	$config['page_slug'] = __('aq-page-builder', 'mthemelocal');
	
	/* This holds the contextual help text - the more info, the better.
	 * HTML is of course allowed in all of its glory! */
	$config['contextual_help'] = 
		'<p>' . __('The page builder allows you to create custom page templates which you can later use for your pages.', 'mthemelocal') . '<p>';
	
	/* Debugging */
	$config['debug'] = false;
	
	return $config;
	
}