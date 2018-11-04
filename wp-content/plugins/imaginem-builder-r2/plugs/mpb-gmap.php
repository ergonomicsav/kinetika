<?php
/** Google Map **/
if(!class_exists('em_googlemap')) {
		class em_googlemap extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pointer',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Google Map','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Google Map','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Google Maps
			/*-----------------------------------------------------------------------------------*/
			$mtheme_shortcodes['map'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Google Maps', 'mthemelocal'),
				'params' => array(
					'map_type' => array(
						'type' => 'select',
						'label' => __('Map Type', 'mthemelocal'),
						'desc' => __('Map Type', 'mthemelocal'),
						'options' => array(
							'ROADMAP' => __('roadmap','mthemelocal'),
							'SATELLITE' => __('satellite','mthemelocal'),
							'HYBRID' => __('hybrid','mthemelocal'),
							'TERRAIN' => __('terrain','mthemelocal'),
						)
					),
					'map_style' => array(
						'type' => 'select',
						'label' => __('Map Style', 'mthemelocal'),
						'desc' => __('Map Style', 'mthemelocal'),
						'options' => array(
							'desaturated' => __('Desaturated','mthemelocal'),
							'lightdream' => __('Light Dream','mthemelocal'),
							'shadesofgrey' => __('Shades of Grey','mthemelocal'),
							'applemaps' => __('Apple Maps','mthemelocal'),
							'lightmonochrome' => __('Light Monochrome','mthemelocal'),
							'mapbox' => __('Map Box','mthemelocal'),
							'gowalla' => __('Gowalla','mthemelocal'),
							'cleancut' => __('Clean Cut','mthemelocal')
						)
					),
			        'map_address' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Map Address', 'mthemelocal'),
			            'desc' => __('Map Address', 'mthemelocal'),
			        ),
			        'map_height' => array(
			            'std' => '400',
			            'type' => 'text',
			            'label' => __('Map Height', 'mthemelocal'),
			            'desc' => __('Map Height', 'mthemelocal'),
			        ),
			        'map_latitude' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Map Latitude', 'mthemelocal'),
			            'desc' => __('Set 0 if you want to don\'t want to use the field. Map Latitude', 'mthemelocal'),
			        ),
			        'map_longitude' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Map Longitude', 'mthemelocal'),
			            'desc' => __('Set 0 if you want to don\'t want to use the field. Map Longitude', 'mthemelocal'),
			        ),
					'map_marker' => array(
						'type' => 'select',
						'label' => __('Map Marker', 'mthemelocal'),
						'desc' => __('Map Marker', 'mthemelocal'),
						'options' => array(
							'yes' => __('Yes','mthemelocal'),
							'no' => __('No','mthemelocal')
						)
					),
			        'map_zoom' => array(
			            'std' => '18',
			            'type' => 'text',
			            'label' => __('Map Zoom (1 to 20)', 'mthemelocal'),
			            'desc' => __('Map Height', 'mthemelocal'),
			        ),
					'map_scroll' => array(
						'type' => 'select',
						'label' => __('Mouse Scroll', 'mthemelocal'),
						'desc' => __('Mouse Scroll', 'mthemelocal'),
						'options' => array(
							'true' => __('True','mthemelocal'),
							'false' => __('False','mthemelocal')
						)
					),
					'map_control' => array(
						'type' => 'select',
						'label' => __('Map Controls', 'mthemelocal'),
						'desc' => __('Map Controls', 'mthemelocal'),
						'options' => array(
							'true' => __('True','mthemelocal'),
							'false' => __('False','mthemelocal')
						)
					),
			        'map_marker_image' => array(
			            'std' => '',
			            'type' => 'uploader',
			            'label' => __('Image as marker', 'mthemelocal'),
			            'desc' => __('Image as marker', 'mthemelocal'),
			        ),
			        'map_marker_text' => array(
			            'std' => __('Marker Text','mthemelocal'),
			            'type' => 'text',
			            'label' => __('Marker text', 'mthemelocal'),
			            'desc' => __('Marker text', 'mthemelocal'),
			        )
				),
				'shortcode' => '[map maptype="{{map_type}}" mapstyle="{{map_style}}" scrollwheel="{{map_scroll}}" markerimage="{{map_marker_image}}" infowindow="{{map_marker_text}}" lat="{{map_latitude}}" lon="{{map_longitude}}" hidecontrols="{{map_control}}" marker="{{map_marker}}" z="{{map_zoom}}" h="{{map_height}}" w="{{map_width}}" address="{{map_address}}"]',
				'popup_title' => __('Add Google Maps', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['map'];

			//create the block
			parent::__construct('em_googlemap', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_scripts'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			wp_enqueue_script ('GoogleMaps');
			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}