<?php 

/**
 * The Shortcode
 */
function novafw_tour_date_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'date' => '',
				'button_text' => '',
				'button_url' => ''
			), $atts 
		) 
	);
	
	$output = '
		<ul class="tour-date">
			<li>
				<div class="overflow-hidden mb__16">
				
					<div class="col-sm-4">
						<h4 class="uppercase pt__8">'. $date .'</h4>
					</div>
					
					<div class="col-sm-4">
						'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
					</div>
				
					<div class="col-sm-4 text-right">
						<a class="btn btn-sm btn-white mt__8" href="'. esc_url($button_url) .'" target="_blank">'. $button_text .'</a>
					</div>
					
				</div>
				<hr class="fade-half mb__0">
			</li>
		</ul>
	';
	
	return $output;
}
add_shortcode( 'thebear_tour_date', 'novafw_tour_date_shortcode' );

/**
 * The VC Functions
 */
function novafw_tour_date_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Tour Date", 'thebear'),
			"base" => "thebear_tour_date",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Date", 'thebear'),
					"param_name" => "date",
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'thebear'),
					"param_name" => "button_text"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'thebear'),
					"param_name" => "button_url",
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_tour_date_shortcode_vc' );