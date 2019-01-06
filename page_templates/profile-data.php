<?php
/**
 * Template Name: Profile-data
 *
 * @package WordPress
 * @subpackage Q
 */


global $current_user, $wp_roles; ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="">
        <div class="entry-content entry">
            <?php //the_content(); ?>
            <?php if ( !is_user_logged_in() ) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p>
            <?php else : ?>
            
            <br><br>
            <a href="<?php echo site_url('profile');?>">Edit Profile</a><br><br>
                <table align="center"> 
                <tr>
                <th>First Name</th><td><?php the_author_meta( 'first_name', $current_user->ID ); ?></td></tr>
                  <tr><th>Last Name</th><td><?php the_author_meta( 'last_name', $current_user->ID ); ?></td></tr>
                  <tr><th>User Email</th><td><?php the_author_meta( 'user_email', $current_user->ID ); ?></td></tr>
                  <tr><th>Website</th><td><?php the_author_meta( 'user_url', $current_user->ID ); ?></td></tr>
                  <tr><th>Bio</th><td><?php the_author_meta( 'description', $current_user->ID ); ?></td>
                </tr>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>