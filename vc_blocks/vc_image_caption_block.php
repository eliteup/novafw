<?php 

/**
 * The Shortcode
 */
function novafw_image_caption_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'type' => 'hover-caption',
				'link' => '#'
			), $atts 
		) 
	);
	
	if( 'tile' == $type ){
		
		$output = '
			<div class="horizontal-tile">
			    <div class="tile-left">
			        <a href="'. esc_url($link) .'">
			            <div class="background-image-holder">
			                '. wp_get_attachment_image( $image, 'full', array('class' => 'background-image') ) .'
			            </div>
			        </a>
			    </div>
			    <div class="tile-right bg-secondary">
			        <div class="description">
			            '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			        </div>
			    </div>
			</div>
		';
		
	} else {
		
		$output = '
		    <div class="image-caption cast-shadow '. $type .'">
		        '. wp_get_attachment_image( $image, 'full' ) .'
		        <div class="caption">
		            '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		        </div>
		    </div>
	    ';
	    
	}
	
	return $output;
}
add_shortcode( 'thebear_image_caption', 'novafw_image_caption_shortcode' );

/**
 * The VC Functions
 */
function novafw_image_caption_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Image Caption", 'thebear'),
			"base" => "thebear_image_caption",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'thebear'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'thebear'),
					"param_name" => "type",
					"value" => array(
						'Caption on Hover' => 'hover-caption',
						'Static Caption' => 'mb-xs-32',
						'Image & Text Tile' => 'tile'
					)
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Caption Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for block (Tile Layout Only)", 'thebear'),
					"param_name" => "link"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_image_caption_shortcode_vc' );