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