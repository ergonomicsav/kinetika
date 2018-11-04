<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	get_template_part( 'includes/postformats/post-contents' );
	if ( !is_search() ) {
		get_template_part( 'includes/postformats/post-data' );
	}
?>
<?php
	// Author bio.
	if ( is_single() ) {
		$display_authorbio=false;
		if ( of_get_option('author_bio') ) {
			$display_authorbio=true;
		}
		$post_authorbio_status= get_post_meta($post->ID, MTHEME . '_post_authorbio', true);
		if ($post_authorbio_status == 'activate') {
			$display_authorbio=true;
		}
		if ($display_authorbio) {
			get_template_part( 'author-bio' );
		}
	}
?>
</div>