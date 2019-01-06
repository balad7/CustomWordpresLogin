<?php
/**
 * Template Name: Profile-edit
 *
 * @package WordPress
 * @subpackage Q
 */


$wpdb->hide_errors(); nocache_headers(); global $userdata; get_currentuserinfo();

if(!empty($_POST['action'])){

    require_once(ABSPATH . 'wp-admin/includes/user.php');
    require_once(ABSPATH . WPINC . '/registration.php');

    check_admin_referer('update-profile_' . $user_ID);

    $errors = edit_user($user_ID);

    if ( is_wp_error( $errors ) ) {
        foreach( $errors->get_error_messages() as $message )
            $errmsg = "$message";
    }

    if($errmsg == '')
    {
        do_action('personal_options_update',$user_ID);
        $d_url = $_POST['dashboard_url'];
        wp_redirect( get_option("siteurl").'?page_id='.$post->ID.'&updated=true' );
    }
    else{
        $errmsg = '<div class="box-red">' . $errmsg . '</div>';
        $errcolor = 'style="background-color:#FFEBE8;border:1px solid #CC0000;"';

    }
}
get_header(); get_currentuserinfo(); ?>
    <div class="container" style="margin-top: 30px;">
    <div id="content" role="main" class="col-md-9">

        <form name="profile" action="" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('update-profile_' . $user_ID) ?>
            <input type="hidden" name="from" value="profile" />
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
            <input type="hidden" name="dashboard_url" value="<?php echo get_option("dashboard_url"); ?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />

                <?php if ( isset($_GET['updated']) ): $d_url = $_GET['d'];?>
                        <div class="alert alert-success">Din profil ble oppdatert</div>
                <?php elseif($errmsg!=""): ?>
                        <div class="alert alert-danger"><?php echo $errmsg;?></div>
                <?php endif;?>
            <style>
                .row {margin-bottom: 10px;}
            </style>
                    <h2>Update profile</h2>
            <div class="row">
                    <div class="col-md-4">
                        <label>Fornavn</label>
                        <input type="text" class=" form-control" name="first_name" id="first_name" value="<?php echo $userdata->first_name ?>" />
                    </div>
                    <div class="col-md-4">
                        <label>Etternavn</label>
                        <input type="text" name="last_name" class="mid2 form-control" id="last_name" value="<?php echo $userdata->last_name ?>" />
                        </div>
                     <div class="col-md-4">
                        <label>Epost <span style="color: #F00">*</span></label>
                        <input type="text" name="email" class="mid2 form-control" id="email" value="<?php echo $userdata->user_email ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nytt passord </label>
                        <input type="password" name="pass1" class="mid2 form-control" id="pass1" value="" />
                    </div>
                    <div class="col-md-6">
                        <label>Gjenta nytt passord </label>
                        <input type="password" name="pass2" class="mid2 form-control" id="pass2" value="" />
                    </div>
                    <div class="col-md-12">
                        <em><span style="color: #F00">*</span> påkrevde felter</em>
                    </div>
                </div>

                    <h3>Kontakt info</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Facebook URL</label>
                            <input type="text" name="facebook" class=" form-control" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $userdata->ID ) ); ?>" />
                        </div>
                        <div class="col-md-6">
                            <label>Twitter</label>
                            <input type="text" name="twitter" class=" form-control" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $userdata->ID ) ); ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>City</label>
                            <input type="text" name="city" class=" form-control" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $userdata->ID ) ); ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Fylke</label>
                            <select class="form-control" name="province" id="province">
                            <option value="Sør-Trøndelag" <?php selected( 'Sør-Trøndelag', get_the_author_meta( 'province', $user->ID ) ); ?>>Sør-Trøndelag</option>
                            <option value="Nord-Trøndelag" <?php selected( 'Nord-Trøndelag', get_the_author_meta( 'province', $user->ID ) ); ?>>Nord-Trøndelag</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Update" class="btn btn-info" />
                            <input type="hidden" name="action" value="update" />
                    </div>
                </div>
        </form>
    </div><!-- #content -->

    <div class="col-md-3">
        <?php //get_sidebar('right') ?>
    </div>
</div>
<?php get_footer() ?>