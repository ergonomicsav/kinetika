<?php
//Defined in Theme Framework functions
$featured_page = mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom( $featured_page );
if ( isSet($custom[ MTHEME . "_fullscreen_type"][0]) ) {
	$fullscreen_type = $custom[ MTHEME . "_fullscreen_type"][0];
}
if ( isSet($fullscreen_type) ) {
	$fullscreen_file = mtheme_get_fullscreen_file($fullscreen_type);
}
if ( isSet($fullscreen_file) ) {
	switch ($fullscreen_file) {
		case "photowall" :
			get_template_part('/includes/fullscreen/fullscreen', 'photowall' );
		break;

		case "kenburns" :
			get_template_part('/includes/fullscreen/fullscreen', 'kenburns' );
		break;

		case "particles" :
			get_template_part('/includes/fullscreen/fullscreen', 'particles' );
		break;

		case "fotorama" :
			get_template_part('/includes/fullscreen/fullscreen', 'fotorama' );
		break;

		case "carousel" :
			get_template_part('/includes/fullscreen/fullscreen', 'carousel' );
		break;

		case "coverphoto" :
			get_template_part('/includes/fullscreen/fullscreen', 'coverphoto' );
		break;
		
		case "supersized" :
			get_template_part('/includes/fullscreen/fullscreen', 'supersized' );
		break;
		
		case "video" :
			get_template_part('/includes/fullscreen/fullscreen', 'video' );
		break;

		case "revslider" :
			get_template_part('/includes/fullscreen/fullscreen', 'revslider' );
		break;
		default:
		break;
	}
} else {
	get_header();
	?>
	<div class="container-wrapper container-boxed"> 
		<div class="page-contents-wrap">
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-page-wrapper entry-content clearfix">
					<div class="title-container-wrap">
						<div class="title-container clearfix">
							<div class="entry-title">
			<?php
			echo _e('<h1>No Fullscreen post selected in theme options.</h1>','mthemelocal');
			?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	get_footer();
}
?>