<?php 

/**
 * The Shortcode
 */
function novafw_text_images_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'image1' => '',
				'image2' => '',
				'image1top' => '80px',
				'image1right' => '0px',
				'image2top' => '110px',
				'image2right' => '33%'
			), $atts 
		) 
	);
	
	$output = '
		<div class="row">
		    <div class="col-sm-6 col-sm-offset-1">
		        <div class="feature bordered restaurant-feature">
		            '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		        </div>
		    </div>
		    <div class="col-sm-5 restaurant-images">
		    	'. wp_get_attachment_image( $image1, 'full', 0, array('class' => 'relative', 'style' => 'right: '. $image1right .'; top: '. $image1top .';') ) .'
		    	'. wp_get_attachment_image( $image2, 'full', 0, array('class' => 'relative', 'style' => 'right: '. $image2right .'; top: '. $image2top .';') ) .'
		    </div>
		</div>
	';
	
	return $output;
}
add_shortcode( 'thebear_text_images', 'novafw_text_images_shortcode' );

/**
 * The VC Functions
 */
function novafw_text_images_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Text & Images", 'thebear'),
			"base" => "thebear_text_images",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image 1", 'thebear'),
					"param_name" => "image1"
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image 2", 'thebear'),
					"param_name" => "image2"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Image 1 Top Offset Distance", 'thebear'),
					"param_name" => "image1top",
					'description' => 'Image 1 Top Offset, use px or % e.g: 100px e.g: 33%',
					'value' => '80px'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Image 1 Right Offset Distance", 'thebear'),
					"param_name" => "image1right",
					'description' => 'Image 1 Right Offset, use px or % e.g: 100px e.g: 33%',
					'value' => '0px'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Image 2 Top Offset Distance", 'thebear'),
					"param_name" => "image2top",
					'description' => 'Image 2 Top Offset, use px or % e.g: 100px e.g: 33%',
					'value' => '110px'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Image 2 Right Offset Distance", 'thebear'),
					"param_name" => "image2right",
					'description' => 'Image 2 Right Offset, use px or % e.g: 100px e.g: 33%',
					'value' => '33%'
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_text_images_shortcode_vc' );