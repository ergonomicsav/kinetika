<?php
class mTheme_Login_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'mtheme_login_widget', 'description' => __( 'Login Widget', 'mthemelocal') );
		parent::__construct('login_widget',MTHEME_WIDGET_PREFIX .' - '. __('Login', 'mthemelocal'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Login', 'mthemelocal') : $instance['title'], $instance, $this->id_base);
		$login_greetings = $instance['login_greetings'];
		$username_label = $instance['username_label'];
		$password_label = $instance['password_label'];
		$rememberme_label = $instance['rememberme_label'];
		$submit_button_label = $instance['submit_button_label'];
		$logout_text = $instance['logout_text'];
		
		echo $before_widget;
		if ( $title)
			echo $before_title . $title . $after_title;
		
		?>

<?php
	if ( is_user_logged_in() ) { ?>
		<?php $current_user = wp_get_current_user(); ?>
		<div class="greetings_text">
		<strong>
		<?php echo $current_user->display_name; ?>!
		</strong>
		<p>
		<?php echo $login_greetings; ?>
		</p>
		</div>
		<a class="mtheme_login_widget-logout-text" href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>"><?php echo $logout_text; ?></a>
	<?php
	} else { ?>
<?php
$args = array(
	'echo'           => true,
	'redirect'       => home_url(), 
	'form_id'        => 'mtheme-loginform',
	'label_username' => $username_label,
	'label_password' => $password_label,
	'label_remember' => $rememberme_label,
	'label_log_in'   => $submit_button_label,
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'remember'       => true,
	'value_username' => NULL,
	'value_remember' => false
);
wp_login_form( $args );
?>
<?php
	}
?>
		
		<?php
		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['login_greetings'] = stripslashes_deep($new_instance['login_greetings']);
		$instance['username_label'] = stripslashes_deep($new_instance['username_label']);
		$instance['password_label'] = stripslashes_deep($new_instance['password_label']);
		$instance['rememberme_label'] = stripslashes_deep($new_instance['rememberme_label']);
		$instance['submit_button_label'] = stripslashes_deep($new_instance['submit_button_label']);
		$instance['logout_text'] = stripslashes_deep($new_instance['logout_text']);
		

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$login_greetings = isset($instance['login_greetings']) ? esc_attr($instance['login_greetings']) : '';
		$username_label = isset($instance['username_label']) ? esc_attr($instance['username_label']) : 'Username';
		$password_label = isset($instance['password_label']) ? esc_attr($instance['password_label']) : 'Password';
		$rememberme_label = isset($instance['rememberme_label']) ? esc_attr($instance['rememberme_label']) : 'Remember me';
		$submit_button_label = isset($instance['submit_button_label']) ? esc_attr($instance['submit_button_label']) : 'Login';
		$logout_text = isset($instance['logout_text']) ? esc_attr($instance['logout_text']) : 'Logout';


	?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('login_greetings'); ?>"><?php _e('Greetings text:', 'mthemelocal'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('login_greetings'); ?>" name="<?php echo $this->get_field_name('login_greetings'); ?>" type="text" ><?php echo esc_textarea($login_greetings); ?></textarea></p>

		<p><label for="<?php echo $this->get_field_id('username_label'); ?>"><?php _e('Username Label:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username_label'); ?>" name="<?php echo $this->get_field_name('username_label'); ?>" type="text" value="<?php echo esc_attr($username_label); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('password_label'); ?>"><?php _e('Password Label:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('password_label'); ?>" name="<?php echo $this->get_field_name('password_label'); ?>" type="text" value="<?php echo esc_attr($password_label); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('rememberme_label'); ?>"><?php _e('Remember me Label:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('rememberme_label'); ?>" name="<?php echo $this->get_field_name('rememberme_label'); ?>" type="text" value="<?php echo esc_attr($rememberme_label); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('submit_button_label'); ?>"><?php _e('Login Button Label:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('submit_button_label'); ?>" name="<?php echo $this->get_field_name('submit_button_label'); ?>" type="text" value="<?php echo esc_attr($submit_button_label); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('logout_text'); ?>"><?php _e('Log out Text:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('logout_text'); ?>" name="<?php echo $this->get_field_name('logout_text'); ?>" type="text" value="<?php echo esc_attr($logout_text); ?>" /></p>
		
<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("mTheme_Login_Widget");'));