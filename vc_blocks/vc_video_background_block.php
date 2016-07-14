<?php 

/**
 * The Shortcode
 */
function novafw_video_background_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'local',
				'image' => '',
				'video' => '',
				'mpfour' => '',
				'ogv' => '',
				'webm' => '',
				'embed' => ''
			), $atts 
		) 
	);
	
	$output = '<section class="image-bg fullscreen overlay bg-dark vid-bg">';
	
	if( 'embed' == $layout ){		
		$output .= '<div class="player" data-video-id="'. esc_attr($embed) .'" data-start-at="0"></div>';
	}
			
	$output .= '
		<div class="background-image-holder">
	        '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
	    </div>
	';
	
	if(!( 'local' == $layout )){
		$output .= '
			<div class="masonry-loader">
				<div class="spinner"></div>
			</div>
		';	
	}
	
	if( 'local' == $layout ){		    
		$output .= '
			<div class="fs-vid-background">
		        <video autoplay muted loop>
		            <source src="'. esc_url($webm) .'" type="video/webm">
		            <source src="'. esc_url($mpfour) .'" type="video/mp4">
		            <source src="'. esc_url($ogv) .'" type="video/ogg">	
		        </video>
		    </div>
		';
	}
		
	$output .= '    
		    <div class="container v-align-transform">
		        <div class="row">
		            <div class="col-sm-10 col-sm-offset-1">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
		        </div>
		    </div>
		    
		</section>
	';
	
	return $output;
}
add_shortcode( 'thebear_video_background', 'novafw_video_background_shortcode' );

/**
 * The VC Functions
 */
function novafw_video_background_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Video Background", 'thebear'),
			"base" => "thebear_video_background",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Video Display Type", 'thebear'),
					"param_name" => "layout",
					"value" => array(
						'Local Video' => 'local',
						'Embedded Video (Youtube only!)' => 'embed'
					)
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Video Placeholder Image", 'thebear'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .webm extension", 'thebear'),
					"param_name" => "webm",
					"description" => esc_html__('Please fill all extensions', 'thebear')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .mp4 extension", 'thebear'),
					"param_name" => "mpfour",
					"description" => esc_html__('Please fill all extensions', 'thebear')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .ogv extension", 'thebear'),
					"param_name" => "ogv",
					"description" => esc_html__('Please fill all extensions', 'thebear')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Youtube Embed ID", 'thebear'),
					"param_name" => "embed",
					'description' => 'Enter only the ID of your youtube video, e.g: dmgomCutGqc'
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'thebear'),
					"param_name" => "content"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_video_background_shortcode_vc' );