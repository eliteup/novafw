<?php 

/**
 * The Shortcode
 */
function novafw_instagram_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'layout' => 'standard',
				'method' => 'getUserFeed',
				'max' => '12'
			), $atts 
		) 
	);
	
	if( 'standard' == $layout ){
		$output = '<div class="instafeed grid-gallery" data-max="'. esc_attr($max) .'" data-user-name="'. esc_attr($title) .'" data-method="'. esc_attr($method) .'"><ul></ul></div>';
	} elseif( 'full' == $layout ) {
		$output = '<div class="instafeed grid-gallery gapless" data-max="'. esc_attr($max) .'" data-user-name="'. esc_attr($title) .'" data-method="'. esc_attr($method) .'"><ul class="fade-on-hover"></ul></div>';
	} else {
		$output = '
			<div class="row">
			    <div class="col-sm-6">
			        <div class="instafeed grid-gallery mt__80 mt-xs-0 col-md-push-2 relative" data-max="'. esc_attr($max) .'" data-user-name="'. esc_attr($title) .'" data-method="'. esc_attr($method) .'">
			            <ul></ul>
			        </div>
			    </div>
			    <div class="col-sm-6">
			        <div class="feature bordered text-center">
			        	'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			        </div>
			    </div>
			</div>
		';
	}
	
	return $output;
}
add_shortcode( 'thebear_instagram', 'novafw_instagram_shortcode' );

/**
 * The VC Functions
 */
function novafw_instagram_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Instagram Feed", 'thebear'),
			"base" => "thebear_instagram",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Instagram Username / Hashtag (do not add #)", 'thebear'),
					"param_name" => "title",
					"description" => 'e.g: funsizeco',
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content (Restaurant Layout Only)", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Standard Grid' => 'standard',
						'Restaurant Grid' => 'restaurant',
						'FullWidth' => 'full'
					)
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Instagram images source", 'thebear'),
					"param_name" => "method",
					"value" => array(
						'User Images' => 'getUserFeed',
						'Hashtag Images' => 'getRecentTagged'
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Load how many images? Numeric Only.", 'thebear'),
					"param_name" => "max",
					'value' => '12',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_instagram_shortcode_vc' );