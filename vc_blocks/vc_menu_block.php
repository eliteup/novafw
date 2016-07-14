<?php 

/**
 * The Shortcode
 */
function novafw_menu_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'bg-white'
			), $atts 
		) 
	);
	
	$output = '
		<div class="feature bordered '. esc_attr($layout) .' restaurant-menu">
		    '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		</div>
	';

	return $output;
}
add_shortcode( 'thebear_menu', 'novafw_menu_shortcode' );

/**
 * The VC Functions
 */
function novafw_menu_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Restaurant Menu", 'thebear'),
			"base" => "thebear_menu",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Menu Background Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'White' => 'bg-white',
						'Dark' => 'bg-secondary',
						'Highlight Colour' => 'bg-primary'
					)
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_menu_shortcode_vc' );