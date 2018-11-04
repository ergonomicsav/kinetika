<?php
/** Blog List **/
if(!class_exists('em_blog_list_small')) {
		class em_blog_list_small extends AQ_Block {

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
				'pb_block_icon' => 'simpleicon-list',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Blog List Small','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Posts','mthemelocal'),
				'desc' => __('Display a blog in a small layout','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));


			/*-----------------------------------------------------------------------------------*/
			/*	Recent Blog List boxes
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['bloglistsmall'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display small bloglist.', 'mthemelocal'),
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
					'blogtimealign' => array(
						'type' => 'select',
						'label' => __('Blog Time Align', 'mthemelocal'),
						'desc' => __('Blog Time Align', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'top' => __('Top','mthemelocal')
						)
					),
					'limit' => array(
						'std' => '-1',
						'type' => 'text',
						'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
						'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
					)
				),
				'shortcode' => '[bloglistsmall blogtimealign="{{blogtimealign}}" cat_slug="{{cat_slug}}" post_type="{{post_type}}" limit="{{limit}}"]',
				'popup_title' => __('Display Recent Blog List in Small layout', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['bloglistsmall'];

			//create the block
			parent::__construct('em_blog_list_small', $block_options);
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

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');
			wp_enqueue_script ('jPlayerJS');
			wp_enqueue_style ('css_jplayer');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}