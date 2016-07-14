<?php

/**
 * The Shortcode
 */
function novafw_image_carousel_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'desktop' => '3',
				'desktop1199' => '3',
				'desktop980' => '3'
			), $atts 
		) 
	);
	
	$output = '
		<div class="image-carousel">'. do_shortcode($content) .'</div>
		<script type="text/javascript">
			jQuery(document).ready(function() { 
	
				jQuery(\'.image-carousel\').owlCarousel({
					nav: true,
					navText: ["<i class=\'ti-angle-left\'>","<i class=\'ti-angle-right\'>"],
					center: true,
					loop:true,
					responsive:{
				        0:{
				            items:1
				        },
				        980:{
				            items: '. (int) $desktop980 .'
				        },
				        1199:{
				            items: '. (int) $desktop1199 .'
				        },
				        1400:{
				            items: '. (int) $desktop .'
				        }
				    }
				});
				
			});
		</script>
	';
	return $output;
}
add_shortcode( 'thebear_image_carousel', 'novafw_image_carousel_shortcode' );

/**
 * The Shortcode
 */
function novafw_image_carousel_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div class="image-carousel-item overflow-hidden mb-xs-48">
		
			<div class="col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
				'. wp_get_attachment_image( $image, 'full' ) .'
			</div>
			
			<hr class="mb__48">
			
			<div class="text-holder">
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
			
		</div>
	';

	return $output;
}
add_shortcode( 'thebear_image_carousel_content', 'novafw_image_carousel_content_shortcode' );

// Parent Element
function novafw_image_carousel_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Image Carousel' , 'thebear' ),
		    'base'                    => 'thebear_image_carousel',
		    'description'             => esc_html__( 'Create An Image Carousel with Text Input', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_image_carousel_content'),
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Desktop # of Items", 'thebear'),
		    		'description' => '3, 5 or 7 only!',
		    		"param_name" => "desktop",
		    		'value' => '3'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Small Desktop # of Items", 'thebear'),
		    		'description' => '3, 5 or 7 only!',
		    		"param_name" => "desktop1199",
		    		'value' => '3'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Large Tablet # of Items", 'thebear'),
		    		'description' => '3, 5 or 7 only!',
		    		"param_name" => "desktop980",
		    		'value' => '3'
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'novafw_image_carousel_shortcode_vc' );

// Nested Element
function novafw_image_carousel_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Image Carousel Content', 'thebear'),
		    'base'            => 'thebear_image_carousel_content',
		    'description'     => esc_html__( 'Tab Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_image_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Image", 'thebear'),
		    		"param_name" => "image"
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
add_action( 'vc_before_init', 'novafw_image_carousel_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_image_carousel extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_image_carousel_content extends WPBakeryShortCode {}
}