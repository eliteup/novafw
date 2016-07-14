<?php 

/**
 * The Shortcode
 */
function novafw_text_image_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'layout' => 'offscreen-left'
			), $atts 
		) 
	);
	
	if( 'offscreen-left' == $layout ){
		
		$output = '
			<section class="image-edge">
			    <div class="col-md-6 col-sm-4 p__0">
			    	'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .'
			    </div>
			    <div class="container">
			        <div class="col-md-5 col-md-offset-1 col-sm-7 col-sm-offset-1 v-align-transform right">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';
		
	} elseif( 'offscreen-right' == $layout ) {
	
		$output = '
			<section class="image-edge">
			    <div class="col-md-6 col-sm-4 p__0 col-md-push-6 col-sm-push-8">
			        '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .'
			    </div>
			    <div class="container">
			        <div class="col-md-5 col-md-pull-0 col-sm-7 col-sm-pull-4 v-align-transform">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';
	
	} elseif( 'shadow-left' == $layout ) {
	
		$output = '
			<section>
			    <div class="container">
			        <div class="row v-align-children">
			            <div class="col-md-7 col-sm-6 text-center mb-xs-24">
			                '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'cast-shadow') ) .'
			            </div>
			            <div class="col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1">
			                '. do_shortcode($content) .'
			            </div>
			        </div>
			    </div>
			</section>
		';
	
	} elseif( 'shadow-right' == $layout ) {
	
		$output = '
			<section>
			    <div class="container">
			        <div class="row v-align-children">
			            <div class="col-md-4 col-sm-5 mb-xs-24">
			                '. do_shortcode($content) .'
			            </div>
			            <div class="col-md-7 col-md-offset-1 col-sm-6 col-sm-offset-1 text-center">
			                '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'cast-shadow') ) .'
			            </div>
			        </div>
			    </div>
			</section>
		';
	
	} elseif( 'box-left' == $layout ) {
	
		$output = '
			<section class="image-square left">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 col-md-offset-1 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';
	
	} elseif( 'box-right' == $layout ) {
	
		$output = '
			<section class="image-square right">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';
	
	}
	
	return $output;
}
add_shortcode( 'thebear_text_image', 'novafw_text_image_shortcode' );

/**
 * The VC Functions
 */
function novafw_text_image_shortcode_vc() {
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
		    'name'                    => esc_html__( 'Text & Image' , 'thebear' ),
		    'base'                    => 'thebear_text_image',
		    'description'             => esc_html__( 'Create fancy images & text', 'thebear' ),
		    'as_parent'               => array('except' => 'thebear_tabs_content'),
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Thebear WP Theme', 'thebear'),
		    'params' => array(
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Block Image", 'thebear'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Image & Text Display Type", 'thebear'),
		    		"param_name" => "layout",
		    		"value" => array(
		    			'Offscreen Image Left' => 'offscreen-left',
		    			'Offscreen Image Right' => 'offscreen-right',
		    			'Shadow Image Left' => 'shadow-left',
		    			'Shadow Image Right' => 'shadow-right',
		    			'Boxed Image Left' => 'box-left',
		    			'Boxed Image Right' => 'box-right'
		    		)
		    	),
		    )
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_text_image_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_thebear_text_image extends WPBakeryShortCodesContainer {

    }
}