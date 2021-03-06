<?php

/**
 * The Shortcode
 */
function novafw_video_slider_shortcode( $atts, $content = null ) {
	
	global $novafw_height;
	$novafw_height = false;
	
	extract( 
		shortcode_atts( 
			array(
				'height' => ''
			), $atts 
		) 
	);
	
	$style = ( $height ) ? 'style="height: '. $height.';"' : '';
	$novafw_height = ( $height ) ? 'style="height: '. $height.';"' : '';
		
	$output = '<div class="slider-all-controls" '. $style .'><ul class="slides">'. do_shortcode($content) .'</ul></div>';
	
	return $output;
}
add_shortcode( 'thebear_video_slider', 'novafw_video_slider_shortcode' );

/**
 * The Shortcode
 */
function novafw_video_slider_content_shortcode( $atts, $content = null ) {
	
	global $novafw_height;

	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'mpfour' => '',
				'ogv' => '',
				'webm' => '',
			), $atts 
		) 
	);
	
	$image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') );
	
	$output = '
		<li class="vid-bg image-bg overlay pt__240 pb__240" '. $novafw_height .'>
		
		    <div class="background-image-holder">
		        '. $image .'
		    </div>
		    
		    <div class="fs-vid-background">
		        <video muted loop>
		            <source src="'. esc_url($webm) .'" type="video/webm">
		            <source src="'. esc_url($mpfour) .'" type="video/mp4">
		            <source src="'. esc_url($ogv) .'" type="video/ogg">	
		        </video>
		    </div>
		    
		    <div class="container">
		        <div class="row">
		            <div class="col-sm-12">
		                '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		            </div>
		        </div>
		    </div>
		    
		</li>
	';
		
	return $output;
}
add_shortcode( 'thebear_video_slider_content', 'novafw_video_slider_content_shortcode' );

// Parent Element
function novafw_video_slider_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Hero Video Slider' , 'thebear' ),
		    'base'                    => 'thebear_video_slider',
		    'description'             => esc_html__( 'Adds a Video Slider', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_video_slider_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Height, enter height value e.g: 600px", 'thebear'),
		    		"param_name" => "height",
		    		'description' => 'If left blank, the slider will be the default auto height. Please ensure your value is in px, e.g: 700px'
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_video_slider_shortcode_vc' );

// Nested Element
function novafw_video_slider_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Hero Video Slider Slide', 'thebear'),
		    'base'            => 'thebear_video_slider_content',
		    'description'     => esc_html__( 'A slide for the video slider.', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_video_slider'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Background Image (fallback for mobile devices)", 'thebear'),
	            	"param_name" => "image",
	            	'description' => 'Mobile devices deny background video from a device level, add a background image here so that mobile users get a static image fallback.'
	            ),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Slide Content", 'thebear'),
	            	"param_name" => "content",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Self Hosted Video .webm extension", 'thebear'),
	            	"param_name" => "webm",
	            	"description" => esc_html__('Please fill all extensions', 'thebear')
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Self Hosted Video .mp4 extension", 'thebear'),
	            	"param_name" => "mpfour",
	            	"description" => esc_html__('Please fill all extensions', 'thebear')
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Self Hosted Video .ogv extension", 'thebear'),
	            	"param_name" => "ogv",
	            	"description" => esc_html__('Please fill all extensions', 'thebear')
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_video_slider_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_video_slider extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_video_slider_content extends WPBakeryShortCode {

    }
}