<?php
/**
 * Template Name: Login
 *
 * @package WordPress
 * @subpackage Q
 */

get_header(); ?>
     <h2>WP Login</h2>
	 <?php	
     global $error;
     //new WP_Error;
	 print_r($log_error);
	  if (is_wp_error( $log_error ))
		{ 
			foreach ( $log_error->get_error_messages() as $error )
			{
				 $signUpError='<p><strong>ERROR</strong>: '.$error . '<br /></p>';
			} 
		}
		
     			
	 if($_GET["action"] == "failed"){
		 
		 echo "<h3>"."Please provide correct details"."</h3>";
		 //echo $signUpError;
		 }?><br>
    <?php wp_login_form(); ?>

<?php get_footer(); ?>

