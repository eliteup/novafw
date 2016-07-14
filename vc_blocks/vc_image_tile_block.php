<?php 

/**
 * The Shortcode
 */
function novafw_image_tile_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => '',
				'subtitle' => '',
				'url' => '',
				'layout' => 'default'
			), $atts 
		) 
	);
	
	if( 'default' == $layout ){
		
		$output = '
			<div class="masonry-item project">
			    <div class="image-tile inner-title text-center">
			        <a href="'. esc_url($url) .'">
			            '. wp_get_attachment_image( $image, 'grid' ) .'
			            <div class="title">
			                <h5 class="uppercase mb__0">'. htmlspecialchars_decode($title) .'</h5>
			                <span>'. htmlspecialchars_decode($subtitle) .'</span>
			            </div>
			        </a>
			    </div>
			</div>
		';
		
	} else {
		
		$output = '
			<div class="image-tile inner-title title-center text-center">
			    <a href="'. esc_url($url) .'">
			         '. wp_get_attachment_image( $image, 'full' ) .'
			        <div class="title">
			        	<h4 class="uppercase mb__0">'. htmlspecialchars_decode($title) .'</h4>
			        </div>
			    </a>
			</div>
		';
		
	}
	
	return $output;
}
add_shortcode( 'thebear_image_tile', 'novafw_image_tile_shortcode' );

/**
 * The VC Functions
 */
function novafw_image_tile_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Image Tile", 'thebear'),
			"base" => "thebear_image_tile",
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
					'description' => 'Default layout only.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for block", 'thebear'),
					"param_name" => "url"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Default' => 'default',
						'Vertical Center' => 'vertical'
					)
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_image_tile_shortcode_vc' );