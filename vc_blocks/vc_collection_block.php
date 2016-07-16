<?php 

/**
 * The Shortcode
 */
function novafw_collection_banner_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => '',
				'sub_title' => '30',
				'layout' => 'standard',
				'link' => '',
				'link_title' => '',
				'target' => '_self'
			), $atts 
		) 
	);
	$image_url = wp_get_attachment_image_src( $image, 'full' );
	$image_url = $image_url[0];

	$before = ( $link ) ? '<a href="'. esc_url($link) .'" target="'. esc_attr($target) .'">' : false;
	$after = ( $link ) ? '</a>' : false;
	$height_style = ( $banner_height ) ? 'height:'.esc_attr($banner_height).'px' : '';
	
	if( 'standard' == $layout ){

		$output = '<div class="eliteup-banner" style="margin-bottom:'.esc_attr($margin_bottom).'px; '.$height_style.'">
                  '.$before.'
                    <span class="banner_image" style="background-image: url('.$image_url.');"></span>
                    <div class="figcaption">
                      '.wpautop(htmlspecialchars_decode($content)).'
                    </div>
                  '.$after.'
                </div>';
	}
	
	return $output;
}
add_shortcode( 'thebear_collection_banner', 'novafw_collection_banner_shortcode' );

/**
 * The VC Functions
 */
function novafw_collection_banner_shortcode_vc() {
	

	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Effect Banner", 'thebear'),
			"base" => "thebear_effect_banner",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Collection Image", 'thebear'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Collection Title", 'thebear'),
					"param_name" => "title"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Collection Sub Title", 'thebear'),
					"param_name" => "sub_title"
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Banner Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Standard' => 'standard',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link URL", 'thebear'),
					"param_name" => "link",
					'description' => 'Leave blank not to link block, enter URL to link entire block'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Title", 'thebear'),
					"param_name" => "link_title",
					'description' => 'Leave blank not to link block, enter URL to link entire block'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Target Attribute", 'thebear'),
					"param_name" => "target"
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_collection_banner_shortcode_vc' );
