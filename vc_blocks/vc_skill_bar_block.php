<?php 

/**
 * The Shortcode
 */
function novafw_skill_bar_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'amount' => ''
			), $atts
		) 
	);
	$output = '
		<div class="progress-title">'. $title .'<div class="progress-percent" data-progress="'. (int) esc_attr($amount) .'">'. (int) esc_attr($amount) .'%</div></div>
		<div class="progress">
		  <div class="progress-bar" data-progress="'. (int) esc_attr($amount) .'"></div>
		</div>
	';
	return $output;
}
add_shortcode( 'thebear_skill_bar_block', 'novafw_skill_bar_block_shortcode' );

/**
 * The VC Functions
 */
function novafw_skill_bar_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Skill Bar", 'thebear'),
			"base" => "thebear_skill_bar_block",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			'description' => 'Coloured bars for demonstrating your skills.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Skill Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Skill Amount", 'thebear'),
					"param_name" => "amount",
					'description' => 'Use a value between 0 - 100 only.'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_skill_bar_block_shortcode_vc' );