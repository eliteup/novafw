<?php 

/**
 * Grab our framework options as registered by the theme.
 * If novafw_framework_options isn't set then we'll pull a list of defaults.
 * By default everything is turned off.
 */
$defaults = array(
	'portfolio_post_type'   => '0',
	'team_post_type'        => '0',
	'client_post_type'      => '0',
	'testimonial_post_type' => '0',
	'faq_post_type'         => '0',
	'menu_post_type'        => '0',
	'class_post_type'       => '0',
	'mega_menu'             => '0',
	'aq_resizer'            => '0',
	'likes'                 => '0',
	'options'               => '0',
	'metaboxes'             => '0',
	'woocomposer'           => '0',
	'thebear_widgets'       => '0',
	'thebear_shortcodes'    => '0'
);
$framework_options = wp_parse_args( get_option('novafw_framework_options'), $defaults);

/**
 * Turn on the image resizer.
 * The resizer file has a class exists check to avoid conflicts
 */
if( '1' == $framework_options['aq_resizer'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'aq_resizer.php' );		
}

/**
 * Grab our custom metaboxes class
 */
if( '1' == $framework_options['metaboxes'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'metaboxes/init.php' );
}

/**
 * Grab novafw likes, make sure Zilla likes isn't installed though
 */
if(!( class_exists( 'novafwLikes' ) || class_exists( 'ZillaLikes' ) ) && '1' == $framework_options['likes'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'novafw-likes/likes.php' );
}

/**
 * Grab simple options class
 */
if( '1' == $framework_options['options'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'novafw_options.php' );
}

if( '1' == $framework_options['thebear_shortcodes'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'shortcodes/thebear-shortcodes.php' );
}

/**
 * Register appropriate widgets
 */
if( '1' == $framework_options['thebear_widgets'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'widgets/thebear-widgets.php' );
}
/**
 * Register Woocomposer class
 */
if( '1' == $framework_options['woocomposer'] ){
	require_once( NOVAFW_FRAMEWORK_PATH . 'woocomposer/woocomposer.php' );
}
/**
 * Register Portfolio Post Type
 */
if( '1' == $framework_options['portfolio_post_type'] ){
	add_action( 'init', 'novafw_framework_register_portfolio', 10 );
	add_action( 'init', 'novafw_framework_create_portfolio_taxonomies', 10  );
}

/**
 * Register Team Post Type
 */
if( '1' == $framework_options['team_post_type'] ){
	add_action( 'init', 'novafw_framework_register_team', 10  );
	add_action( 'init', 'novafw_framework_create_team_taxonomies', 10  );
}

/**
 * Register Client Post Type
 */
if( '1' == $framework_options['client_post_type'] ){
	add_action( 'init', 'novafw_framework_register_client', 10  );
	add_action( 'init', 'novafw_framework_create_client_taxonomies', 10  );
}

/**
 * Register Testimonial Post Type
 */
if( '1' == $framework_options['testimonial_post_type'] ){
	add_action( 'init', 'novafw_framework_register_testimonial', 10  );
	add_action( 'init', 'novafw_framework_create_testimonial_taxonomies', 10  );
}

/**
 * Register faq Post Type
 */
if( '1' == $framework_options['faq_post_type'] ){
	add_action( 'init', 'novafw_framework_register_faq', 10  );
	add_action( 'init', 'novafw_framework_create_faq_taxonomies', 10  );
}

/**
 * Register Menu Post Type
 */
if( '1' == $framework_options['menu_post_type'] ){
	add_action( 'init', 'novafw_framework_register_menu', 10  );
	add_action( 'init', 'novafw_framework_create_menu_taxonomies', 10  );
}

/**
 * Register Class Post Type
 */
if( '1' == $framework_options['class_post_type'] ){
	add_action( 'init', 'novafw_framework_register_class', 10  );
	add_action( 'init', 'novafw_framework_create_class_taxonomies', 10  );
}

/**
 * Register Mega Menu Post Type
 */
if( '1' == $framework_options['mega_menu'] ){
	add_action( 'init', 'novafw_framework_register_mega_menu', 10  );
}