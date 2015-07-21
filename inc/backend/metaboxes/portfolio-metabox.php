<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Meta box for Project Post type
 */
 
add_action('add_meta_boxes', 'ap_cpt_project_details_field');
function  ap_cpt_project_details_field() {
    add_meta_box(
         'ap_cpt_project_details', // $id
         __( "Project Detials", 'ap-cpt' ), // $title
         'ap_cpt_project_details_callback', // $callback
         'portfolios', // $page
         'normal', // $context
         'high'
    ); // $priority
}

if( ! function_exists( 'ap_cpt_project_details_callback' ) ):
function ap_cpt_project_details_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_project_details_nonce' );
    $ap_cpt_project_custom_link = get_post_meta( $post->ID, 'ap_cpt_project_custom_link', true );
?>
    <div class="project-field-wrapper">
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( "Project Link", 'ap-cpt' );?></span></h4>
            <span class="section-desc"><em>Add custom link for project to another page, if you leave blank it will go post single page.</em></span>
            <span class="section-inputfield"><input type="text" name="ap_cpt_project_custom_link" value="<?php if( !empty( $ap_cpt_project_custom_link ) ){ echo $ap_cpt_project_custom_link ; }?>" /></span>
        </div>
    </div>
<?php
}
endif;

function ap_cpt_project_details_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_project_details_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_project_details_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
        
    if ( 'page' == $_POST[ 'post_type' ] ) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }
    
    $ap_cpt_project_custom_link = get_post_meta( $post->ID, 'ap_cpt_project_custom_link', true );
    $stz_project_custom_link = esc_url($_POST['ap_cpt_project_custom_link']);
    
    //update client custom link
    if ( $stz_project_custom_link && '' == $stz_project_custom_link ){
        add_post_meta( $post_id, 'ap_cpt_project_custom_link', $stz_project_custom_link );
    }elseif ($stz_project_custom_link && $stz_project_custom_link != $ap_cpt_project_custom_link) {  
        update_post_meta($post_id, 'ap_cpt_project_custom_link', $stz_project_custom_link);  
    } elseif ('' == $stz_project_custom_link && $ap_cpt_project_custom_link) {  
        delete_post_meta($post_id,'ap_cpt_project_custom_link', $ap_cpt_project_custom_link);  
    }
}
add_action('save_post', 'ap_cpt_project_details_save_post');