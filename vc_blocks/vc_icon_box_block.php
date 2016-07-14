<?php 

/**
 * The Shortcode
 */
function novafw_icon_box_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => '',
				'layout' => 'standard',
				'link' => '',
				'target' => ''
			), $atts 
		) 
	);
	
	$before = ( $link ) ? '<a href="'. esc_url($link) .'" target="'. esc_attr($target) .'">' : false;
	$after = ( $link ) ? '</a>' : false;
	
	if( '' == $icon )
		$icon = 'none';

	$output = '<div class="eliteup-iconbox '.$layout.'">
			'. $before .'
              <div class="eliteup-iconbox-icon"><i class="'. esc_attr($icon) .'"></i></div>
              <h3 class="eliteup-iconbox-heading">'. htmlspecialchars_decode($title) .'</h3>
              <div class="eliteup-iconbox-description">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
              '. $after .'
            </div>';
	return $output;
}
add_shortcode( 'thebear_icon_box', 'novafw_icon_box_shortcode' );

/**
 * The VC Functions
 */
function novafw_icon_box_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Icon Box", 'thebear'),
			"base" => "thebear_icon_box",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "novafw_icons",
					"heading" => esc_html__("Click an Icon to choose", 'thebear'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'thebear'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Icon Box Display Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Standard' => 'standard',
						'Medium' => 'medium',
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
					"heading" => esc_html__("Link Target Attribute", 'thebear'),
					"param_name" => "target"
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_icon_box_shortcode_vc' );