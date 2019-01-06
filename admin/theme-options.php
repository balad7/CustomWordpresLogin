<?php
	function custom_get_default_options() {
		$options = array(
			'facebook'	=> '',
			'twitter'	=> '',
			'linkedin'	=> '',
			'copyright'	=> ''
		);
		return $options;
	}

	function custom_options_init() {
		$custom_options = get_option( 'theme_custom_options' );
	 
		// Are our options saved in the DB?
		if ( false === $custom_options ) {
			// If not, we'll save our default options
			$custom_options = custom_get_default_options();
			add_option( 'theme_custom_options', $custom_options );
		}
	 
		// In other case we don't need to update the DB
	}
	 
	// Initialize Theme options
	add_action( 'after_setup_theme', 'custom_options_init' );

	// Add "custom Options" link to the "Appearance" menu
	function custom_menu_options() {
		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'custom-settings', 'custom_admin_options_page');
	}
	// Load the Admin Options page
	add_action('admin_menu', 'custom_menu_options');
	 
	function custom_admin_options_page() { ?>
			<!-- 'wrap','submit','icon32','button-primary' and 'button-secondary' are classes
			for a good WP Admin Panel viewing and are predefined by WP CSS -->
			<div class="wrap">
				<div id="icon-themes" class="icon32"><br /></div>
				<h2><?php _e( 'Theme Options', 'custom' ); ?></h2>
	 
				<!-- If we have any error by submiting the form, they will appear here -->
				<?php settings_errors( 'custom-settings-errors' ); ?>
				<form id="form-custom-options" action="options.php" method="post" enctype="multipart/form-data"><?php
						settings_fields('theme_custom_options');
						do_settings_sections('custom'); ?>
	 
					<p class="submit">
						<input name="theme_custom_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'custom'); ?>" />
						<input name="theme_custom_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'custom'); ?>" />
					</p>
				</form>
			</div><?php
	}

	function custom_options_settings_init() {
		register_setting( 'theme_custom_options', 'theme_custom_options', 'custom_options_validate' );
	 
		add_settings_section('custom_settings_header', __( '', 'custom' ), 'custom_settings_header_text', 'custom');

		add_settings_field('custom_setting_facebook',  __( 'Facebook', 'custom' ), 'custom_setting_facebook_links', 'custom', 'custom_settings_header');

		add_settings_field('custom_setting_twitter',  __( 'Twitter', 'custom' ), 'custom_setting_twitter_links', 'custom', 'custom_settings_header');

		add_settings_field('custom_setting_linkedin',  __( 'LinkedIn', 'custom' ), 'custom_setting_linkedin_links', 'custom', 'custom_settings_header');

		add_settings_field('custom_setting_copyright',  __( 'Copyright Info', 'custom' ), 'custom_setting_copyright_links', 'custom', 'custom_settings_header');
	}
	add_action( 'admin_init', 'custom_options_settings_init' );
	 
	function custom_settings_header_text() { ?>
			<p><?php _e( 'Manage Options for EMZukunft Theme.', 'custom' ); ?></p><?php
	}
	
	function custom_options_validate( $input ) {

		$default_options = custom_get_default_options();
		$valid_input = $default_options;
		 
		$custom_options = get_option('theme_custom_options');
		 
		$submit = ! empty($input['submit']) ? true : false;
		$reset = ! empty($input['reset']) ? true : false;

		$facebook = ! empty($input['facebook']) ? true : false;
		$twitter = ! empty($input['twitter']) ? true : false;
		$linkedin = ! empty($input['linkedin']) ? true : false;
		$copyright = ! empty($input['copyright']) ? true : false;
		 
		if ( $submit ) {
			$valid_input['facebook'] = $input['facebook'];
			$valid_input['twitter'] = $input['twitter'];
			$valid_input['linkedin'] = $input['linkedin'];
			$valid_input['copyright'] = $input['copyright'];
		} elseif ( $reset ) {
			$valid_input['facebook'] = $default_options['facebook'];
			$valid_input['twitter'] = $default_options['twitter'];
			$valid_input['linkedin'] = $default_options['linkedin'];
			$valid_input['copyright'] = $default_options['copyright'];
		} elseif ( $facebook ) {
			$valid_input['facebook'] = '';
		} elseif ( $twitter ) {
			$valid_input['twitter'] = '';
		} elseif ( $linkedin) {
			$valid_input['linkedin'] = '';
		} elseif ( $googleplus ) {
			$valid_input['copyright'] = '';
		}
		 
		return $valid_input;
	}

	function custom_setting_facebook_links() { 
		$custom_options = get_option( 'theme_custom_options' ); ?>
		<input type="text" id="facebook" name="theme_custom_options[facebook]" value="<?php echo esc_url( $custom_options['facebook'] ); ?>" style="width:600px;" /><?php
	}

	function custom_setting_twitter_links() { 
		$custom_options = get_option( 'theme_custom_options' ); ?>
		<input type="text" id="twitter" name="theme_custom_options[twitter]" value="<?php echo esc_url( $custom_options['twitter'] ); ?>" style="width:600px;" /><?php
	}

	function custom_setting_linkedin_links() { 
		$custom_options = get_option( 'theme_custom_options' ); ?>
		<input type="text" id="linkedin" name="theme_custom_options[linkedin]" value="<?php echo esc_url( $custom_options['linkedin'] ); ?>" style="width:600px;" /><?php
	}

	function custom_setting_copyright_links() { 
		$custom_options = get_option( 'theme_custom_options' ); ?>
		<input type="text" id="copyright" name="theme_custom_options[copyright]" value="<?php echo  $custom_options['copyright']; ?>" style="width:600px;" /><?php
	}
?>