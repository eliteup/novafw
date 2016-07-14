<?php

/**
 * The Shortcode
 */
function novafw_masonry_services_shortcode( $atts, $content = null ) {
	$output = '<div class="row masonry masonryFlyIn">'. do_shortcode($content) .'</div>';
	return $output;
}
add_shortcode( 'thebear_masonry_services', 'novafw_masonry_services_shortcode' );

/**
 * The Shortcode
 */
function novafw_masonry_services_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'subtitle' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div class="col-md-4 col-sm-12 masonry-item mb__30">
		    <div class="feature boxed cast-shadow-light mb__0">
		        <h2 class=" color-primary mb__0">'. htmlspecialchars_decode($title) .'</h2>
		        <h6 class="uppercase color-primary">'. htmlspecialchars_decode($subtitle) .'</h6>
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
		</div>
	';

	return $output;
}
add_shortcode( 'thebear_masonry_services_content', 'novafw_masonry_services_content_shortcode' );

// Parent Element
function novafw_masonry_services_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Masonry Services' , 'thebear' ),
		    'base'                    => 'thebear_masonry_services',
		    'description'             => esc_html__( 'Create Tabbed Content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_masonry_services_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => false,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array()
		) 
	);
}
add_action( 'vc_before_init', 'novafw_masonry_services_shortcode_vc' );

// Nested Element
function novafw_masonry_services_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Masonry Services Content', 'thebear'),
		    'base'            => 'thebear_masonry_services_content',
		    'description'     => esc_html__( 'Tab Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_masonry_services'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'thebear'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Subtitle", 'thebear'),
		    		"param_name" => "subtitle",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Block Content", 'thebear'),
	            	"param_name" => "content"
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_masonry_services_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_masonry_services extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_masonry_services_content extends WPBakeryShortCode {

    }
}