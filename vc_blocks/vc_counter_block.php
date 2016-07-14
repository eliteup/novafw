<?php 

/**
 * The Shortcode
 */
function novafw_counter_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'to' => '1000'
			), $atts 
		) 
	);
	
	$output = '<span class="counter">'. $to .'</span>'. wpautop(do_shortcode(htmlspecialchars_decode($content)));
	
	return $output;
}
add_shortcode( 'thebear_counter', 'novafw_counter_shortcode' );

/**
 * The VC Functions
 */
function novafw_counter_shortcode_vc() {
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Fact Counter", 'thebear'),
			"base" => "thebear_counter",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("To Value", 'thebear'),
					"param_name" => "to",
					'value' => '1000'
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_counter_shortcode_vc' );