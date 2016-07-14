<?php 

/**
 * The Shortcode
 */
function novafw_title_card_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => '',
				'subtitle' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div class="row">
		    <div class="col-sm-12">
		        <div class="pull-left">
		            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'inline-block image-small') ) .'
		        </div>
		        <div class="inline-block p__32 p__0-xs mb-xs-24">
		            <h3 class="uppercase mb__8">'. $title .'</h3>
		            <h5 class="uppercase">'. $subtitle.'</h5>
		        </div>
		    </div>
		</div>
	';
	
	return $output;
}
add_shortcode( 'thebear_title_card', 'novafw_title_card_shortcode' );

/**
 * The VC Functions
 */
function novafw_title_card_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Title Card", 'thebear'),
			"base" => "thebear_title_card",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'thebear'),
					"param_name" => "image"
				),
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
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_title_card_shortcode_vc' );