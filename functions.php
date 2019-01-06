<?php
	
	
	if (function_exists('register_sidebar')) {
		register_sidebar(array(
			'name' => 'Sidebar Widgets',
			'id'   => 'sidebar-widgets',
			'description'   => 'These are widgets for the sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>'
		));
	}

	/* Function to add menu to the theme */
	function wp_register_theme_menu() {
		register_nav_menu( 'primary', 'Main Navigation' );
	}
	add_action( 'init', 'wp_register_theme_menu' );

	/* Function to check page/post has featured */
	function wp_theme_has_featured_posts() {
		return ! is_paged() && (bool) wp_theme_get_featured_posts();
	}

	/*To Add featured image*/
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'medium', 210, 210, array( 'left', 'top' ) ); // Hard crop left top

	/*Permalink by slug*/
	function get_permalink_by_slug( $slug ) {
		$obj = get_page_by_path( $slug );
		return get_permalink( $obj->ID );
	}

	/*Get page id by Slugs*/
	function get_ids_by_slugs($slugs) {
		 $slugs = preg_split("/,s?/", $slugs);
		 $ids = array();
		 foreach($slugs as $page_slug) {
			  $page = get_page_by_path($page_slug);
			  array_push($ids, $page->ID);
		 }
		 return implode(",", $ids);
	}

	// custom excerpt ellipses
	function new_excerpt_more( $more ) {
		return '<a href="'.get_permalink($post->ID).'" class="">'.'...'.'</a>';
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	// custom excerpt length
	function custom_excerpt_length( $length ) {
		return 55;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	// Numbered Pagination
	if ( !function_exists( 'wpex_pagination' ) ) {
		
		function wpex_pagination() {
			
			$prev_arrow = '&lt;';
			$next_arrow = '&gt;';
			
			global $wp_query;
			$total = $wp_query->max_num_pages;
			$big = 999999999; // need an unlikely integer
			if( $total > 1 )  {
				 if( !$current_page = get_query_var('paged') )
					 $current_page = 1;
				 if( get_option('permalink_structure') ) {
					 $format = 'page/%#%/';
				 } else {
					 $format = '&paged=%#%';
				 }
				echo paginate_links(array(
					'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'		=> $format,
					'current'		=> max( 1, get_query_var('paged') ),
					'total' 		=> $total,
					'mid_size'		=> 3,
					'type' 			=> 'list',
					'prev_text'		=> $prev_arrow,
					'next_text'		=> $next_arrow,
				 ) );
			}
		}
		
	}
	
	require_once( 'admin/theme-options.php' );
	
	
	add_filter( 'show_admin_bar', '__return_false' );
	
	
	//Template Redirect
	
		function demo_profile_redirect () {
		if ( is_page( 'login' ) && is_user_logged_in() ) {
			wp_redirect( home_url( '/profile/' ) );
			exit();
		}
	
		if ( is_page( 'profile' ) && !is_user_logged_in() ) {
			wp_redirect( home_url( '/login/' ) );
			exit();
		}
	}
	add_action( 'template_redirect', 'demo_profile_redirect' );
	
	//Login Landing page
	
		function demo_profile_init () {
		if ( current_user_can( 'subscriber' ) && !defined( 'DOING_AJAX' ) ) {
			wp_redirect( home_url('/profile/') );
			exit;
		}
	}
	//add_action( 'admin_init', 'demo_profile_init' );
	
	//Login Response 
	
	function demo_profile_login_init () {
		
		$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
	
		if ( isset( $_POST['wp-submit'] ) ) {
			$action = 'post-data';
		} else if ( isset( $_GET['reauth'] ) ) {
			$action = 'reauth';
		} else if ( isset($_GET['key']) ) {
			$action = 'resetpass-key';
		}
	
		
		if (
			$action == 'post-data'        ||            // don't mess with POST requests
			$action == 'reauth'           ||            // need to reauthorize
			$action == 'resetpass-key'    ||            // password recovery
			$action == 'logout'                         // user is logging out
		) {
			return;
		}
	
		wp_redirect( home_url( '/login/' ) );
		exit;
	}
	add_action('login_init', 'demo_profile_login_init');
	
	//Login Redirect
		function demo_profile_login_redirect ($redirect_to, $url, $user) {
			if ( !isset($user->errors) ) {
			return $redirect_to;
		}
				
		 wp_redirect( home_url('/login/') . '?action=failed');
		 //wp_redirect( home_url('/profile/') ); 
		
		
		exit;
	
	}
	add_filter('login_redirect', 'demo_profile_login_redirect', 60, 3);
	 
	//login Error 
	
	function demo_profile_login_error(){
		global $errors;
		$err_codes = $errors->get_error_codes();
	
		
		if ( in_array( 'invalid_username', $err_codes ) ) {
			$error = '<strong>ERROR</strong>: Invalid username.';
		}
	
		if ( in_array( 'incorrect_password', $err_codes ) ) {
			$error = '<strong>ERROR</strong>: The password you entered is incorrect.';
		}
		return $error;
	}
	
		
	add_filter( 'login_errors', 'demo_profile_login_error');	
	
	//Registration Redirect
	
	function my_registration_page_redirect()
	{
		global $pagenow;
	 
		if ( ( strtolower($pagenow) == 'wp-login.php') && ( strtolower( $_GET['action']) == 'register' ) ) {
			wp_redirect( home_url('/register'));
		}
	}
	 
	//add_filter( 'init', 'my_registration_page_redirect' );
	
	// registration form
	
	add_action( 'register_form', 'myplugin_add_registration_fields' );

function myplugin_add_registration_fields() {

    //Get and set any values already sent
    $user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
    ?>

    <p>
        <label for="user_extra"><?php _e( 'Extra Field', 'myplugin_textdomain' ) ?><br />
            <input type="text" name="user_extra" id="user_extra" class="input" value="<?php echo esc_attr( stripslashes( $user_extra ) ); ?>" size="25" /></label>
    </p>

    <?php
}
	
	
	// Registration validation
	
	function demo_profile_registration_redirect ($errors, $sanitized_user_login, $user_email) {

		if ( !empty( $errors->errors) ) {
			if ( isset( $errors->errors['username_exists'] ) ) {
	
				wp_redirect( home_url('/register/') . '?action=register&failed=username_exists' );
	
			} else if ( isset( $errors->errors['email_exists'] ) ) {
	
				wp_redirect( home_url('/register/') . '?action=register&failed=email_exists' );
	
			} else if ( isset( $errors->errors['empty_username'] ) || isset( $errors->errors['empty_email'] ) ) {
	
			   wp_redirect( home_url('/register/') . '?action=register&failed=empty' );
	
			} else if ( !empty( $errors->errors ) ) {
	
				wp_redirect( home_url('/register/') . '?action=register&failed=generic' );
	
			}
	
			 if (empty($_POST['user_login']) && $_POST['user_login'] == "" ) {
				//$errors->add( 'username_error', __( '<strong>ERROR</strong>: Invalid User name.', 'my_textdomain' ) );
			}
			if (empty($_POST['user_email']) && $_POST['user_email'] == "" ) {
				//$errors->add( 'useremail_error', __( '<strong>ERROR</strong>: Invalid Email.', 'my_textdomain' ) );
			}
	
		//return $errors;        
		}
	
		return $errors;
	
	}
	add_filter('registration_errors', 'demo_profile_registration_redirect', 10, 3);
	
	add_filter('wp_authenticate_user', 'myplugin_auth_login',10,2);
	$user = $_POST["log"];
	$password = $_POST["pwd"];
	function myplugin_auth_login ($user, $password) {
		global $errors;
		new WP_Error;
		 //do any extra validation stuff here
		 //return $user;
		    if (empty($_POST['log']) && $_POST['log'] == "" ) {
				$log_error->add( 'username_error', __( '<strong>ERROR</strong>: Invalid User name.', 'my_textdomain' ) );
			}
			if (empty($_POST['pwd']) && $_POST['pwd'] == "" ) {
				$log_error->add( 'useremail_error', __( '<strong>ERROR</strong>: Invalid Password.', 'my_textdomain' ) );
			}
			 
			return $log_error;
	}

	?>