<?php 

/**
 * The Shortcode
 */
function novafw_feature_list_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'text' => ''
			), $atts 
		) 
	);
	
	$lines = explode( ',', $text );
	
	ob_start();
?>

	<div class="feature bordered mb__0">
	    <ul class="mb__0">
	    
	    	<?php 
	    		foreach( $lines as $line ){
	    			$details = explode('**', $line);
	    			echo '<li class="overflow-hidden">';
	    			
	    			if( isset($details[0]) )
	    				echo '<span class="pull-left">'. $details[0] .'</span>';
	    				
	    			if( isset($details[1]) )
	    				echo '<h6 class="pull-right uppercase">'. $details[1] .'</h6>';
	    				
	    			echo '</li>';
	    		}
	    		
	    	?>
	        
	    </ul>
	</div>
			
<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
add_shortcode( 'thebear_feature_list', 'novafw_feature_list_shortcode' );

/**
 * The VC Functions
 */
function novafw_feature_list_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Feature Table", 'thebear'),
			"base" => "thebear_feature_list",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "exploded_textarea",
					"heading" => esc_html__("Feature Details", 'thebear'),
					"param_name" => "text",
					"description" => '1 Feature Per Line, separate feature title & details with a double asterisk, e.g: Title**The Great Escape',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_feature_list_shortcode_vc' );