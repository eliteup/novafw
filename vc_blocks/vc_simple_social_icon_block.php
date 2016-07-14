<?php 

/**
 * The Shortcode
 */
function novafw_simple_social_icon_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => '',
				'url' => ''
			), $atts 
		) 
	);
	
	$output = '
		<ul>
		    <li>
		        <a href="'. esc_url($url) .'" target="_blank">
		            <h6 class="uppercase">
		                <i class="'. esc_attr($icon) .'">&nbsp;</i> '. $title .'</h6>
		        </a>
		    </li>
		</ul>
	';
	
	return $output;
}
add_shortcode( 'thebear_simple_social_icon', 'novafw_simple_social_icon_shortcode' );

/**
 * The VC Functions
 */
function novafw_simple_social_icon_shortcode_vc() {
	
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Simple Social Icon", 'thebear'),
			"base" => "thebear_simple_social_icon",
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
					"type" => "textfield",
					"heading" => esc_html__("Link URL", 'thebear'),
					"param_name" => "url",
					'description' => 'e.g: http://twitter.com/madeinnovafw',
					'holder' => 'div',
				)
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_simple_social_icon_shortcode_vc' );