<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Plugin Name: AccessPress CPT
 * Plugin URI: https://accesspressthemes.com/wordpress-plugins/accesspress-cpt/
 * Description: A plugin to create new custom post type. 
 * Version: 1.0.0
 * Author: AccessPress Themes
 * Author URI: http://accesspressthemes.com
 * Text Domain: ap-cpt
 * Domain Path: /languages/
 * Network: false
 * License: GPL2
 */
/**
 * Declartion of necessary constants for plugin
 * */
if (!defined('CPT_IMAGE_DIR')) {
    define('CPT_IMAGE_DIR', plugin_dir_url(__FILE__) . 'images');
}
if (!defined('CPT_JS_DIR')) {
    define('CPT_JS_DIR', plugin_dir_url(__FILE__) . 'js');
}
if (!defined('CPT_CSS_DIR')) {
    define('CPT_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
}
if (!defined('CPT_VERSION')) {
    define('CPT_VERSION', '1.0.0');
}

if (!class_exists('CPT_Class')) {
    class CPT_Class {
        
        /**
         * Initializes the plugin functions 
         */
        function __construct() {
            add_action('init', array($this, 'plugin_text_domain')); //loads text domain for translation ready
            add_action('init', array($this, 'meta_boxes')); //starts the session
            add_action('init', array($this, 'ap_cpt_shortcodes')); //starts the session
            add_action('admin_enqueue_scripts', array($this, 'register_admin_assets')); //registers admin assests such as js and css
            add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets')); //registers js and css for frontend
            add_action( 'init', array($this, 'ap_cpt_setup_post_type' ) );
        }
        
        /**
         * Plugin Translation
         */
        function plugin_text_domain() {
            load_plugin_textdomain('ap-cpt', false, basename(dirname(__FILE__)) . '/languages/');
        }
        
        /**
         * Custom Post Types Register
         */
        function ap_cpt_setup_post_type() {
            include('inc/backend/post-types.php');
        }
        
        /**
         * Registering of backend js and css
         */
        function register_admin_assets() {
                wp_enqueue_style('cpt-admin-css', CPT_CSS_DIR . '/backend.css', array(), CPT_VERSION);
                wp_enqueue_script('cpt-admin-js', CPT_JS_DIR . '/backend.js', array('jquery'), CPT_VERSION);
        }
        
        /**
         * Registers Frontend Assets
         * */
        function register_frontend_assets() {
            wp_enqueue_style('ap-cpt-font-awesome',CPT_CSS_DIR.'/font-awesome/font-awesome.css',array(),CPT_VERSION);
            wp_enqueue_style('ap-cpt-frontend-css', CPT_CSS_DIR . '/frontend.css', array('ap-cpt-font-awesome'), CPT_VERSION);
        }
        
        /**
         * Load metaboxes
         */
         function meta_boxes() {
            include('inc/backend/metaboxes/service-metabox.php');
            include('inc/backend/metaboxes/products-metabox.php');
            include('inc/backend/metaboxes/team-member-metabox.php');
            include('inc/backend/metaboxes/testimonials-metabox.php');
            include('inc/backend/metaboxes/clients-metabox.php');
            include('inc/backend/metaboxes/portfolio-metabox.php');
         }
         
         /**
         * Adds Shortcode for service post type
         */
        function ap_cpt_shortcodes() {
            include('inc/frontend/shortcodes.php');
        }
    }
    
    $cpt_object = new CPT_Class(); //initialization of plugin
}