<?php 

/**
 * The Shortcode
 */
function novafw_pricing_table_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'small' => '',
				'amount' => '$3',
				'button_text' => 'Select Plan',
				'button_url' => '',
				'layout' => 'basic'
			), $atts 
		) 
	);
	
	if( 'basic' == $layout ){
		$output = '
			<div class="pricing-table pt-1 text-center">
		        <H5 class="uppercase">'. htmlspecialchars_decode($title) .'</H5>
		        <span class="price">'. htmlspecialchars_decode($amount) .'</span>
		        <p class="lead">'. htmlspecialchars_decode($small) .'</p>
		        <a class="btn btn-filled btn-lg" href="'. esc_url($button_url) .'">'. htmlspecialchars_decode($button_text) .'</a>
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
	    ';
	} elseif( 'boxed' == $layout ) {
		$output = '
		    <div class="pricing-table pt-1 text-center boxed">
		        <H5 class="uppercase">'. htmlspecialchars_decode($title) .'</H5>
		        <span class="price">'. htmlspecialchars_decode($amount) .'</span>
		        <p class="lead">'. htmlspecialchars_decode($small) .'</p>
		        <a class="btn btn-filled btn-lg" href="'. esc_url($button_url) .'">'. htmlspecialchars_decode($button_text) .'</a>
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
	    ';
	} else {
		$output = '
			<div class="pricing-table pt-1 text-center emphasis">
			    <H5 class="uppercase">'. htmlspecialchars_decode($title) .'</H5>
			    <span class="price">'. htmlspecialchars_decode($amount) .'</span>
			    <p class="lead">'. htmlspecialchars_decode($small) .'</p>
			    <a class="btn btn-white btn-lg" href="'. esc_url($button_url) .'">'. htmlspecialchars_decode($button_text) .'</a>
			    '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	}
	
	return $output;
}
add_shortcode( 'thebear_pricing_table', 'novafw_pricing_table_shortcode' );

/**
 * The VC Functions
 */
function novafw_pricing_table_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Pricing Table", 'thebear'),
			"base" => "thebear_pricing_table",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			'description' => 'Add a pricing table to the page.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Amount", 'thebear'),
					"param_name" => "amount",
					"value" => '$3',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Small Text", 'thebear'),
					"param_name" => "small",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'thebear'),
					"param_name" => "button_text",
					"value" => 'Select Plan',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'thebear'),
					"param_name" => "button_url",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Basic Background' => 'basic',
						'Boxed Background' => 'boxed',
						'Emphasis Background' => 'emphasis'
					)
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Table Content", 'thebear'),
					"param_name" => "content"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_pricing_table_shortcode_vc' );