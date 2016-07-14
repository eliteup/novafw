<?php 

/**
 * The Shortcode
 */
function novafw_page_title_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => '',
				'layout' => 'left-short-grey',
				'image' => '',
				'subtitle' => ''
			), $atts 
		) 
	);
	
	$icon = ($icon) ? '<i class="'. esc_attr($icon) .'"></i>' : false;
	$image = ($image) ? wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) : false;
	
	if( 'left-short-light' == $layout ){
		$output = novafw_page_title( $title, false, $icon );	
	} elseif( 'left-short-grey' == $layout ){
		$output = novafw_page_title( $title, 'bg-secondary', $icon );	
	} elseif( 'left-short-dark' == $layout ){
		$output = novafw_page_title( $title, 'bg-dark', $icon );	
	} elseif( 'left-short-image' == $layout ) {
		$output = novafw_page_title( $title, 'image-bg overlay', $icon, $image );	
	} elseif( 'left-short-parallax' == $layout ) {
		$output = novafw_page_title( $title, 'image-bg overlay parallax', $icon, $image );	
	} elseif( 'left-large-light' == $layout ){
		$output = novafw_page_title_large( $title, $subtitle, false, $icon );	
	} elseif( 'left-large-grey' == $layout ){
		$output = novafw_page_title_large( $title, $subtitle, 'bg-secondary', $icon );	
	} elseif( 'left-large-dark' == $layout ){
		$output = novafw_page_title_large( $title, $subtitle, 'bg-dark', $icon );	
	} elseif( 'left-large-image' == $layout ){
		$output = novafw_page_title_large( $title, $subtitle, 'image-bg overlay', $icon, $image );	
	} elseif( 'left-large-parallax' == $layout ){
		$output = novafw_page_title_large( $title, $subtitle, 'image-bg overlay parallax', $icon, $image );	
	} elseif( 'center-short-light' == $layout ){
		$output = novafw_page_title_center( $title, false, $icon );	
	} elseif( 'center-short-grey' == $layout ){
		$output = novafw_page_title_center( $title, 'bg-secondary', $icon );	
	} elseif( 'center-short-dark' == $layout ){
		$output = novafw_page_title_center( $title, 'bg-dark', $icon );	
	} elseif( 'center-short-image' == $layout ) {
		$output = novafw_page_title_center( $title, 'image-bg overlay', $icon, $image );	
	} elseif( 'center-short-parallax' == $layout ) {
		$output = novafw_page_title_center( $title, 'image-bg overlay parallax', $icon, $image );	
	} elseif( 'center-large-light' == $layout ){
		$output = novafw_page_title_large_center( $title, $subtitle, false, $icon );	
	} elseif( 'center-large-grey' == $layout ){
		$output = novafw_page_title_large_center( $title, $subtitle, 'bg-secondary', $icon );	
	} elseif( 'center-large-dark' == $layout ){
		$output = novafw_page_title_large_center( $title, $subtitle, 'bg-dark', $icon );	
	} elseif( 'center-large-image' == $layout ){
		$output = novafw_page_title_large_center( $title, $subtitle, 'image-bg overlay', $icon, $image );	
	} elseif( 'center-large-parallax' == $layout ){
		$output = novafw_page_title_large_center( $title, $subtitle, 'image-bg overlay parallax', $icon, $image );	
	}
	
	return $output;
}
add_shortcode( 'thebear_page_title', 'novafw_page_title_shortcode' );

/**
 * The VC Functions
 */
function novafw_page_title_shortcode_vc() {
	
	$title_layouts = novafw_get_page_title_options();
	$icons = novafw_get_icons();
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Page Title", 'thebear'),
			"base" => "thebear_page_title",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
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
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Page Title Background Image", 'thebear'),
					"param_name" => "image"
				),
				array(
					"type" => "novafw_icons",
					"heading" => esc_html__("Click an Icon to choose", 'thebear'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Page Title Display Type", 'thebear'),
					"param_name" => "layout",
					"value" => $title_layouts
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_page_title_shortcode_vc' );