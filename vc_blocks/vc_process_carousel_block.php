<?php

/**
 * The Shortcode
 */
function novafw_process_carousel_shortcode( $atts, $content = null ) {
	$output = '<div class="process-carousel">'. do_shortcode($content) .'</div>';
	
	if( substr_count( $content, '[thebear_process_carousel_content' ) > 1 ){
		$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function() { 
		
					jQuery(\'.process-carousel\').owlCarousel({
						nav: true,
						navText: ["","<i class=\'ti-angle-right\'>"],
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
add_shortcode( 'thebear_process_carousel', 'novafw_process_carousel_shortcode' );

/**
 * The Shortcode
 */
function novafw_process_carousel_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'background_style' => 'light-wrapper',
				'fullscreen' => 'fullscreen'
			), $atts 
		) 
	);
	
	$align = ( 'fullscreen' == $fullscreen ) ? 'v-align-transform' : false;
	
	$output = '
		<section class="'. $background_style .' '. $fullscreen .'">
		    <div class="col-md-9 content '. $align .'">
		        '. do_shortcode($content) .'
		    </div>
		</section>
	';

	return $output;
}
add_shortcode( 'thebear_process_carousel_content', 'novafw_process_carousel_content_shortcode' );

// Parent Element
function novafw_process_carousel_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Fullscreen Process Carousel' , 'thebear' ),
		    'base'                    => 'thebear_process_carousel',
		    'description'             => esc_html__( 'Create a fullwidth carousel of content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_process_carousel_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => false,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array()
		) 
	);
}
add_action( 'vc_before_init', 'novafw_process_carousel_shortcode_vc' );

// Nested Element
function novafw_process_carousel_content_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Fullscreen Process Carousel Content', 'thebear'),
		    'base'            => 'thebear_process_carousel_content',
		    'description'     => esc_html__( 'Fullscreen Process Carousel Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_process_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textarea_html",
		    		"heading" => esc_html__("Block Content", 'thebear'),
		    		"param_name" => "content",
		    		'holder' => 'div'
		    	),
		    	array(
		    		'type' => 'dropdown',
		    		'heading' => "Section Layout",
		    		'param_name' => 'background_style',
		    		'value' => array_flip(array(
		    			'light-wrapper'    => 'Standard Section (Light Background)',
		    			'bg-secondary'     => 'Standard Section (Dark Background)',
		    			'bg-dark'          => 'Standard Section (Black Background)',
		    			'bg-primary'       => 'Standard Section (Highlight Colour Background)',
		    		))
		    	),
		    	array(
		    		'type' => 'dropdown',
		    		'heading' => "Fullscreen height?",
		    		'param_name' => 'fullscreen',
		    		'value' => array_flip(array(
		    			'fullscreen' => 'fullscreen',
		    			'normal' => 'normal'
		    		))
		    	)
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_process_carousel_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_process_carousel extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_process_carousel_content extends WPBakeryShortCode {}
}