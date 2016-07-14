<?php 

/**
 * The Shortcode
 */
function novafw_sharing_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	ob_start();
?>

	<?php
		global $post;
		
		$url[] = '';
		$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	?>
	
	<div class="row">
	    <div class="col-md-6 col-md-offset-3 text-center">
	    
	        <h6 class="uppercase"><?php echo htmlspecialchars_decode($title); ?></h6>
	        
	        <ul class="social-list list-inline">
	            <li>
	                <a target="_blank" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onClick="return novafw_tweet()">
	                    <i class="ti-twitter-alt icon icon-sm"></i>
	                </a>
	            </li>
	            <li>
	                <a target="_blank" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onClick="return novafw_fb_like()">
	                    <i class="ti-facebook icon icon-sm"></i>
	                </a>
	            </li>
	            <li>
	                <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" onClick="return novafw_pin()">
	                    <i class="ti-pinterest icon icon-sm"></i>
	                </a>
	            </li>
	        </ul>
	        
	    </div>
	</div>
	
	<script type="text/javascript">
		function novafw_fb_like() {
			window.open('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
			return false;
		}
		function novafw_tweet() {
			window.open('https://twitter.com/share?url=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
			return false;
		}
		function novafw_pin() {
			window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($url[0]); ?>&description=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
			return false;
		}
	</script>

<?php	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}
add_shortcode( 'thebear_sharing', 'novafw_sharing_shortcode' );

/**
 * The VC Functions
 */
function novafw_sharing_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Simple Post Sharing", 'thebear'),
			"base" => "thebear_sharing",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Buttons Title", 'thebear'),
					"param_name" => "title"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'novafw_sharing_shortcode_vc' );