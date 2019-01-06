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
	//Login
	
	




//1. Add a new form element...

add_action( 'register_form', 'Q_register_form' );
function Q_register_form() {

    $first_name = ( ! empty( $_POST['first_name'] ) ) ? sanitize_text_field( $_POST['first_name'] ) : '';
        
        ?>
        <p>
            <label for="first_name"><?php _e( 'First Name', 'mydomain' ) ?><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(  $first_name  ); ?>" size="25" /></label></p>
                <p>
            <label for="last_name"><?php _e( 'Last Name', 'mydomain' ) ?><br />
                <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr(  $last_name  ); ?>" size="25" /></label>
        </p>
         <!--<p >
            <label for="pass1"><?php //_e('Password *', 'mydomain'); ?><br /> 
            <input class="text-input" name="pass1" type="password" id="pass1" /></label>
        </p><!-- .form-password -->
         <!--<p >
            <label for="pass2"><?php //_e('Repeat Password *', 'mydomain'); ?><br />
            <input class="text-input" name="pass2" type="password" id="pass2" /></label>
        </p><!-- .form-password -->
       
        
        <?php
    }

    //2. Add validation. In this case, we make sure first_name is required.
	
   
	function Q_check_fields( $errors, $sanitized_user_login, $user_email ) {
     if ( empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
		$errors->add( 'demo_error', __( '<strong>ERROR</strong>: First name is required.', 'my_textdomain' ) );
	 }
	 if ( empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
		$errors->add( 'demo_error', __( '<strong>ERROR</strong>: Last name is required.', 'my_textdomain' ) );
	 }
	 /*if ( empty( $_POST['pass1'] ) && empty( $_POST['pass2'] ) ) {
		$errors->add( 'demo_error', __( '<strong>ERROR</strong>: Password is required.', 'my_textdomain' ) );
	 }
	 if (  $_POST['pass1'] != $_POST['pass2']  ) {
		$errors->add( 'demo_error', __( '<strong>ERROR</strong>: Password should be same.', 'my_textdomain' ) );
	 }*/
		return $errors;
}

add_filter( 'registration_errors', 'Q_check_fields', 10, 3 );

    

    //3. Finally, save our extra registration user meta.
    add_action( 'user_register', 'Q_user_register' );
    function Q_user_register( $user_id ) {
        if ( ! empty( $_POST['first_name'] ) ) {
            update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
        }
		if ( ! empty( $_POST['last_name'] ) ) {
            update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
        }
		 /*if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        	if ( $_POST['pass1'] == $_POST['pass2'] ){
           	 //wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
			  $user_name = $_POST['user_login'];
			  $user_email = $_POST['user_email'];
			  $random_password = $_POST['pass1'];
			  $user_id = username_exists( $_POST['user_login'] );
			
			if ( !$user_id and email_exists($_POST['user_email']) == false ) {
				
				 wp_create_user( $user_name, $random_password, $user_email );
			}
		 	}
		 }*/
    }

?>