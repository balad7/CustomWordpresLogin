<?php
/**
 * Template Name: Reset-password
 *
 * @package WordPress
 * @subpackage Q
 */

get_header(); ?>


<h1 class="entry-title">Reset password</h1>

<form name="resetpasswordform" action="<?php echo site_url('wp-login.php?action=resetpass', 'login_post') ?>" method="post">
    <p class="form-password">
        <label for="pass1">New Password</label>
        <input class="text-input" name="pass1" type="password" id="pass1">
    </p>
    <p class="form-password">
        <label for="pass2">Confirm Password</label>
        <input class="text-input" name="pass2" type="password" id="pass2">
    </p>

    <input type="hidden" name="redirect_to" value="/login/?action=resetpass&success=1">
    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" value="Get New Password" /></p>
</form>
        

<?php get_footer(); ?>