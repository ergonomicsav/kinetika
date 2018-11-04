<?php
/** Works **/
if(!class_exists('em_works_carousel')) {
		class em_works_carousel extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {
			$the_list = get_terms('types');
			//print_r($the_list);
			// Pull all the Portfolio Categories into an array
			if ($the_list) {
				$portfolio_categories=array();
				//$portfolio_categories[0]="All the items";
				foreach($the_list as $key => $list) {
					if (isSet($list->slug)) {
						$portfolio_categories[$list->slug] = $list->name;
					}
				}
			} else {
				$portfolio_categories[0]="Portfolio Categories not found.";
			}
			$this->portfolio_store($portfolio_categories);

		}

		function portfolio_store($portfolio_categories) {
			$this->the_options['category_list'] = $portfolio_categories;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-loop',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Works Carousel','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Add Carousel based on Worktype Categories','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			/*-----------------------------------------------------------------------------------*/
			/*	Recent Works Carousel
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['workscarousel'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate a slideshow thumbnails carousel using your work type categories.', 'mthemelocal'),
				'params' => array(
					'work_categories' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Enter Work type slugs to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
					),
					'boxtitle' => array(
						'type' => 'select',
						'label' => __('Box Title', 'mthemelocal'),
						'desc' => __('Display title inside box on hover', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'columns' => array(
						'type' => 'select',
						'label' => __('Grid Columns', 'mthemelocal'),
						'desc' => __('No. of Grid Columns', 'mthemelocal'),
						'options' => array(
							'6' => '6',
							'5' => '5',
							'4' => '4',
							'3' => '3',
							'2' => '2',
							'1' => '1'
						)
					),
					'format' => array(
						'type' => 'select',
						'label' => __('Image orientation format', 'mthemelocal'),
						'desc' => __('Image orientation format', 'mthemelocal'),
						'options' => array(
							'landscape' => __('Landscape','mthemelocal'),
							'portrait' => __('Portrait','mthemelocal')
						)
					),
					'limit' => array(
						'std' => '-1',
						'type' => 'text',
						'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
						'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
					)
				),
				'shortcode' => '[workscarousel columns="{{columns}}" format="{{format}}" worktype_slug="{{work_categories}}" limit="{{limit}}" boxtitle="{{boxtitle}}"]',
				'popup_title' => __('Insert Works Carousel Shortcode', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['workscarousel'];

			//create the block
			parent::__construct('em_works_carousel', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}