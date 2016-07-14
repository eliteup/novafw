<?php

/**
 * The Shortcode
 */
function novafw_toggles_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'accordion-1 one-open'
			), $atts 
		) 
	);
	
	$output = '<ul class="accordion '. esc_attr($type) .'">'. do_shortcode($content) .'</ul>';
	$output = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
add_shortcode( 'thebear_toggles', 'novafw_toggles_shortcode' );

/**
 * The Shortcode
 */
function novafw_toggles_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'active' => 'no'
			), $atts
		) 
	);
	$uid = uniqid();
	if($active == 'yes') {
		$value = 'true';
		$collapse = 'in';
	}else {
		$value = 'false';
		$collapse = '';
	}
	$output = '
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading-'.$uid.'">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-'.$uid.'" aria-expanded="'.$value.'" aria-controls="collapse-'.$uid.'">'. htmlspecialchars_decode($title) .'</a>
				</h4>
			</div>
			<div id="collapse-'.$uid.'" class="panel-collapse collapse '.$collapse.'" role="tabpanel" aria-labelledby="heading-'.$uid.'">
				<div class="panel-body">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'<div class="clearfix"></div>				</div>
			</div>
		</div>
	';

	return $output;
}
add_shortcode( 'thebear_toggles_content', 'novafw_toggles_content_shortcode' );

// Parent Element
function novafw_toggles_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Toggles' , 'thebear' ),
		    'base'                    => 'thebear_toggles',
		    'description'             => esc_html__( 'Create Accordion Content', 'thebear' ),
		    'as_parent'               => array('only' => 'thebear_toggles_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
		    			'Buttons, One At A Time' => 'accordion-1 one-open',
		    			'Buttons, Multiple Open' => 'accordion-1',
		    			'Text, One At A Time' => 'accordion-2 one-open',
		    			'Text, Multiple Open' => 'accordion-2'
		    		)
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'novafw_toggles_shortcode_vc' );

// Nested Element
function novafw_toggles_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'            => esc_html__('Toggles Content', 'thebear'),
		    'base'            => 'thebear_toggles_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'thebear' ),
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'thebear_toggles'), // Use only|except attributes to limit parent (separate multiple values with comma)
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
					"type" => "dropdown",
					"heading" => esc_html__("Active ?", 'thebear'),
					"param_name" => "active",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes'
					)
				),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'novafw_toggles_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_toggles extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_thebear_toggles_content extends WPBakeryShortCode {

    }
}