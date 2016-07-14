<?php

/**
 * The Shortcode
 */
function novafw_tabs_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'button-tabs'
			), $atts 
		) 
	);
	
	$output = '
		<div class="tabbed-content '. esc_attr($type) .' text-center">
		    <ul class="tabs">
		        '. do_shortcode($content) .'
		    </ul>
		</div>
	';
	
	return $output;
}
add_shortcode( 'thebear_tabs', 'novafw_tabs_shortcode' );

/**
 * The Shortcode
 */
function novafw_tabs_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => ''
			), $atts 
		) 
	);
	
	$output = '
		<li>
		    <div class="tab-title">
		    	<i class="'. $icon .' icon"></i>
		        <span>'. htmlspecialchars_decode($title) .'</span>
		    </div>
		    <div class="tab-content">
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
		</li>
	';

	return $output;
}
add_shortcode( 'thebear_tabs_content', 'novafw_tabs_content_shortcode' );

// Parent Element
function novafw_tabs_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Tabs' , 'thebear' ),
		    'base'                    => 'thebear_tabs',
		    'description'             => esc_html__( 'Create Tabbed Content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_tabs_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array(
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Display type", 'thebear'),
		    		"param_name" => "type",
		    		"value" => array(
		    			'Button Tabs' => 'button-tabs',
		    			'Icon Tabs' => 'icon-tabs',
		    			'Text Tabs' => 'text-tabs',
		    			'Text Tabs, No Border' => 'text-tabs no-border',
		    			'Vertical Tabs' => 'button-tabs vertical'
		    		)
		    	)
		    )
		) 
	);
}
add_action( 'vc_before_init', 'novafw_tabs_shortcode_vc' );

// Nested Element
function novafw_tabs_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Tabs Content', 'thebear'),
		    'base'            => 'thebear_tabs_content',
		    'description'     => esc_html__( 'Tab Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_tabs'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'thebear'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Block Content", 'thebear'),
	            	"param_name" => "content"
	            ),
	            array(
	            	"type" => "novafw_icons",
	            	"heading" => esc_html__("Click an Icon to choose (Icon tabs only)", 'thebear'),
	            	"param_name" => "icon",
	            	"value" => $icons,
	            	'description' => 'Type "none" or leave blank to hide icons.'
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_tabs_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_tabs extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_tabs_content extends WPBakeryShortCode {

    }
}