<?php 

/**
 * The Shortcode
 */
function novafw_resume_item_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'date' => '',
				'title' => '',
				'subtitle' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div>
		    <span class="pull-right fade-1-4">'. $date .'</span>
		    <h6 class="uppercase mb__0">'. $title .'</h6>
		    <span class="fade-half inline-block mb__24">'. $subtitle.'</span>
		    <hr class="fade-3-4">
		</div>
	';
	
	return $output;
}
add_shortcode( 'thebear_resume_item', 'novafw_resume_item_shortcode' );

/**
 * The VC Functions
 */
function novafw_resume_item_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Resume Item", 'thebear'),
			"base" => "thebear_resume_item",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Subtitle", 'thebear'),
					"param_name" => "subtitle",
					'holder' => 'div',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Date", 'thebear'),
					"param_name" => "date",
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_resume_item_shortcode_vc' );