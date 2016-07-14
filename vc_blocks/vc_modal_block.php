<?php 

/**
 * The Shortcode
 */
function novafw_modal_shortcode( $atts, $content = null ) {
	
	global $thebear_modal_content;
	
	extract( 
		shortcode_atts( 
			array(
				'image' => false,
				'fullscreen' => 'no',
				'button_text' => '',
				'icon' => '',
				'delay' => false,
				'align' => 'text-center',
				'cookie' => false,
				'manual_id' => false
			), $atts 
		) 
	);
	
	$id = ( $manual_id ) ? $manual_id : rand(0, 10000);
	
	$cookie = ( $cookie ) ? 'data-cookie="'. $cookie .'"' : false;

	$classes = ($image) ? 'image-bg overlay' : false;
	
	if( 'yes' == $fullscreen ){
		$classes .= ' fullscreen';	
	}
	
	if( 'fullwidth' == $fullscreen ){
		$classes .= ' fullscreen fullwidth';	
	}
	
	if( $delay ){
		$delay = 'data-time-delay="'. (int) $delay .'"';	
	}
	
	$output = '<div class="modal-container '. $align .'"><a class="btn btn-lg btn-modal" href="#" modal-link="'. esc_attr($id) .'"><i class="'. $icon .'"></i> '. $button_text .'</a>';
	
	$output2 = '<div class="thebear_modal text-center '. $classes .'" '. $delay .' '. esc_attr($cookie) .' modal-link="'. esc_attr($id) .'"><i class="ti-close close-modal"></i>';
	
	if($image){
		$output2 .= '
			<div class="background-image-holder">
				'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			</div>
		';	
	}
	
	if( 'fullwidth' == $fullscreen ){
		$output2 .= '<div class="thebear-modal-content">';
	}
	
	$output2 .= do_shortcode($content);
	
	if( 'fullwidth' == $fullscreen ){
		$output2 .= '</div>';
	}
	
	$output2 .= '</div>';
	
	$output .= '</div>';
	
	$thebear_modal_content .= $output2;
	
	return $output;
}
add_shortcode( 'thebear_modal', 'novafw_modal_shortcode' );

/**
 * The VC Functions
 */
function novafw_modal_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Modal' , 'thebear' ),
		    'base'                    => 'thebear_modal',
		    'description'             => esc_html__( 'Create a modal popup', 'thebear' ),
		    'as_parent'               => array('except' => 'thebear_tabs_content'),
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array(
		    	array(
		    		"type" => "novafw_icons",
		    		"heading" => esc_html__("Button Icon, click to choose", 'thebear'),
		    		"param_name" => "icon",
		    		"value" => $icons,
		    		'description' => 'Type "none" or leave blank to hide icons.'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Button Text", 'thebear'),
		    		"param_name" => "button_text"
		    	),
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Modal background image?", 'thebear'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Show Full Height?", 'thebear'),
		    		"param_name" => "fullscreen",
		    		"value" => array(
		    			'No' => 'no',
		    			'Yes' => 'yes',
		    			'FullHeight & FullWidth' => 'fullwidth'
		    		)
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Button Alignment", 'thebear'),
		    		"param_name" => "align",
		    		"value" => array(
		    			'Center' => 'text-center',
		    			'Left' => 'text-left',
		    			'Right' => 'text-right'
		    		)
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Delay Timer", 'thebear'),
		    		"param_name" => "delay",
		    		'description' => 'Leave blank for infinite delay (manual trigger only) enter milliseconds for automatic popup on timer, e.g: 2000'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Cookie Name", 'thebear'),
		    		"param_name" => "cookie",
		    		'description' => 'Set a plain text cookie name here to stop the delay popup if someone has already closed it.'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Set a manual ID for your modal (numeric)", 'thebear'),
		    		"param_name" => "manual_id",
		    		'description' => 'Not required, only set if you require a static ID for your modal, numeric only!'
		    	),
		    )
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_modal_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_modal extends WPBakeryShortCodesContainer {

    }
}