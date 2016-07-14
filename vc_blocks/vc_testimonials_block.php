<?php 

/**
 * The Shortcode
 */
function novafw_testimonial_carousel_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'pppage' => '999',
				'filter' => 'all',
				'layout' => 'carousel'
			), $atts 
		) 
	);
	
	/**
	 * Initial query args
	 */
	$query_args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => $pppage
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'testimonial_category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial_category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}
	
	/**
	 * Finally, here's the query.
	 */
	$block_query = new WP_Query( $query_args );
	
	ob_start();
	
	if( 'carousel' == $layout ) : 
?>
	
	<div class="testimonials text-slider slider-arrow-controls text-center">
	    <ul class="slides">
	        <?php 
	        	if ( $block_query->have_posts() ) : while ( $block_query->have_posts() ) : $block_query->the_post(); 
	        	
	        		get_template_part('loop/content-testimonial', 'carousel');
	        	
	        	endwhile;
	        	else : 
	        		
	        		get_template_part('loop/content', 'none');
	        				
	        	endif;
	        ?>
	    </ul>
	</div>
<?php elseif( 'list' == $layout ) : ?>

		<div class="testimonial-box-holder">
			<h2><i class="nc-icon-outline text_quote"></i></h2>
			<?php
			if ( $block_query->have_posts() ) : while ( $block_query->have_posts() ) : $block_query->the_post();

				get_template_part('loop/content-testimonial', 'list');

			endwhile;
			else :

				get_template_part('loop/content', 'none');

			endif;
			?>
		</div>
<?php elseif( 'grid' == $layout ) : ?>

	<div class="row">
		<?php 
			if ( $block_query->have_posts() ) : while ( $block_query->have_posts() ) : $block_query->the_post(); 

				get_template_part('loop/content-testimonial', 'grid');
				
				if( ($block_query->current_post + 1) % 3 == 0 ){
					echo '</div><div class="row">';
				}
			
			endwhile;
			else : 
				
				get_template_part('loop/content', 'none');
						
			endif;
		?>
	</div>

<?php else : ?>

	<?php 
		if ( $block_query->have_posts() ) : while ( $block_query->have_posts() ) : $block_query->the_post(); 
		
			get_template_part('loop/content-testimonial', 'box');
		
		endwhile;
		else : 
			
			get_template_part('loop/content', 'none');
					
		endif;
	?>
			
<?php	
	endif;
	
	wp_reset_postdata();
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}
add_shortcode( 'thebear_testimonial_carousel', 'novafw_testimonial_carousel_shortcode' );

/**
 * The VC Functions
 */
function novafw_testimonial_carousel_shortcode_vc() {
	
	$testimonial_types = array(
		'Carousel' => 'carousel',
		'Boxed' => 'boxed',
		'Grid' => 'grid',
		'List' => 'list'
	);
	
	vc_map( 
		array(
			"icon" => 'thebear-vc-block',
			"name" => esc_html__("Testimonials", 'thebear'),
			"base" => "thebear_testimonial_carousel",
			"category" => esc_html__('Thebear WP Theme', 'thebear'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'thebear'),
					"param_name" => "pppage",
					"value" => '8',
					"description" => ''
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display type", 'thebear'),
					"param_name" => "layout",
					"value" => $testimonial_types
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'novafw_testimonial_carousel_shortcode_vc');