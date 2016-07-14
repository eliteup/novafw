<?php
/**
 * The Shortcode
 */
function novafw_nova_gallery_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'images' => '',
				'title' => '',
				'thumb_width' => '200',
				'thumb_height' => '200',
				'el_class' => '',
			), $atts
		)
	);
	$thumb_width = 200;
	$thumb_height = 200;
	$images = explode( ',', $images );
	$output = '';
	$output .= '<div class="more-pictures small-up-2 medium-up-4 large-up-4 clearfix">';
	foreach ( $images as $i => $image ) {
		$img = wpb_getImageBySize( array( 'attach_id' => $image) );
		$large_img_src = $img['p_img_large'][0];
		$thumbnail = aq_resize( $large_img_src, $thumb_width, $thumb_height, true, true, true );
		$output .= '<div class="column"><a href="'.$large_img_src.'" data-rel="lightcase:nova_gallery:slideshow" class="more-picture"><img src="'.$thumbnail.'" alt="TheBear"></a></div>';
	}
	$output .= '</div>';

	return $output;
}
add_shortcode( 'thebear_nova_gallery', 'novafw_nova_gallery_shortcode' );

/**
 * The VC Functions
 */
function novafw_nova_gallery_shortcode_vc( $atts, $content = null ) {
	vc_map(
		array(
			'name' => esc_html__( 'Nova Gallery', 'thebear' ),
			'base' => 'thebear_nova_gallery',
			'icon' => 'thebear-vc-block',
			'category' => esc_html__( 'Thebear WP Theme', 'thebear' ),
			'description' => esc_html__( 'Responsive image gallery', 'thebear' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'thebear' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'thebear' ),
				),
				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'thebear' ),
					'param_name' => 'images',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'thebear' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image Width', 'thebear' ),
					'param_name' => 'thumb_width',
					'value' => '200',
					'description' => esc_html__( 'Enter image size in pixels.', 'thebear' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image Height', 'thebear' ),
					'param_name' => 'thumb_height',
					'value' => '',
					'description' => esc_html__( 'Enter image size in pixels.', 'thebear' ),
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'thebear' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'thebear' ),
				),
			),
		)
	);
}
add_action( 'vc_before_init', 'novafw_nova_gallery_shortcode_vc' );