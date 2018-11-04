<?php
//Get post format type
$postformat = get_post_format();
//If post format is null then it is a standard post type
if($postformat == "") $postformat="standard";
//get the post formats as per name basis
if ( !post_password_required() ) {
	get_template_part( 'includes/postformats/'.$postformat );
}
?>