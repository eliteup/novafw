<?php 

/**
 * The Shortcode
 */
function novafw_alert_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'warning'
			), $atts 
		) 
	);
	
	if( 'success' == $type ){
		
		$output = '
			<div class="alert alert-success alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			        <span aria-hidden="true">&times;</span>
			    </button>
			    '. htmlspecialchars_decode($content) .'
			</div>
		';
		
	} elseif( 'danger' == $type ){
		
		$output = '
			<div class="alert alert-danger alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			        <span aria-hidden="true">&times;</span>
			    </button>
			    '. htmlspecialchars_decode($content) .'
			</div>
		';
		
	} elseif( 'warning' == $type ){
		
		$output = '
			<div class="alert alert-warning alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			        <span aria-hidden="true">&times;</span>
			    </button>
			    '. htmlspecialchars_decode($content) .'
			</div>
		';
		
	}

	return $output;
}
add_shortcode( 'thebear_alert_block', 'novafw_alert_block_shortcode' );

/**
 * The VC Functions
 */
function novafw_alert_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Alert Bar", 'thebear'),
			"base" => "thebear_alert_block",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			'description' => 'An alert bar ideal for drawing attention.',
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Alert Content", 'thebear'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					'type' => 'dropdown',
					'heading' => "Display Type",
					'param_name' => 'type',
					'value' => array(
						'Warning' => 'warning',
						'Danger' => 'danger',
						'Success' => 'success'
					),
					'description' => "Choose a display style for this alert."
				)
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_alert_block_shortcode_vc' );