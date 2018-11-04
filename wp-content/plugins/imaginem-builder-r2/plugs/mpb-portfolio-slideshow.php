<?php
/** Portfolio Slideshow **/
if(!class_exists('em_portfolio_slideshow')) {
		class em_portfolio_slideshow extends AQ_Block {

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
				'pb_block_icon' => 'simpleicon-screen-desktop',
				'pb_block_icon_color' => '#0074D9',
				'name' => __('Portfolio Slideshow','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Add a Slideshow of Portfolio posts','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			/*-----------------------------------------------------------------------------------*/
			/*	Portfolio Slideshow
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['recent_portfolio_slideshow'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a slideshow of portfolio items', 'mthemelocal'),
				'params' => array(
			        'limit' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Limit posts', 'mthemelocal'),
			            'desc' => __('Limit the number of posts', 'mthemelocal'),
			        ),
					'worktype_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Enter Work type slugs to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
					),
					'autoplay' => array(
						'type' => 'select',
						'std' => 'false',
						'label' => __('Autoplay slideshow', 'mthemelocal'),
						'desc' => __('Autoplay slideshow', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'true' => __('Yes','mthemelocal')
						)
					),
					'transition' => array(
						'type' => 'select',
						'label' => __('Slideshow transition', 'mthemelocal'),
						'desc' => __('Slideshow transition', 'mthemelocal'),
						'options' => array(
							'fade' => __('fade','mthemelocal'),
							'slide' => __('slide','mthemelocal')
						)
					)
				),
				'shortcode' => '[recent_portfolio_slideshow autoplay="{{autoplay}}" limit="{{limit}}" worktype_slugs="{{worktype_slugs}}" transition="{{transition}}"]',
				'popup_title' => __('Add a slideshow of portfolio items', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['recent_portfolio_slideshow'];

			//create the block
			parent::__construct('em_portfolio_slideshow', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
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