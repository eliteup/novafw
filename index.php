<?php
/*
Plugin Name: Nova Framework
Plugin URI: http://www.eliteup.net
Description: Nova Framework - The Driving Force Behind Eliteup Themes
Version: 1.0.0
Author: Dzung Nova
Author URI: http://www.eliteup.net
*/	

/**
 * Plugin definitions
 */
define( 'NOVAFW_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'NOVAFW_FRAMEWORK_VERSION', '1.0.0');

/**
 * Styles & Scripts
 */
if(!( function_exists('novafw_framework_admin_load_scripts') )){
	function novafw_framework_admin_load_scripts(){
		wp_enqueue_style('novafw_framework_font_awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );
		wp_enqueue_style('novafw_framework_admin_css', plugins_url( '/css/novafw-framework-admin.css' , __FILE__ ) );
		wp_enqueue_script('novafw_framework_admin_js', plugins_url( '/js/novafw-framework-admin.js' , __FILE__ ) );
	}
	add_action('admin_enqueue_scripts', 'novafw_framework_admin_load_scripts', 200);
}

/**
 * Some items are definitely always loaded, these are those.
 */
/**
 * Grab all custom post type functions
 */
require_once( NOVAFW_FRAMEWORK_PATH . 'novafw_cpt.php' );

/**
 * Grab all generic functions
 */
require_once( NOVAFW_FRAMEWORK_PATH . 'novafw_functions.php' );

/**
 * Everything else in the framework is conditionally loaded depending on theme options.
 * Let's include all of that now.
 */
require_once( NOVAFW_FRAMEWORK_PATH . 'init.php' );
