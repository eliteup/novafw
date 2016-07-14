<?php 

/**
 * The Shortcode
 */
function novafw_heading_box_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => '',
				'subtitle' => '',
				'layout' =>''
			), $atts 
		) 
	);
	$description = ( $subtitle ) ? '<p class="heading-description">'.htmlspecialchars_decode($subtitle).'</p>' : false;
	$output = '
		<div class="eliteup-heading-box '.$layout.'">
              <div class="eliteup-heading-box-holder">
                <h3 class="heading-title">'. htmlspecialchars_decode($title) .'</h3>
                '.$description.'
              </div>
            </div>
	';
	
	return $output;
}
add_shortcode( 'thebear_heading_box', 'novafw_heading_box_shortcode' );

/**
 * The VC Functions
 */
function novafw_heading_box_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Heading Box", 'thebear'),
			"base" => "thebear_heading_box",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Subtitle", 'thebear'),
					"param_name" => "subtitle",
					'holder' => 'div',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Style", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Style 1' => '',
						'Style 2' => 'style_2'
					)
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_heading_box_shortcode_vc' );