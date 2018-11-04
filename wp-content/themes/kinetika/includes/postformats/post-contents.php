<?php
get_template_part( 'includes/postformats/postformat-media' );
?>
<?php
$postformat = get_post_format();
if($postformat == "") {
	$postformat="standard";
}
?>
<div class="entry-content postformat_contents clearfix">
<?php
$show_readmore=false;
$blogpost_style= get_post_meta($post->ID, MTHEME . '_pagestyle', true);

	switch ($postformat) {
		case 'video':
			$postformat_icon = "feather-icon-play";
			break;
		case 'audio':
			$postformat_icon = "feather-icon-volume";
			break;
		case 'gallery':
			$postformat_icon = "feather-icon-layers";
			break;
		case 'quote':
			$postformat_icon = "feather-icon-speech-bubble";
			break;
		case 'link':
			$postformat_icon = "feather-icon-link";
			break;
		case 'aside':
			$postformat_icon = "feather-icon-align-justify";
			break;
		case 'image':
			$postformat_icon = "feather-icon-image";
			break;
		default:
			$postformat_icon ="feather-icon-paper";
			break;
	}

if (!is_single()) {
	switch ($postformat) {
		
		case 'aside':
		break;
		
		case 'link':
		$linked_to= get_post_meta($post->ID, MTHEME . '_meta_link', true);
		$fullcontent=true;		
		?>
		<div class="entry-post-title entry-post-title-only">
		<h2>
		<a class="postformat_<?php echo esc_attr($postformat); ?>" href="<?php echo esc_url($linked_to); ?>" title="<?php echo esc_attr($linked_to); ?>"><?php the_title(); ?></a>
		</h2>
		</div>
		<?php
		break;

		case 'quote':
		break;
		
		default:
		?>
		<div class="entry-post-title">
		<h2>
		<a class="postformat_<?php echo esc_attr($postformat); ?>" href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'mthemelocal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		</div>
		<?php
	}
}
?>
<?php

if ($postformat=="quote") {
		$quote=get_post_meta($post->ID, MTHEME . '_meta_quote', true);
		$quote_author=get_post_meta($post->ID, MTHEME . '_meta_quote_author', true);
		$fullcontent=true;
		if ($quote<>"") {
		?>
			<span class="quote_say"><i class="fa fa-quote-left"></i> <?php echo $quote; ?><i class="fa fa-quote-right"></i></span>
		<?php
			if ($quote_author != "") { ?>
				<span class="quote_author"><?php echo "&#8212;&nbsp;" . $quote_author; ?></span>
		<?php
			}
		}
}

if ( is_single() ) {
	$header_display_status = mtheme_get_page_header_status();
	//Avoid unset values
	echo '<div class="fullcontent-spacing">';
	echo '<article>';
	the_content();
	wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'mthemelocal' ), 'after' => '</div>' ) );
	echo '</article>';
	echo '</div>';
	
} else {

	if ( of_get_option('postformat_fullcontent') ) {
	
		echo '<div class="postsummary-spacing">';
		global $more;
		$more = 0;
		the_content();
		echo '</div>';
		
	} else {
		if ($postformat!="link" && $postformat!="aside" && $postformat!="quote"  ) {
			the_excerpt();
			$show_readmore=true;		
		} else {
			echo '<div class="postsummary-spacing">';
			global $more;
			$more = 0;
			the_content();
			echo '</div>';
			$show_readmore=false;		
		}
	}
}
?>
<?php
if ( $show_readmore==true ) {
echo '<div class="button-blog-continue">
	<a href="'.esc_url( get_the_permalink() ).'">
		<div class="mtheme-button animated pulse animation-action">' . esc_html( of_get_option ( 'read_more' ) ) . '</div>
	</a>
</div>';
}
?>
<?php
if ( is_single() ) {
	get_template_part('/includes/share','this');
}
?>
</div>
