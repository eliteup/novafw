<?php

/**
 * The Shortcode
 */
function novafw_big_social_shortcode( $atts, $content = null ) {
	$output = '<ul class="list-inline social-list mb__24 spread-children-large text-center">'. do_shortcode($content) .'</ul>';
	return $output;
}
add_shortcode( 'thebear_big_social', 'novafw_big_social_shortcode' );

/**
 * The Shortcode
 */
function novafw_big_social_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'url' => '',
				'icon' => ''
			), $atts 
		) 
	);
	
	$output = '
		<li class="fade-on-hover">
			<a href="'. esc_url($url) .'" target="_blank">
				<i class="icon icon-lg '. $icon .'"></i>
			</a>
		</li>
	';

	return $output;
}
add_shortcode( 'thebear_big_social_content', 'novafw_big_social_content_shortcode' );

// Parent Element
function novafw_big_social_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Big Social Icons' , 'thebear' ),
		    'base'                    => 'thebear_big_social',
		    'description'             => esc_html__( 'Create Big Social Icon Content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_big_social_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => false,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array()
		) 
	);
}
add_action( 'vc_before_init', 'novafw_big_social_shortcode_vc' );

// Nested Element
function novafw_big_social_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Big Social Icons Content', 'thebear'),
		    'base'            => 'thebear_big_social_content',
		    'description'     => esc_html__( 'Big Social Icon Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_big_social'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Icon URL", 'thebear'),
		    		"param_name" => "url",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "novafw_icons",
	            	"heading" => esc_html__("Click an Icon to choose", 'thebear'),
	            	"param_name" => "icon",
	            	"value" => $icons,
	            	'description' => 'Type "none" or leave blank to hide icons.'
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_big_social_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_big_social extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_big_social_content extends WPBakeryShortCode {

    }
}