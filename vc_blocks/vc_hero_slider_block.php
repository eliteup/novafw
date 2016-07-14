<?php

/**
 * The Shortcode
 */
function novafw_slider_shortcode( $atts, $content = null ) {
	
	global $novafw_height;
	$novafw_height = false;
	
	extract( 
		shortcode_atts( 
			array(
				'type' => 'standard',
				'parallax' => 'parallax',
				'height' => ''
			), $atts 
		) 
	);
	
	$fullscreen = ( $height ) ? '' : 'fullscreen';
	$style = ( $height ) ? 'style="height: '. $height.';"' : '';
	$novafw_height = ( $height ) ? 'style="height: '. $height.';"' : '';
	
	if( 'standard' == $type ){
		$output = '<section class="cover '. $fullscreen .' image-slider slider-all-controls controls-inside '. $parallax .'" '. $style .'><ul class="slides">'. do_shortcode($content) .'</ul></section>';
	} else {
		$output = '<section class="kenburns cover '. $fullscreen .' image-slider slider-arrow-controls controls-inside" '. $style .'><ul class="slides">'. do_shortcode($content) .'</ul></section>';
	}
	return $output;
}
add_shortcode( 'thebear_slider', 'novafw_slider_shortcode' );

/**
 * The Shortcode
 */
function novafw_slider_content_shortcode( $atts, $content = null ) {
	
	global $novafw_height;

	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'type' => 'standard',
				'title' => '',
				'subtitle' => '',
				'button_text' => '',
				'button_url' => ''
			), $atts 
		) 
	);
	
	$image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') );
	
	if( 'standard' == $type ) {
		
		$output = '<li class="overlay image-bg" '. $novafw_height .'>';
		
		if($image)
			$output .= '<div class="background-image-holder">'. $image .'</div>';
		
		$output .= '	
		    <div class="container v-align-transform">
		        <div class="row">
		            <div class="col-md-12 col-sm-12">
		                '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		            </div>
		        </div>
		    </div>
		';
		    
		$output .= '</li>';
		
	} else {
		
		$output = '<li class="image-bg pt-xs-240 pb-xs-240" '. $novafw_height .'>';
		
		    if($image)
		    	$output .= '<div class="background-image-holder">'. $image .'</div>';
		    
		$output .= '
		    <div class="align-bottom">
		        <div class="row">
		            <div class="col-sm-12">
		                <hr class="mb__24">
		            </div>
		        </div>
		        <div class="row">
		            <div class="col-md-3 col-sm-6 col-xs-12 text-center-xs mb-xs-24">
		                <h4 class="uppercase mb__0 bold">'. htmlspecialchars_decode($title) .'</h4>
		                <span>'. htmlspecialchars_decode($subtitle) .'</span>
		            </div>
		            <div class="col-md-4 hidden-sm hidden-xs">
		                '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		            </div>
		            <div class="col-md-5 col-sm-6 col-xs-12 text-right text-center-xs">
		                <a class="btn btn btn-white mt__16" href="'. esc_url($button_url) .'">'. $button_text .'</a>
		            </div>
		        </div>
		    </div>
		';
		
		$output .= '</li>';
		                    	
	}
	
	return $output;
}
add_shortcode( 'thebear_slider_content', 'novafw_slider_content_shortcode' );

// Parent Element
function novafw_slider_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Hero Slider' , 'thebear' ),
		    'base'                    => 'thebear_slider',
		    'description'             => esc_html__( 'Adds an Image Slider', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_slider_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params'          => array(
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Display type", 'thebear'),
		    		"param_name" => "type",
		    		"value" => array(
		    			'Standard Slider' => 'standard',
		    			'Zooming Slider' => 'ken'
		    		)
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Use Parallax Scrolling on this element?", 'thebear'),
		    		"param_name" => "parallax",
		    		"value" => array(
		    			'Parallax On' => 'parallax',
		    			'Parallax Off' => 'parallax-off'
		    		),
		    		'description' => 'Parallax scrolling works best when this element is at the top of a page, if it isn\'t, turn this off so the element displays at its best.'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Height, enter height value e.g: 600px", 'thebear'),
		    		"param_name" => "height",
		    		'description' => 'If left blank, the slider will be the fullheight of the screen. Please ensure your value is in px, e.g: 700px'
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_slider_shortcode_vc' );

// Nested Element
function novafw_slider_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Hero Slider Slide', 'thebear'),
		    'base'            => 'thebear_slider_content',
		    'description'     => esc_html__( 'A slide for the image slider.', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_slider'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Slide Background Image", 'thebear'),
	            	"param_name" => "image"
	            ),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Slide Content", 'thebear'),
	            	"param_name" => "content",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "dropdown",
	            	"heading" => esc_html__("Display type", 'thebear'),
	            	"param_name" => "type",
	            	"value" => array(
	            		'Standard Slider' => 'standard',
	            		'Zooming Slider' => 'ken'
	            	)
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Title (Zooming Only)", 'thebear'),
	            	"param_name" => "title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Subtitle (Zooming Only)", 'thebear'),
	            	"param_name" => "subtitle",
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Button Text (Zooming Only)", 'thebear'),
	            	"param_name" => "button_text",
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Button URL (Zooming Only)", 'thebear'),
	            	"param_name" => "button_url",
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_slider_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_slider extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_slider_content extends WPBakeryShortCode {

    }
}