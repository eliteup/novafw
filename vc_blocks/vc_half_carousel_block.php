<?php

/**
 * The Shortcode
 */
function novafw_half_carousel_shortcode( $atts, $content = null ) {
	$output = '<div class="half-carousel">'. do_shortcode($content) .'</div>';
	
	if( substr_count( $content, '[thebear_half_carousel_content' ) > 1 ){
		$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function() { 
		
					jQuery(\'.half-carousel\').owlCarousel({
						nav: true,
						navText: ["<i class=\'ti-angle-left\'>","<i class=\'ti-angle-right\'>"],
						dots: false,
						center: true,
						loop:true,
						responsive:{
					        0:{
					            items:1
					        }
					    }
					});
					
				});
			</script>
		';
	}
	
	return $output;
}
add_shortcode( 'thebear_half_carousel', 'novafw_half_carousel_shortcode' );

/**
 * The Shortcode
 */
function novafw_half_carousel_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'layout' => 'left'
			), $atts 
		) 
	);
	
	if( 'left' == $layout ){
		
		$output = '
			<section class="image-square right">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';
	
	} else {
		
		$output = '
			<section class="image-square left">
				<div class="col-md-6 content">
				    '. do_shortcode($content) .'
				</div>
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			</section>
		';
		
	}

	return $output;
}
add_shortcode( 'thebear_half_carousel_content', 'novafw_half_carousel_content_shortcode' );

// Parent Element
function novafw_half_carousel_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Half Text, Half Image Carousel' , 'thebear' ),
		    'base'                    => 'thebear_half_carousel',
		    'description'             => esc_html__( 'Create a fullwidth carousel of content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_half_carousel_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => false,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array()
		) 
	);
}
add_action( 'vc_before_init', 'novafw_half_carousel_shortcode_vc' );

// Nested Element
function novafw_half_carousel_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Half Text, Half Image Carousels Content', 'thebear'),
		    'base'            => 'thebear_half_carousel_content',
		    'description'     => esc_html__( 'Half Text, Half Image Carousel Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_half_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Block Image", 'thebear'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "textarea_html",
		    		"heading" => esc_html__("Block Content", 'thebear'),
		    		"param_name" => "content",
		    		'holder' => 'div'
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Image & Text Display Type", 'thebear'),
		    		"param_name" => "layout",
		    		"value" => array(
		    			'Image Right, Content Left' => 'left',
		    			'Image Left, Content Right' => 'right'
		    		)
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_half_carousel_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_half_carousel extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_half_carousel_content extends WPBakeryShortCode {}
}