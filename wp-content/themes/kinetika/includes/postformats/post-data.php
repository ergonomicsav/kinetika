<div class="postsummarywrap">

<?php
	$postformat = get_post_format();
	if($postformat == "") $postformat="standard";

$post_icon="";
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
?>
	<div class="datecomment clearfix">
	<?php
	if ( is_single() ) {
	?>
	<?php the_tags( '<div class="post-single-tags"><i class="feather-icon-tag"></i>', ' ', '</div>'); ?>
	<?php
	}
	?>
		<?php
		if ( !is_search() ) {
		?>
		<i class="<?php echo esc_attr($postformat_icon); ?>"></i>
		<span class="post-meta-category">
			<?php the_category(' / ') ?>
		</span>
		<?php
		}
		?>
		<span class="post-single-meta">
			<?php
			if ( is_single() ) {
			?>
			<span class="post-meta-time">
			<i class="feather-icon-clock"></i>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'mthemelocal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php
				echo '<span class="date updated">' . esc_attr( get_the_time() ); echo " , "; echo get_the_date(); echo '</span>';
			?>
			</a>
			</span>
			<?php
			}
		if ( !is_search() ) {
			$num_comments = get_comments_number();
			if ( comments_open() || $num_comments > 0 ) {
			?>
			<span class="post-meta-comment">
			<i class="feather-icon-speech-bubble"></i>
			<?php comments_popup_link('0', '1', '%'); ?>
			</span>
			<?php
			}
		}
		?>
		</span>
	</div>
</div>