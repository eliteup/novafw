<?php 

/**
 * The Shortcode
 */
function novafw_flickr_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'user' => '8826848@N03',
				'album' => '72157633398893288'
			), $atts 
		) 
	);
	
	$output = '
		<div class="row">
		    <div class="col-sm-12">
		        <ul class="flickr-feed masonry" data-user-id="'. esc_attr($user) .'" data-album-id="'. esc_attr($album) .'"></ul>
		   </div>
		</div>
	';
	
	return $output;
}
add_shortcode( 'thebear_flickr', 'novafw_flickr_shortcode' );

/**
 * The VC Functions
 */
function novafw_flickr_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Flickr Feed", 'thebear'),
			"base" => "thebear_flickr",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Flickr User ID", 'thebear'),
					"param_name" => "user",
					"description" => 'Get ID from here: http://idgettr.com e.g: 8826848@N03',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Flickr Album ID", 'thebear'),
					"param_name" => "album",
					"description" => 'Here\'s how to get the album ID: https://weblizar.com/get-flickr-album-id/ e.g: 72157633398893288',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_flickr_shortcode_vc' );