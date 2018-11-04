<?php
/** Blog Timeline **/
if(!class_exists('em_blog_timeline')) {
		class em_blog_timeline extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {

			$cat_slugs = array();
			$blog_cat_slugs_obj = get_categories();
			if ($blog_cat_slugs_obj) {
				foreach ($blog_cat_slugs_obj as $category) {
					$cat_slugs[$category->slug] = $category->slug;
				}
			} else {
				$cat_slugs[0]="Blog Categories not found.";
			}
			$this->category_store($cat_slugs);

		}

		function category_store($cat_slugs) {
			$this->the_options['category_list'] = $cat_slugs;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-clock',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Blog Timeline','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Posts','mthemelocal'),
				'desc' => __('Generate a timeline of blog posts','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			/*-----------------------------------------------------------------------------------*/
			/*	Recent Blog Post Grid
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['blogtimeline'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Blog Timeline.', 'mthemelocal'),
				'params' => array(
					'cat_slug' => array(
						'type' => 'category_list',
						'label' => __('Choose Category to list', 'mthemelocal'),
						'desc' => __('Choose Category to list', 'mthemelocal'),
						'options' => ''
					),
					'post_type' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Comma seperated post types or a single post type.', 'mthemelocal'),
						'desc' => __('audio,gallery,aside,quote,video,image,standard', 'mthemelocal'),
					),
					'title' => array(
						'type' => 'select',
						'label' => __('Display post title', 'mthemelocal'),
						'desc' => __('Display post title', 'mthemelocal'),
						'options' => array(
							'true' => 'Yes',
							'false' => 'No'
						)
					),
					'description' => array(
						'type' => 'select',
						'label' => __('Display Post description', 'mthemelocal'),
						'desc' => __('Display Post description', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'excerpt_length' => array(
						'std' => '15',
						'type' => 'text',
						'label' => __('Excerpt length', 'mthemelocal'),
						'desc' => __('Excerpt length', 'mthemelocal'),
					),
					'readmore_text' => array(
						'std' => __('Continue reading', 'mthemelocal'),
						'type' => 'text',
						'label' => __('Read more text', 'mthemelocal'),
						'desc' => __('Read more text', 'mthemelocal'),
					),
					'comments' => array(
						'type' => 'select',
						'label' => __('Display number of Comments', 'mthemelocal'),
						'desc' => __('Display number of Comments', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'date' => array(
						'type' => 'select',
						'label' => __('Display age of post', 'mthemelocal'),
						'desc' => __('Display age of post', 'mthemelocal'),
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
				'shortcode' => '[blogtimeline cat_slug="{{cat_slug}}" readmore_text="{{readmore_text}}" excerpt_length="{{excerpt_length}}" date="{{date}}" comments="{{comments}}" title="{{title}}" description="{{description}}" post_type="{{post_type}}" pagination="{{pagination}}" limit="{{limit}}"]',
				'popup_title' => __('Add Blog Timeline', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['blogtimeline'];

			//create the block
			parent::__construct('em_blog_timeline', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_Block'));
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
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}