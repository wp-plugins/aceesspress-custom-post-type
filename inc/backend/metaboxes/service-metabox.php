<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Meta box for Service post type 
 */
 
add_action('add_meta_boxes', 'ap_cpt_service_icon_field');
function  ap_cpt_service_icon_field() {
    add_meta_box(
         'ap_cpt_service_icon', // $id
         __( 'Service Icon Field', 'ap-cpt' ), // $title
         'ap_cpt_service_icon_callback', // $callback
         'services', // $page
         'normal', // $context
         'high'
    ); // $priority
 }
 
if( ! function_exists( 'ap_cpt_service_icon_callback' ) ):
function ap_cpt_service_icon_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_service_icon_nonce' );
    $ap_cpt_service_icon = get_post_meta( $post->ID, 'ap_cpt_service_icon', true );
    $ap_cpt_service_link = get_post_meta( $post->ID, 'ap_cpt_service_link', true );
?>
    <div class="service-icon-wrapper">
        <div class="service-single-field">
            <h4><span class="section-title"><?php _e( 'Service Icon', 'ap-cpt' );?></span></h4>
            <span class="section-desc"><em>Add your fontawesome icon. Example: <strong>fa-shield</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a></em></span>
            <span class="section-inputfield"><input type="text" name="ap_cpt_service_icon" value="<?php if( !empty( $ap_cpt_service_icon ) ){ echo $ap_cpt_service_icon ; }?>" /></span>
        </div>
        <div class="service-single-field">
            <h4><span class="section-title"><?php _e( 'Service Link', 'ap-cpt' );?></span></h4>
            <span class="section-desc"><em>Link your service by adding the URL.</em></span>
            <span class="section-inputfield"><input type="text" name="ap_cpt_service_link" value="<?php if( !empty( $ap_cpt_service_link ) ){ echo $ap_cpt_service_link ; }?>" /></span>
        </div>
    </div>
<?php
}
endif;

function ap_cpt_service_save_post( $post_id ) { 
    global $post; 

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_service_icon_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_service_icon_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
        
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }
    
    $ap_cpt_service_icon = get_post_meta($post->ID, 'ap_cpt_service_icon', true);
    $stz_service_icon = sanitize_text_field($_POST['ap_cpt_service_icon']);
    
    $ap_cpt_service_link = get_post_meta($post->ID, 'ap_cpt_service_link', true);
    $stz_service_link = esc_url($_POST['ap_cpt_service_link']);
    
    //update service icon
    if ( $stz_service_icon && '' == $stz_service_icon ){
        add_post_meta( $post_id, 'ap_cpt_service_icon', $stz_service_icon );
    }elseif ($stz_service_icon && $stz_service_icon != $ap_cpt_service_icon) {  
        update_post_meta($post_id, 'ap_cpt_service_icon', $stz_service_icon);  
    } elseif ('' == $stz_service_icon && $ap_cpt_service_icon) {  
        delete_post_meta($post_id,'ap_cpt_service_icon', $ap_cpt_service_icon);  
    }
    
    //update service link
    if ( $stz_service_link && '' == $stz_service_link ){
        add_post_meta( $post_id, 'ap_cpt_service_link', $stz_service_link );
    }elseif ($stz_service_link && $stz_service_link != $ap_cpt_service_link) {  
        update_post_meta($post_id, 'ap_cpt_service_link', $stz_service_link);  
    } elseif ('' == $stz_service_link && $ap_cpt_service_link) {  
        delete_post_meta($post_id,'ap_cpt_service_link', $ap_cpt_service_link);  
    }  
}
add_action('save_post', 'ap_cpt_service_save_post');