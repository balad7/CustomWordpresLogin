<?php
/**
 * Template Name: Register
 *
 * @package WordPress
 * @subpackage Q
 */

get_header(); ?>


<h2>WP Registration</h2>
<?php
	if(isset($_GET["action"]) && isset($_GET["failed"]) && $_GET["failed"] == "username_exists"){
		echo "<h3>"."The username already exists"."</h3>";
	}
	if(isset($_GET["action"]) && isset($_GET["failed"]) && $_GET["failed"] == "email_exists"){
		echo "<h3>"."The email already exists"."</h3>";
	}
	if(isset($_GET["action"]) && isset($_GET["failed"]) && $_GET["failed"] == "empty"){
		echo "<h3>"."Please fill the details"."</h3>";
	}
	if(isset($_GET["action"]) && isset($_GET["failed"]) && $_GET["failed"] == "generic"){
		echo "<h3>"."Please provide correct details"."</h3>";
	}
?><br>

<form name="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
    <p>
        <label for="user_login">Username</label>
        <input type="text" name="user_login" value="">
    </p>
    <p>
        <label for="user_email">E-mail</label>
        <input type="text" name="user_email" id="user_email" value="">
    </p>

    <p id="reg_passmail">A password will be e-mailed to you.</p>

    
    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" value="Register" /></p>
</form>
<?php
do_action( 'register_form');
?>
        

<?php get_footer(); ?>