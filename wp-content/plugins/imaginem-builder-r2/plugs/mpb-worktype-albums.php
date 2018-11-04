<?php
/** Works Album **/
if(!class_exists('em_worktype_albums')) {
		class em_worktype_albums extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {
			global $portfolio_data;
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
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Worktype Albums','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Add a Worktype Grid','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			$mtheme_shortcodes['worktype_albums'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a slideshow of portfolio items', 'mthemelocal'),
				'params' => array(
					'worktype_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Enter Work type slugs to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
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
					'format' => array(
						'type' => 'select',
						'label' => __('Image orientation format', 'mthemelocal'),
						'desc' => __('Image orientation format', 'mthemelocal'),
						'options' => array(
							'landscape' => __('Landscape','mthemelocal'),
							'portrait' => __('Portrait','mthemelocal')
						)
					),
				    'worktype_icon' => array(
				        'std' => 'fa fa-th',
				        'type' => 'fontawesome-iconpicker',
				        'label' => __('Font Awesome icon', 'mthemelocal'),
				        'desc' => __('Select a fontawesome hover icon', 'mthemelocal'),
				        'options' => ''
				    ),
				    'item_count' => array(
				      'type' => 'select',
				      'label' => __('Display item count', 'mthemelocal'),
				      'desc' => __('Display item count', 'mthemelocal'),
				      'options' => array(
				        'true' => __('true','mthemelocal'),
				        'false' => __('false','mthemelocal')
				      )
				    ),
					'title' => array(
						'type' => 'select',
						'label' => __('Display title', 'mthemelocal'),
						'desc' => __('Display title', 'mthemelocal'),
						'options' => array(
							'true' => __('true','mthemelocal'),
							'false' => __('false','mthemelocal')
						)
					),
					'description' => array(
						'type' => 'select',
						'label' => __('Display description', 'mthemelocal'),
						'desc' => __('Display description', 'mthemelocal'),
						'options' => array(
							'true' => __('true','mthemelocal'),
							'false' => __('false','mthemelocal')
						)
					)
				),
				'shortcode' => '[worktype_albums worktype_slugs="{{worktype_slugs}}" columns="{{columns}}" format="{{format}}" worktype_icon="{{worktype_icon}}" title="{{title}}" description="{{description}}" item_count="{{item_count}}"]',
				'popup_title' => __('Display work type albums', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['worktype_albums'];

			//create the block
			parent::__construct('em_worktype_albums', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('isotope');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}