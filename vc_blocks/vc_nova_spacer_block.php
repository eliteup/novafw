<?php
/**
 * The Shortcode
 */
function novafw_nova_spacer_shortcode( $atts, $content = null ) {
	$height = $output = $height_on_tabs = $height_on_mob = '';
	extract(shortcode_atts(array(
		"height" => "",
		"height_on_tabs" => "",
		"height_on_tabs_portrait" => "",
		"height_on_mob" => "",
		"height_on_mob_landscape" => ""
	),$atts));
	if($height_on_mob == "" && $height_on_tabs == "")
		$height_on_mob = $height_on_tabs = $height;
	$style = 'clear:both;';
	$style .= 'display:block;';
	$uid = uniqid();
	$output .= '<div class="nova-spacer spacer-'.$uid.'" data-id="'.$uid.'" data-height="'.$height.'" data-height-mobile="'.$height_on_mob.'" data-height-tab="'.$height_on_tabs.'" data-height-tab-portrait="'.$height_on_tabs_portrait.'" data-height-mobile-landscape="'.$height_on_mob_landscape.'" style="'.$style.'"></div>';
	return $output;
}
add_shortcode( 'thebear_nova_spacer', 'novafw_nova_spacer_shortcode' );

/**
 * The VC Functions
 */
function novafw_nova_spacer_shortcode_vc( $atts, $content = null ) {
	vc_map(
		array(
			"name" => esc_html__("Spacer / Gap","thebear"),
			"base" => "thebear_nova_spacer",
			"class" => "thebear_nova_spacer",
			"icon" => "thebear-vc-block",
			"category" => "Thebear WP Theme",
			"description" => esc_html__("Adjust space between components.","thebear"),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("<i class='dashicons dashicons-desktop'></i> Desktop", "thebear"),
					"param_name" => "height",
					"admin_label" => true,
					"value" => 10,
					"min" => 1,
					"max" => 500,
					"suffix" => "px",
					"description" => esc_html__("Enter value in pixels", "thebear"),
					//"edit_field_class" => "vc_col-sm-4 vc_column"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("<i class='dashicons dashicons-tablet' style='transform: rotate(90deg);'></i> Tabs", "thebear"),
					"param_name" => "height_on_tabs",
					"admin_label" => true,
					"value" => '',
					"min" => 1,
					"max" => 500,
					"suffix" => "px",
					"description" => esc_html__("Enter value in pixels", "thebear"),
					"edit_field_class" => "vc_col-sm-3 vc_column"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("<i class='dashicons dashicons-tablet'></i> Tabs", "thebear"),
					"param_name" => "height_on_tabs_portrait",
					"admin_label" => true,
					"value" => '',
					"min" => 1,
					"max" => 500,
					"suffix" => "px",
					"description" => esc_html__("Enter value in pixels", "thebear"),
					"edit_field_class" => "vc_col-sm-3 vc_column"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg);'></i> Mobile", "thebear"),
					"param_name" => "height_on_mob_landscape",
					"admin_label" => true,
					"value" => '',
					"min" => 1,
					"max" => 500,
					"suffix" => "px",
					"description" => esc_html__("Enter value in pixels", "thebear"),
					"edit_field_class" => "vc_col-sm-3 vc_column"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("<i class='dashicons dashicons-smartphone'></i> Mobile", "thebear"),
					"param_name" => "height_on_mob",
					"admin_label" => true,
					"value" => '',
					"min" => 1,
					"max" => 500,
					"suffix" => "px",
					"description" => esc_html__("Enter value in pixels", "thebear"),
					"edit_field_class" => "vc_col-sm-3 vc_column"
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'novafw_nova_spacer_shortcode_vc' );