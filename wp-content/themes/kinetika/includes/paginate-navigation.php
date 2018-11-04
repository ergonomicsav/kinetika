<div class="clearfix"></div>
<!-- ADD Custom Numbered Pagination code. -->
<?php
if (isset($additional_loop)){
	echo mtheme_pagination($additional_loop->max_num_pages);
} else {
    echo mtheme_pagination();
}
if (function_exists("mtheme_pagination")) {
	} else {
	next_posts_link('&laquo;&laquo; Older Posts');
    previous_posts_link('Newer Posts &raquo;&raquo;');
	}
?>