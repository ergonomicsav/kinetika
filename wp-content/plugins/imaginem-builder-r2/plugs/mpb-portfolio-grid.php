<?php
/** Portfolio Grid **/
if(!class_exists('em_portfolio_grid')) {
		class em_portfolio_grid extends AQ_Block {

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
				'pb_block_icon' => 'simpleicon-grid',
				'pb_block_icon_color' => '#836953',
				'name' => __('Portfolio Grid','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Generate a Portfolio Grid','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			$mtheme_shortcodes['portfoliogrid'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('A Grid based list of portfolio items.', 'mthemelocal'),
				'params' => array(
					'worktype_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Choose Work types to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
					),
					'type' => array(
						'type' => 'select',
						'label' => __('Type of Portfolio list', 'mthemelocal'),
						'desc' => __('Type of Portfolio list', 'mthemelocal'),
						'options' => array(
							'no-filter' => __('No Filter', 'mthemelocal'),
							'filter' => __('Filterable', 'mthemelocal'),
							'ajax' => __('Ajax Filterable', 'mthemelocal'),
						)
					),
					'format' => array(
						'type' => 'select',
						'label' => __('Image orientation format', 'mthemelocal'),
						'desc' => __('Image orientation format', 'mthemelocal'),
						'options' => array(
							'landscape' => __('Landscape','mthemelocal'),
							'portrait' => __('Portrait','mthemelocal'),
							'masonary' => __('Masonary','mthemelocal')
						)
					),
					'gutter' => array(
						'type' => 'select',
						'label' => __('Gutter Space', 'mthemelocal'),
						'desc' => __('Gutter Space', 'mthemelocal'),
						'options' => array(
							'spaced' => __('Spaced','mthemelocal'),
							'nospace' => __('No Space','mthemelocal')
						)
					),
					'columns' => array(
						'type' => 'select',
						'label' => __('Grid Columns', 'mthemelocal'),
						'desc' => __('No. of Grid Columns', 'mthemelocal'),
						'options' => array(
							'4' => '4',
							'3' => '3',
							'2' => '2',
							'1' => '1'
						)
					),
					'boxtitle' => array(
						'type' => 'select',
						'label' => __('Box title and category', 'mthemelocal'),
						'desc' => __('Box title and category', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'true' => __('Yes','mthemelocal')
						)
					),
					'title' => array(
						'type' => 'select',
						'label' => __('Display post title', 'mthemelocal'),
						'desc' => __('Display post title', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'desc' => array(
						'type' => 'select',
						'label' => __('Display Post description', 'mthemelocal'),
						'desc' => __('Display Post description', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'limit' => array(
						'std' => '-1',
						'type' => 'text',
						'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
						'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
					),
					'pagination' => array(
						'type' => 'select',
						'label' => __('Generate Pagination', 'mthemelocal'),
						'desc' => __('Generate Pagination', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					)
				),
				'shortcode' => '[portfoliogrid type="{{type}}" boxtitle="{{boxtitle}}" gutter="{{gutter}}" columns="{{columns}}" format="{{format}}" worktype_slugs="{{worktype_slugs}}" title="{{title}}" desc="{{desc}}" pagination="{{pagination}}" limit="{{limit}}"]',
				'popup_title' => __('Insert Portfolio Grid Shortcode', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['portfoliogrid'];

			//create the block
			parent::__construct('em_portfolio_grid', $block_options);
			
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('isotope');
			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		function mtheme_enqueue_em_portfolio_grid(){
			//Any script registers go here
		}

	}
}