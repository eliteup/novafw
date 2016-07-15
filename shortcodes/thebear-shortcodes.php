<?php 

if(!( function_exists('novafw_thebear_button') )){
	function novafw_thebear_button( $atts ){
		extract(shortcode_atts(array(
			'url' => '#',
		    'appearance' => 'btn-primary',
		    'target' => '_self',
		    'text' => 'Default Button Text'
		), $atts ));
		
		if( 'default' == $target )
			$target = '_self';
			
		return '<a href="'. esc_url($url) .'" class="btn '. $appearance .'" target="'. $target .'">'. htmlspecialchars_decode($text) .'</a>';
	}
	add_shortcode('thebear_button','novafw_thebear_button');
}

if(!( function_exists('novafw_thebear_icon') )){
	function novafw_thebear_icon( $atts ){
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => ''
		), $atts ));
		return '<i class="icon '. $icon.' '. $size .'"></i>';
	}
	add_shortcode('thebear_icon','novafw_thebear_icon');
}

if(!( function_exists('novafw_thebear_skill') )){
	function novafw_thebear_skill( $atts ){
		extract(shortcode_atts(array(
			'icon' => '',
			'title' => ''
		), $atts ));
		return '<div class="col-sm-4"><i class="icon '. $icon .' text-white"></i><h2 class="text-white">'. htmlspecialchars_decode($title) .'</h2></div>';
	}
	add_shortcode('thebear_skill','novafw_thebear_skill');
}

if(!( function_exists('novafw_thebear_countdown') )){
	function novafw_thebear_countdown( $atts ){
		extract(shortcode_atts(array(
			'date' => '2016/02/02',
		), $atts ));
		return '<div class="countdown" data-date="'. $date .'"></div>';
	}
	add_shortcode('thebear_countdown','novafw_thebear_countdown');
}
if(!( function_exists('novafw_thebear__socials') )) {
	function novafw_thebear_socials($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"items_align" => 'left'
		), $atts));
		ob_start();
		?>

		<div class="socials">
			<ul class="<?php echo esc_html($items_align); ?>">
				<?php if (get_option('thebear_facebook_link', 'http://facebook.com')) { ?>
					<li class="site-social-icons-facebook"><a target="_blank"
															  href="<?php echo esc_url(get_option('thebear_facebook_link', 'http://facebook.com')); ?>"><i
							class="fa fa-facebook"></i><span>Facebook</span></a></li><?php } ?>
				<?php if (get_option('thebear_twitter_link', 'http://twitter.com')) { ?>
					<li class="site-social-icons-twitter"><a target="_blank"
															 href="<?php echo esc_url(get_option('thebear_twitter_link', 'http://twitter.com')); ?>"><i
							class="fa fa-twitter"></i><span>Twitter</span></a></li><?php } ?>
				<?php if (get_option('thebear_pinterest_link', 'http://pinterest.com')) { ?>
					<li class="site-social-icons-pinterest"><a target="_blank"
															   href="<?php echo esc_url(get_option('thebear_pinterest_link', 'http://pinterest.com')); ?>"><i
							class="fa fa-pinterest"></i><span>Pinterest</span></a></li><?php } ?>
				<?php if (get_option('thebear_linkedin_link')) { ?>
					<li class="site-social-icons-linkedin"><a target="_blank"
															  href="<?php echo esc_url(get_option('thebear_linkedin_link')); ?>"><i
							class="fa fa-linkedin"></i><span>LinkedIn</span></a></li><?php } ?>
				<?php if (get_option('thebear_googleplus_link')) { ?>
					<li class="site-social-icons-googleplus"><a target="_blank"
																href="<?php echo esc_url(get_option('thebear_googleplus_link')); ?>"><i
							class="fa fa-google-plus"></i><span>Google+</span></a></li><?php } ?>
				<?php if (get_option('thebear_rss_link')) { ?>
					<li class="site-social-icons-rss"><a target="_blank"
														 href="<?php echo esc_url(get_option('thebear_rss_link')); ?>"><i
							class="fa fa-rss"></i><span>RSS</span></a></li><?php } ?>
				<?php if (get_option('thebear_tumblr_link')) { ?>
					<li class="site-social-icons-tumblr"><a target="_blank"
															href="<?php echo esc_url(get_option('thebear_tumblr_link')); ?>"><i
							class="fa fa-tumblr"></i><span>Tumblr</span></a></li><?php } ?>
				<?php if (get_option('thebear_instagram_link', 'http://instagram.com')) { ?>
					<li class="site-social-icons-instagram"><a target="_blank"
															   href="<?php echo esc_url(get_option('thebear_instagram_link', 'http://instagram.com')); ?>"><i
							class="fa fa-instagram"></i><span>Instagram</span></a></li><?php } ?>
				<?php if (get_option('thebear_youtube_link', 'http://youtube.com')) { ?>
					<li class="site-social-icons-youtube"><a target="_blank"
															 href="<?php echo esc_url(get_option('thebear_youtube_link', 'http://youtube.com')); ?>"><i
							class="fa fa-youtube-play"></i><span>Youtube</span></a></li><?php } ?>
				<?php if (get_option('thebear_vimeo_link')) { ?>
					<li class="site-social-icons-vimeo"><a target="_blank"
														   href="<?php echo esc_url(get_option('thebear_vimeo_link')); ?>"><i
							class="fa fa-vimeo-square"></i><span>Vimeo</span></a></li><?php } ?>
				<?php if (get_option('thebear_behance_link')) { ?>
					<li class="site-social-icons-behance"><a target="_blank"
															 href="<?php echo esc_url(get_option('thebear_behance_link')); ?>"><i
							class="fa fa-behance"></i><span>Behance</span></a></li><?php } ?>
				<?php if (get_option('thebear_dribble_link')) { ?>
					<li class="site-social-icons-dribbble"><a target="_blank"
															  href="<?php echo esc_url(get_option('thebear_dribble_link')); ?>"><i
							class="fa fa-dribbble"></i><span>Dribbble</span></a></li><?php } ?>
				<?php if (get_option('thebear_flickr_link')) { ?>
					<li class="site-social-icons-flickr"><a target="_blank"
															href="<?php echo esc_url(get_option('thebear_flickr_link')); ?>"><i
							class="fa fa-flickr"></i><span>Flickr</span></a></li><?php } ?>
				<?php if (get_option('thebear_git_link')) { ?>
					<li class="site-social-icons-git"><a target="_blank"
														 href="<?php echo esc_url(get_option('thebear_git_link')); ?>"><i
							class="fa fa-git"></i><span>Git</span></a></li><?php } ?>
				<?php if (get_option('thebear_skype_link')) { ?>
					<li class="site-social-icons-skype"><a target="_blank"
														   href="<?php echo esc_html(get_option('thebear_skype_link')); ?>"><i
							class="fa fa-skype"></i><span>Skype</span></a></li><?php } ?>
				<?php if (get_option('thebear_weibo_link')) { ?>
					<li class="site-social-icons-weibo"><a target="_blank"
														   href="<?php echo esc_url(get_option('thebear_weibo_link')); ?>"><i
							class="fa fa-weibo"></i><span>Weibo</span></a></li><?php } ?>
				<?php if (get_option('thebear_foursquare_link')) { ?>
					<li class="site-social-icons-foursquare"><a target="_blank"
																href="<?php echo esc_url(get_option('thebear_foursquare_link')); ?>"><i
							class="fa fa-foursquare"></i><span>Foursquare</span></a></li><?php } ?>
				<?php if (get_option('thebear_soundcloud_link')) { ?>
					<li class="site-social-icons-soundcloud"><a target="_blank"
																href="<?php echo esc_url(get_option('thebear_soundcloud_link')); ?>"><i
							class="fa fa-soundcloud"></i><span>Soundcloud</span></a></li><?php } ?>
			</ul>
		</div>

		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	add_shortcode("thebear_socials", "novafw_thebear_socials");
}
if (class_exists('WPBakeryVisualComposerAbstract')) {
	if (!(function_exists('novafw_icons_settings_field'))) {
		function novafw_icons_settings_field($settings, $value)
		{

			$icons = $settings['value'];

			$output = '<a href="#" id="novafw-icon-toggle" class="button button-primary button-large">Show/Hide Icons</a><div class="novafw-icons"><div class="novafw-icons-wrapper">';
			foreach ($icons as $icon) {
				$active = ($value == $icon) ? ' active' : '';
				$output .= '<i class="icon ' . $icon . $active . '" data-icon-class="' . $icon . '"></i>';
			}
			$output .= '</div><input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput novafw-icon-value ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" />' . '</div>';

			return $output;
		}

		vc_add_shortcode_param('novafw_icons', 'novafw_icons_settings_field');
	}
}