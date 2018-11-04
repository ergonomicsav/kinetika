<?php
/** Richtext **/
if(!class_exists('em_portfolio_details')) {
		class em_portfolio_details extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'feather-icon-marquee',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Portfolio Details','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Add Portfolio Details','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['portfolio_details'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Project Details', 'mthemelocal'),
				'params' => array(
					'project_title' => array(
						'std' => 'Project Description',
						'type' => 'text',
						'label' => __('Project title', 'mthemelocal'),
						'desc' => __('Add Project title', 'mthemelocal')
					),
					'project_desc' => array(
						'std' => '',
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Project description', 'mthemelocal'),
						'desc' => __('Project description', 'mthemelocal')
					),
					'project_detail_title' => array(
						'std' => 'Project Details',
						'type' => 'text',
						'label' => __('Details title', 'mthemelocal'),
						'desc' => __('Project details title', 'mthemelocal')
					),
				    'alignment' => array(
				      'type' => 'select',
				      'label' => __('Alignment', 'mthemelocal'),
				      'desc' => __('Alignment', 'mthemelocal'),
				      'options' => array(
				        'left' => __('Left','mthemelocal'),
				        'center' => __('Center','mthemelocal'),
				        'right' => __('Right','mthemelocal')
				      )
				    ),
					'project_client' => array(
						'std' => 'Client Name',
						'type' => 'text',
						'label' => __('Client', 'mthemelocal'),
						'desc' => __('Client Name', 'mthemelocal')
					),
					'project_client_title' => array(
						'std' => 'Client',
						'type' => 'text',
						'label' => __('Client Title', 'mthemelocal'),
						'desc' => __('Client Title', 'mthemelocal')
					),					
					'project_client_link' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Client link', 'mthemelocal'),
						'desc' => __('Client link', 'mthemelocal')
					),
					'project_skills' => array(
						'std' => 'PHP,HTML,CSS,Illustrator,Photoshop',
						'type' => 'text',
						'label' => __('Skills', 'mthemelocal'),
						'desc' => __('Comma separated skill set', 'mthemelocal')
					),
					'project_link_title' => array(
						'std' => 'Project Link',
						'type' => 'text',
						'label' => __('Project link title', 'mthemelocal'),
						'desc' => __('Project link title', 'mthemelocal')
					),
					'project_link' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Project link', 'mthemelocal'),
						'desc' => __('Project link', 'mthemelocal')
					),
				),
				'shortcode' => '[portfolio_details alignment="{{alignment}}" project_title="{{project_title}}" project_detail_title="{{project_detail_title}}" project_client_title="{{project_client_title}}" project_client_link="{{project_client_link}}" project_client="{{project_client}}" project_skills="{{project_skills}}" project_link_title="{{project_link_title}}" project_link="{{project_link}}"]{{project_desc}}[/portfolio_details]',
				'popup_title' => __('Add Project Details', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['portfolio_details'];

			//create the block
			parent::__construct('em_portfolio_details', $block_options);
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
		
			mtheme_process_shortcode($shortcode,$encode=true);		
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}