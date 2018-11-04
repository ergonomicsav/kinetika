<?php
$media = mtheme_featured_image_link( get_the_id() );

$link = get_permalink();
$title = get_the_title();

$socialshare = array (
		'facebook' => array (
			'fa-facebook' => 'http://www.facebook.com/sharer.php?u='. esc_url( $link ) .'&t='. urlencode( $title )
			),
		'twitter' => array (
			'fa-twitter' => 'http://twitter.com/home?status='.urlencode( $title ).'+'. esc_url( $link )
			),
		'linkedin' => array (
			'fa-linkedin' => 'http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url( $link ).'&amp;title='.urlencode( $title )
			),
		'googleplus' => array (
			'fa-google-plus' => 'https://plus.google.com/share?url='. esc_url( $link )
			),
		'reddit' => array (
			'fa-reddit' => 'http://reddit.com/submit?url='.esc_url( $link ).'&amp;title='.urlencode( $title )
			),
		'tumblr' => array (
			'fa-tumblr' => 'http://www.tumblr.com/share/link?url='.esc_url( $link ).'&amp;name='.urlencode( $title ).'&amp;description='.urlencode( $title )
			),
		'pinterest' => array (
			'fa-pinterest' => 'http://pinterest.com/pin/create/bookmarklet/?media=' .esc_url( $media ) .'&url='. esc_url( $link ) .'&is_video=false&description='.urlencode( $title )
			),
		'email' => array (
			'fa-envelope' => 'mailto:email@address.com?subject=Interesting%20Link&body=' . $title . " " .  esc_url( $link )
			)
		);
?>
<ul class="portfolio-share">
<?php
foreach($socialshare as $key => $share){
  foreach( $share as $icon => $url){
    echo '<li class="share-this-'.$icon.'"><a title="Share" target="_blank" href="'. esc_url( $url ).'"><i class="fa '.$icon.'"></i></a></li>';
  }
}
?>
<li class="share-indicate"><?php _e('Share','mthemelocal'); ?></li>
</ul>