<?php 

/**
 * The Shortcode
 */
function novafw_call_to_action_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'url' => '',
				'button_text' => '',
				'target' => '_blank'
			), $atts 
		) 
	);
	
	$output = '
		<div class="row">
		    <div class="col-sm-12 text-center">
		        <h3 class="mb__0 inline-block p__32 p__0-xs">'. $title .'</h3>
		        <a class="btn btn-lg mb__0 mt-xs-24" href="'. esc_url($url) .'" target="'. esc_attr($target) .'">'. $button_text.'</a>
		    </div>
		</div>
	';

	return $output;
}
add_shortcode( 'thebear_call_to_action_block', 'novafw_call_to_action_block_shortcode' );

/**
 * The VC Functions
 */
function novafw_call_to_action_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Call To Action", 'thebear'),
			"base" => "thebear_call_to_action_block",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			'description' => 'Simple text and a button to grab attention',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'thebear'),
					"param_name" => "url"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'thebear'),
					"param_name" => "button_text"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Target", 'thebear'),
					"param_name" => "target",
					'value' => '_blank',
					'description' => 'For details, see here: http://www.w3schools.com/tags/att_link_target.asp'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_call_to_action_block_shortcode_vc' );