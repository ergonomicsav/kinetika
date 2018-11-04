<?php
/** Social Icons **/
if(!class_exists('em_social')) {
		class em_social extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-share',
				'pb_block_icon_color' => '#0074D9',
				'name' => __('Sociallink','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Social Link','mthemelocal')
			);

			$mtheme_shortcodes['socials'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a Social link', 'mthemelocal'),
				'params' => array(
			        'social_icon' => array(
			            'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Font Awesome icon', 'mthemelocal'),
			            'desc' => __('Select a fontawesome icon', 'mthemelocal'),
			            'options' => ''
			        ),
					'align' => array(
						'type' => 'select',
						'label' => __('Align', 'mthemelocal'),
						'desc' => __('Align', 'mthemelocal'),
						'options' => array(
							'left' => __('left','mthemelocal'),
							'right' => __('right','mthemelocal')
						)
					),
					'social_color' => array(
						'std' => '#EC3939',
						'type' => 'color',
						'label' => __('Social icon color', 'mthemelocal'),
						'desc' => __('Social icon color', 'mthemelocal'),
					),
			        'social_link' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Social link', 'mthemelocal'),
			            'desc' => __('Social link', 'mthemelocal'),
			        ),
			        'social_text' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Social hover text', 'mthemelocal'),
			            'desc' => __('Social hover text', 'mthemelocal'),
			        )
				),
				'shortcode' => '[socials align="{{align}}" social_color="{{social_color}}" social_icon="{{social_icon}}" social_link="{{social_link}}" social_text="{{social_text}}"]',
				'popup_title' => __('Add a Social link', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['socials'];

			//create the block
			parent::__construct('em_social', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}