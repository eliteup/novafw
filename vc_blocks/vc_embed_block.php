<?php 

/**
 * The Shortcode
 */
function novafw_embed_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	$output = '<div class="embed-holder">'. wp_oembed_get($title) .'</div>';
	
	return $output;
}
add_shortcode( 'thebear_embed', 'novafw_embed_shortcode' );

/**
 * The VC Functions
 */
function novafw_embed_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Simple oEmbed", 'thebear'),
			"base" => "thebear_embed",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("oEmbed URL", 'thebear'),
					"param_name" => "title",
					'description' => 'Enter link to video <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">(Note: read more about available formats at WordPress codex page).</a>'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_embed_shortcode_vc' );