<?php
class mTheme_Portfolio_Related_List_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'mtheme_portfolio_related_widget', 'description' => __( 'Displays list of related portfolio projects', 'mthemelocal') );
		parent::__construct('portfolio_related_list',MTHEME_WIDGET_PREFIX .' - '. __('Portfolio Related List', 'mthemelocal'), $widget_ops);
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Related Projects', 'mthemelocal') : $instance['title'], $instance, $this->id_base);
		$text = $instance['text'];
		
		echo $before_widget;		
		?>
		
<?php
//for in the loop, display all "content", regardless of post_type,
//that have the same custom taxonomy (e.g. genre) terms as the current post
global $mtheme_portfolio_current_post,$post;
if (isSet( $mtheme_portfolio_current_post) ) :
$portfolio_post_ID=$mtheme_portfolio_current_post->ID;
//$backup = $post;  // backup the current object
$found_none = '<h2>No related posts found! ' . $portfolio_post_ID. '</h2>';
$taxonomy = 'types';//  e.g. post_tag, category, custom taxonomy
$param_type = 'types'; //  e.g. tag__in, category__in, but genre__in will NOT work
$post_types = get_post_types( array('public' => true), 'names' );
$tax_args=array('orderby' => 'none');

$tags = wp_get_post_terms( $mtheme_portfolio_current_post->ID , $taxonomy, $tax_args);

?>

<?php
if ($tags) {
  foreach ($tags as $tag) {
	//echo $tag->slug;
    $args=array(
      "$param_type" => $tag->slug,
      'post__not_in' => array($portfolio_post_ID),
      'post_type' => $post_types,
      'showposts'=>-1,
      'ignore_sticky_posts'=>1
    );
    $my_query = null;
    $my_query = new WP_Query($args);
	
    if( $my_query->have_posts() ) {
	
		if ( $title) echo $before_title . $title . $after_title;
		if(!empty($text)):?><p class="portfoliorelated_widget_about"><?php echo $text;?></p><?php endif;		
		?>
		
		<div class="grid-list-portfolio-related clearfix">
			<ul>
		
		<?php
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			
			<li>
			<?php
				if ( post_password_required() ) {
					$have_image_url= get_template_directory_uri() . '/images/icons/post_locked.png';
				} else {
					$have_image_url=false;
				}
				echo mtheme_display_post_image (
					$post->ID,
					$have_image_url,
					$link=true,
					$type="gridblock-tiny",
					$post->post_title,
					$class="portfolio-related-image" 
				);
			?>
			</li>
			<?php $found_none = '';
		endwhile;
    }
?>
	</ul>
</div>
<?php	
	break;
	
  }
}
if ($found_none) {
//echo $found_none;
}
//$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>
		
		<?php
		endif;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
	?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Intro text:', 'mthemelocal'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" ><?php echo $text; ?></textarea></p>
		
<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("mTheme_Portfolio_Related_List_Widget");'));