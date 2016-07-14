<?php 

/**
 * The Shortcode
 */
function novafw_twitter_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'layout' => 'carousel',
				'amount' => '5'
			), $atts 
		) 
	);
	
	if( 'carousel' == $layout ){
		$output = '
			<div class="text-center">
			    <i class="ti-twitter-alt icon icon-lg color-primary mb__40 mb-xs-24"></i>
			    <div class="twitter-feed tweets-slider large">
			        <div class="tweets-feed" data-widget-id="'. esc_attr($title) .'" data-amount="'. esc_attr($amount) .'">
			        </div>
			    </div>
			</div>
		';
	} else {
		$output = '
			<div class="row">
				<div class="twitter-feed thirds">
				    <div class="tweets-feed" data-widget-id="'. esc_attr($title) .'" data-amount="'. esc_attr($amount) .'">
				    </div>
				</div>
			</div>
		';
	}
	
	return $output;
}
add_shortcode( 'thebear_twitter', 'novafw_twitter_shortcode' );

/**
 * The VC Functions
 */
function novafw_twitter_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Twitter Feed", 'thebear'),
			"base" => "thebear_twitter",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Twitter User ID", 'thebear'),
					"param_name" => "title",
					"description" => "Twitter Widget ID <code>e.g: 492085717044981760</code><br /><br />
					<strong>Note!</strong> You need to generate this ID from your account, do this by going to the 'Settings' page of your Twitter account and clicking 'Widgets'. Click 'Create New' and then 'Create Widget'. One done, go back to the 'Widgets' page and click 'Edit' on your newly created widget. From here you need to copy the widget id out of the url bar. The widget id is the long numerical string after /widgets/ and before /edit.",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Twitter Carousel' => 'carousel',
						'Tweets Grid' => 'grid'
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Load how many tweets? Numeric Only.", 'thebear'),
					"param_name" => "amount",
					'value' => '5',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_twitter_shortcode_vc' );