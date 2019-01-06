<?php
/**
 * Template Name: Forget-password
 *
 * @package WordPress
 * @subpackage Q
 */

get_header(); ?>


<h1>Password recovery</h1>

<form name="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
    <p>
        <label for="user_login">Username or E-mail:</label>
        <input type="text" name="user_login" id="user_login" value="">
    </p>

    <input type="hidden" name="redirect_to" value="/login/?action=forgot&success=1">
    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" value="Get New Password" /></p>
</form>
        

<?php get_footer(); ?>